<?php

namespace Tests\Feature;

use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EvaluationFeatureSeeder;
use Database\Seeders\InquiryRfpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetCodeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(InquiryRfpSeeder::class);
        $this->seed(EvaluationFeatureSeeder::class);
    }

    public function test_forgot_password_request_page_renders_properly(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Pembaruan');
        $response->assertSee('Kata Sandi');
        $response->assertSee('Kirim Kode Verifikasi ke Email');
    }

    public function test_sending_verification_code_stores_6_digit_token_and_sends_mail(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Ferry Gunawan',
            'email' => 'ferry.gunawan@example.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => 'ferry.gunawan@example.com',
        ]);

        $response->assertRedirect(route('password.verify', ['email' => 'ferry.gunawan@example.com']));
        $response->assertSessionHas('success');

        Mail::assertSent(PasswordResetCodeMail::class, function (PasswordResetCodeMail $mail) use ($user) {
            return $mail->hasTo($user->email) && strlen($mail->code) === 6;
        });

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'ferry.gunawan@example.com',
        ]);
    }

    public function test_sending_verification_code_fails_with_unregistered_email(): void
    {
        Mail::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'tidak.terdaftar@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
        Mail::assertNothingSent();
    }

    public function test_stage_1_verification_page_renders_with_code_input_only(): void
    {
        $response = $this->get(route('password.verify', ['email' => 'klien@example.com']));

        $response->assertStatus(200);
        $response->assertSee('Tahap 1 dari 2');
        $response->assertSee('klien@example.com');
        $response->assertSee('KODE VERIFIKASI EMAIL (6 DIGIT)');
        $response->assertSee('Verifikasi Kode & Lanjutkan');
        // Does NOT show the new password inputs in Stage 1!
        $response->assertDontSee('Konfirmasi Kata Sandi Baru');
    }

    public function test_stage_1_verification_fails_with_invalid_code(): void
    {
        User::create([
            'name' => 'Doni Salman',
            'email' => 'doni@example.com',
            'phone_number' => '081234567891',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        DB::table('password_reset_tokens')->insert([
            'email' => 'doni@example.com',
            'token' => '123456',
            'created_at' => now(),
        ]);

        $response = $this->post(route('password.verify.submit'), [
            'email' => 'doni@example.com',
            'code' => '999999', // Wrong code
        ]);

        $response->assertSessionHasErrors(['code']);
        $this->assertNull(session('password_reset_verified_email'));
    }

    public function test_stage_1_verification_fails_with_expired_code(): void
    {
        User::create([
            'name' => 'Maya Sari',
            'email' => 'maya@example.com',
            'phone_number' => '081234567892',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        // Insert code created 20 minutes ago
        DB::table('password_reset_tokens')->insert([
            'email' => 'maya@example.com',
            'token' => '654321',
            'created_at' => now()->subMinutes(20),
        ]);

        $response = $this->post(route('password.verify.submit'), [
            'email' => 'maya@example.com',
            'code' => '654321',
        ]);

        $response->assertSessionHasErrors(['code']);
    }

    public function test_stage_1_verification_succeeds_and_unlocks_stage_2_reset_form(): void
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'phone_number' => '081234567893',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        DB::table('password_reset_tokens')->insert([
            'email' => 'budi.santoso@example.com',
            'token' => '112233',
            'created_at' => now(),
        ]);

        $response = $this->post(route('password.verify.submit'), [
            'email' => 'budi.santoso@example.com',
            'code' => '112233',
        ]);

        $response->assertRedirect(route('password.reset'));
        $this->assertEquals('budi.santoso@example.com', session('password_reset_verified_email'));

        // Follow redirect to Stage 2
        $stage2Response = $this->get(route('password.reset'));
        $stage2Response->assertStatus(200);
        $stage2Response->assertSee('Tahap 2 dari 2');
        $stage2Response->assertSee('budi.santoso@example.com');
        $stage2Response->assertSee('Kata Sandi Baru');
        $stage2Response->assertSee('Konfirmasi Kata Sandi Baru');
    }

    public function test_stage_2_cannot_be_accessed_without_prior_code_verification(): void
    {
        // Direct access to Stage 2 without session verification
        $response = $this->get(route('password.reset'));

        $response->assertRedirect(route('password.verify'));
        $response->assertSessionHasErrors(['code']);
    }

    public function test_stage_2_resetting_password_fails_when_password_lacks_symbol_or_number(): void
    {
        User::create([
            'name' => 'Agus Pratama',
            'email' => 'agus@example.com',
            'phone_number' => '081234567894',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        DB::table('password_reset_tokens')->insert([
            'email' => 'agus@example.com',
            'token' => '334455',
            'created_at' => now(),
        ]);

        $this->withSession([
            'password_reset_verified_email' => 'agus@example.com',
            'password_reset_verified_code' => '334455',
        ]);

        $response = $this->post(route('password.update'), [
            'email' => 'agus@example.com',
            'password' => 'hanyahurufsaja',
            'password_confirmation' => 'hanyahurufsaja',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_stage_2_resetting_password_succeeds_and_updates_user_password(): void
    {
        $user = User::create([
            'name' => 'Wahyu Hidayat',
            'email' => 'wahyu@example.com',
            'phone_number' => '081234567895',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        DB::table('password_reset_tokens')->insert([
            'email' => 'wahyu@example.com',
            'token' => '556677',
            'created_at' => now(),
        ]);

        $this->withSession([
            'password_reset_verified_email' => 'wahyu@example.com',
            'password_reset_verified_code' => '556677',
        ]);

        $response = $this->post(route('password.update'), [
            'email' => 'wahyu@example.com',
            'password' => 'NewSecretPassword99#@',
            'password_confirmation' => 'NewSecretPassword99#@',
        ]);

        $response->assertRedirect(route('customer.login'));
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('NewSecretPassword99#@', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'wahyu@example.com',
        ]);
        $this->assertNull(session('password_reset_verified_email'));
    }

    public function test_customer_can_request_verification_code_from_dashboard(): void
    {
        Mail::fake();

        $user = User::create([
            'name' => 'Slamet Riyadi',
            'email' => 'slamet@example.com',
            'phone_number' => '081234567896',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('customer.password.send-code'));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(PasswordResetCodeMail::class, function (PasswordResetCodeMail $mail) use ($user) {
            return $mail->hasTo($user->email) && strlen($mail->code) === 6;
        });

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'slamet@example.com',
        ]);
    }

    public function test_customer_can_update_password_in_dashboard_using_email_verification_code(): void
    {
        $user = User::create([
            'name' => 'Joko Widodo',
            'email' => 'joko.widodo@example.com',
            'phone_number' => '081234567897',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'customer',
        ]);

        DB::table('password_reset_tokens')->insert([
            'email' => 'joko.widodo@example.com',
            'token' => '778899',
            'created_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('customer.profile.update'), [
            'name' => 'Joko Widodo',
            'phone_number' => '081234567897',
            'verification_code' => '778899', // Using OTP code instead of current password!
            'new_password' => 'NewBrandPassword2026!$',
            'new_password_confirmation' => 'NewBrandPassword2026!$',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('NewBrandPassword2026!$', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'joko.widodo@example.com',
        ]);
    }
}
