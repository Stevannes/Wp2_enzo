<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EvaluationFeatureSeeder;
use Database\Seeders\InquiryRfpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(InquiryRfpSeeder::class);
        $this->seed(EvaluationFeatureSeeder::class);
    }

    public function test_security_headers_are_attached_to_all_responses(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $this->assertTrue($response->headers->has('Content-Security-Policy'));
        $this->assertFalse($response->headers->has('X-Powered-By'));
    }

    public function test_admin_login_portal_loads_successfully(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('Portal Admin');
        $response->assertSee('Executive Security Gateway');
        $response->assertSee('Alamat Email Resmi Admin');
        $response->assertDontSee('<span>CALCULATOR</span>', false);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'enzo.ng7786@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_login_rejects_invalid_password(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'enzo.ng7786@gmail.com',
            'password' => 'wrong-hacker-password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_non_admin_role_cannot_login_to_admin_portal(): void
    {
        $nonAdmin = User::where('role', 'estimator')->first();
        $this->assertNotNull($nonAdmin);

        $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => $nonAdmin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_logout_securely(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_malicious_php_script_upload_is_strictly_blocked(): void
    {
        $user = User::first();
        $payload = [
            'full_name' => 'Hacker Pentester',
            'email' => 'hacker@target.com',
            'phone_number' => '08123456789',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'site_location' => 'Pontianak',
            'payment_scheme' => 'cash_tempo',
            'attachments' => [
                UploadedFile::fake()->createWithContent('exploit.php', '<?php phpinfo(); ?>'),
            ],
        ];

        $response = $this->actingAs($user)->post(route('rfp.store'), $payload);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('inquiry_rfps', [
            'email' => 'hacker@target.com',
        ]);
    }

    public function test_double_extension_file_upload_is_blocked(): void
    {
        $user = User::first();
        $payload = [
            'full_name' => 'Hacker Pentester',
            'email' => 'hacker@target.com',
            'phone_number' => '08123456789',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'site_location' => 'Pontianak',
            'payment_scheme' => 'cash_tempo',
            'attachments' => [
                UploadedFile::fake()->create('shell.php.png', 100),
            ],
        ];

        $response = $this->actingAs($user)->post(route('rfp.store'), $payload);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('inquiry_rfps', [
            'email' => 'hacker@target.com',
        ]);
    }

    public function test_honeypot_field_detects_and_rejects_bots(): void
    {
        $user = User::first();
        $payload = [
            'full_name' => 'Automated Spambot',
            'email' => 'bot@spammer.org',
            'phone_number' => '08123456789',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'site_location' => 'Pontianak',
            'payment_scheme' => 'cash_tempo',
            'website_hp' => 'I am an automated spam bot', // Honeypot filled by bot!
        ];

        $response = $this->actingAs($user)->post(route('rfp.store'), $payload);

        $response->assertSessionHasErrors('website_hp');
        $this->assertDatabaseMissing('inquiry_rfps', [
            'email' => 'bot@spammer.org',
        ]);
    }

    public function test_login_brute_force_rate_limiter_locks_after_repeated_failures(): void
    {
        RateLimiter::clear('enzo.ng7786@gmail.com|127.0.0.1');

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), [
                'email' => 'enzo.ng7786@gmail.com',
                'password' => 'wrong-pass-'.$i,
            ]);
        }

        // 6th attempt should be blocked with HTTP 429 (Too Many Requests) by route rate limiter
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'enzo.ng7786@gmail.com',
            'password' => 'wrong-pass-6',
        ]);

        $response->assertStatus(429);
    }
}
