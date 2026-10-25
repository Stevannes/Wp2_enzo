<?php

namespace Tests\Feature;

use App\Models\InquiryRfp;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EvaluationFeatureSeeder;
use Database\Seeders\InquiryRfpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(InquiryRfpSeeder::class);
        $this->seed(EvaluationFeatureSeeder::class);
    }

    public function test_login_page_renders_google_login_button(): void
    {
        $response = $this->get(route('customer.login'));

        $response->assertStatus(200);
        $response->assertSee('Lanjutkan dengan Google');
        $response->assertSee(route('auth.google.redirect'));
    }

    public function test_register_page_renders_google_signup_button(): void
    {
        $response = $this->get(route('customer.register'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Lebih Cepat dengan Google');
        $response->assertSee(route('auth.google.redirect'));
    }

    public function test_redirect_to_google_fails_gracefully_when_credentials_not_configured(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
        ]);

        $response = $this->get(route('auth.google.redirect'));

        $response->assertRedirect(route('customer.login'));
        $response->assertSessionHas('error');
    }

    public function test_redirect_to_google_initiates_oauth_flow_when_configured(): void
    {
        config([
            'services.google.client_id' => 'dummy-client-id-12345.apps.googleusercontent.com',
            'services.google.client_secret' => 'dummy-client-secret-abcde',
        ]);

        $response = $this->get(route('auth.google.redirect'));

        $response->assertRedirect();
        $redirectUrl = $response->headers->get('Location') ?? '';
        $this->assertStringContainsString('accounts.google.com', $redirectUrl);
        $this->assertStringContainsString('prompt=select_account', $redirectUrl);
    }

    public function test_handle_google_callback_creates_new_customer_and_links_pending_rfps(): void
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unique-id-998877');
        $abstractUser->shouldReceive('getName')->andReturn('Hendro Kusumo');
        $abstractUser->shouldReceive('getEmail')->andReturn('hendro.kusumo@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/a/avatar998877');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Create an unlinked RFP with this email
        $rfp = InquiryRfp::create([
            'rfp_number' => 'RFP-2610-099',
            'full_name' => 'Hendro Kusumo',
            'company_name' => 'PT Hendro Megah',
            'email' => 'hendro.kusumo@gmail.com',
            'phone_number' => '081234567890',
            'project_category' => 'Industri & Pergudangan Baja',
            'site_location' => 'Jakarta',
            'estimated_budget_idr' => 1500000000,
            'planned_area_sqm' => 500,
            'project_notes' => 'Tender pembangunan ruko komersial',
            'status' => 'submitted',
        ]);

        $this->assertNull($rfp->user_id);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'hendro.kusumo@gmail.com',
            'name' => 'Hendro Kusumo',
            'google_id' => 'google-unique-id-998877',
            'role' => 'customer',
        ]);

        $createdUser = User::where('email', 'hendro.kusumo@gmail.com')->first();
        $this->assertNotNull($createdUser);
        $this->assertEquals($createdUser->id, $rfp->fresh()->user_id);
    }

    public function test_handle_google_callback_links_existing_user_by_email(): void
    {
        $existingUser = User::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina.wijaya@gmail.com',
            'phone_number' => '081122334455',
            'password' => bcrypt('Password123!'),
            'role' => 'customer',
        ]);

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-id-rina-554433');
        $abstractUser->shouldReceive('getName')->andReturn('Rina Wijaya Google');
        $abstractUser->shouldReceive('getEmail')->andReturn('rina.wijaya@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/a/rina-avatar');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('customer.dashboard'));
        $this->assertAuthenticatedAs($existingUser);

        $this->assertDatabaseHas('users', [
            'id' => $existingUser->id,
            'email' => 'rina.wijaya@gmail.com',
            'google_id' => 'google-id-rina-554433',
        ]);
    }

    public function test_handle_google_callback_handles_failure_gracefully(): void
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andThrow(new \Exception('Google authentication was cancelled by user.'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('customer.login'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }
}
