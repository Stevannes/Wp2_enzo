<?php

namespace Tests\Feature;

use App\Models\InquiryRfp;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EvaluationFeatureSeeder;
use Database\Seeders\InquiryRfpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(InquiryRfpSeeder::class);
        $this->seed(EvaluationFeatureSeeder::class);
    }

    public function test_customer_login_page_loads_with_email_and_password_inputs(): void
    {
        $response = $this->get(route('customer.login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk Akun');
        $response->assertSee('Alamat Email Terdaftar');
        $response->assertDontSee('Nomor Telepon / WhatsApp');
    }

    public function test_customer_registration_page_loads_with_email_and_phone_inputs(): void
    {
        $response = $this->get(route('customer.register'));

        $response->assertStatus(200);
        $response->assertSee('Registrasi Akun Klien Baru');
        $response->assertSee('Alamat Email Aktif');
        $response->assertSee('Nomor WhatsApp / HP');
    }

    public function test_customer_can_register_with_mandatory_email_and_phone_number(): void
    {
        $payload = [
            'name' => 'Bambang Sudiro',
            'email' => 'bambang.sudiro@example.com',
            'phone_number' => '081399887766',
            'company_name' => 'PT Sudiro Konstruksi Mandiri',
            'password' => 'Secret123!?',
            'password_confirmation' => 'Secret123!?',
        ];

        $response = $this->post(route('customer.register.submit'), $payload);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'Bambang Sudiro',
            'email' => 'bambang.sudiro@example.com',
            'phone_number' => '081399887766',
            'company_name' => 'PT Sudiro Konstruksi Mandiri',
            'role' => 'customer',
        ]);
    }

    public function test_customer_registration_fails_if_password_lacks_symbol_or_number(): void
    {
        // 1. Password without symbol (only letters & numbers)
        $responseNoSymbol = $this->post(route('customer.register.submit'), [
            'name' => 'User Tanpa Simbol',
            'email' => 'nosymbol@example.com',
            'phone_number' => '081234567890',
            'password' => 'Password12345',
            'password_confirmation' => 'Password12345',
        ]);

        $responseNoSymbol->assertSessionHasErrors(['password']);

        // 2. Password without number (only letters & symbols)
        $responseNoNumber = $this->post(route('customer.register.submit'), [
            'name' => 'User Tanpa Angka',
            'email' => 'nonumber@example.com',
            'phone_number' => '081234567890',
            'password' => 'PasswordSecret!?',
            'password_confirmation' => 'PasswordSecret!?',
        ]);

        $responseNoNumber->assertSessionHasErrors(['password']);
    }

    public function test_customer_registration_fails_without_phone_number_or_email(): void
    {
        $payload = [
            'name' => 'Klien Tanpa Telepon',
            'email' => 'tanpatelepon@example.com',
            'password' => 'Secret123!?',
            'password_confirmation' => 'Secret123!?',
        ];

        $response = $this->post(route('customer.register.submit'), $payload);

        $response->assertSessionHasErrors(['phone_number']);
        $this->assertGuest();
    }

    public function test_customer_can_login_using_email_and_password(): void
    {
        $customer = User::create([
            'name' => 'Iwan Fals',
            'email' => 'iwan.fals@example.com',
            'phone_number' => '081233445566',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('customer.login.submit'), [
            'email' => 'iwan.fals@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticatedAs($customer);
    }

    public function test_customer_can_login_using_phone_number_as_identifier(): void
    {
        $customer = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'phone_number' => '081299001122',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('customer.login.submit'), [
            'email' => '081299001122', // Using phone number in the identifier field
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticatedAs($customer);
    }

    public function test_customer_can_logout_securely(): void
    {
        $customer = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@example.com',
            'phone_number' => '081255667788',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        $response = $this->post(route('customer.logout'));

        $response->assertRedirect(route('customer.login'));
        $this->assertGuest();
    }

    public function test_customer_dashboard_displays_linked_rfp_tender_history(): void
    {
        $customer = User::create([
            'name' => 'Ir. Budi Santoso, M.T.',
            'email' => 'budi@graha-megapersada.co.id',
            'phone_number' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $rfp = InquiryRfp::where('email', 'budi@graha-megapersada.co.id')->first();
        $this->assertNotNull($rfp);

        $this->actingAs($customer);

        $response = $this->get(route('customer.dashboard'));

        $response->assertStatus(200);
        $response->assertSee($customer->name);
        $response->assertSee($rfp->rfp_number);
        $response->assertSee('Customer Portal');
    }

    public function test_customer_can_update_profile_phone_number(): void
    {
        $customer = User::create([
            'name' => 'Raden Mas',
            'email' => 'raden.mas@example.com',
            'phone_number' => '081211112222',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $this->actingAs($customer);

        $response = $this->post(route('customer.profile.update'), [
            'name' => 'Raden Mas Notonegoro',
            'phone_number' => '081299998888',
            'company_name' => 'PT Notonegoro Bangun',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Raden Mas Notonegoro',
            'phone_number' => '081299998888',
            'company_name' => 'PT Notonegoro Bangun',
        ]);
    }

    public function test_customer_dashboard_renders_profile_completion_prompt_for_google_or_users_without_phone(): void
    {
        $googleCustomer = User::create([
            'name' => 'Klien Google Tanpa Nomor',
            'email' => 'google.user@gmail.com',
            'google_id' => 'google-user-id-5555',
            'phone_number' => null,
            'company_name' => null,
            'password' => Hash::make('RandomPass123!'),
            'role' => 'customer',
        ]);

        $this->actingAs($googleCustomer);

        $response = $this->get(route('customer.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('+ Tambah Nomor HP', false);
        $response->assertSee('+ Tambah Nama Perusahaan', false);
        $response->assertSee('Tambahkan Nomor Telepon / WhatsApp', false);
        $response->assertSee(route('customer.profile.update'));

        // Customer fills their phone and company
        $updateResponse = $this->post(route('customer.profile.update'), [
            'name' => 'Klien Google Tanpa Nomor',
            'phone_number' => '081288887777',
            'company_name' => 'PT Mitra Utama Mandiri',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $googleCustomer->id,
            'phone_number' => '081288887777',
            'company_name' => 'PT Mitra Utama Mandiri',
        ]);

        // Re-visiting dashboard now displays the phone and company badges
        $followUp = $this->get(route('customer.dashboard'));
        $followUp->assertSee('081288887777');
        $followUp->assertSee('PT Mitra Utama Mandiri');
        $followUp->assertSee('Ubah Data');
        $followUp->assertDontSee('+ Tambah Nomor HP');
        $followUp->assertDontSee('+ Tambah Nama Perusahaan');
    }

    public function test_customer_without_phone_number_cannot_access_or_submit_rfp(): void
    {
        $googleCustomer = User::create([
            'name' => 'Akun Tanpa Nomor HP',
            'email' => 'tanpa.nomor@gmail.com',
            'phone_number' => null,
            'password' => Hash::make('Secret123!'),
            'role' => 'customer',
        ]);

        $this->actingAs($googleCustomer);

        // 1. Cannot access GET /rfp
        $createResponse = $this->get(route('rfp.create'));
        $createResponse->assertRedirect(route('customer.dashboard'));
        $createResponse->assertSessionHas('error');
        $createResponse->assertSessionHas('open_profile_modal', true);

        // 2. Cannot POST /rfp
        $storeResponse = $this->post(route('rfp.store'), [
            'full_name' => 'Akun Tanpa Nomor HP',
            'company_name' => 'PT Mitra Logistik',
            'email' => 'tanpa.nomor@gmail.com',
            'phone_number' => '081234567890',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'payment_scheme' => 'cash_tempo',
            'site_location' => 'Surabaya',
            'project_notes' => 'Pembangunan gudang logistik skala menengah.',
        ]);
        $storeResponse->assertRedirect(route('customer.dashboard'));
        $storeResponse->assertSessionHas('error');
        $storeResponse->assertSessionHas('open_profile_modal', true);
        $this->assertDatabaseMissing('inquiry_rfps', [
            'email' => 'tanpa.nomor@gmail.com',
        ]);

        // 3. Once phone number is updated, user can access and submit RFP
        $googleCustomer->update(['phone_number' => '081233445566']);

        $allowedResponse = $this->get(route('rfp.create'));
        $allowedResponse->assertStatus(200);
    }
}
