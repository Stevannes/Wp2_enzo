<?php

namespace Tests\Feature;

use App\Models\InquiryRfp;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EvaluationFeatureSeeder;
use Database\Seeders\InquiryRfpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnzoWebPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->seed(InquiryRfpSeeder::class);
        $this->seed(EvaluationFeatureSeeder::class);
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('BUILDING EXCELLENCE WITH');
        $response->assertSee('ENZO');
        $response->assertSee('Kalkulator RAB');
    }

    public function test_projects_catalogue_page_loads_and_filters(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertSee('Katalog Rekam Jejak');

        // Test filter by commercial category
        $filterResponse = $this->get(route('projects.index', ['category' => 'commercial']));
        $filterResponse->assertStatus(200);
    }

    public function test_project_case_study_detail_page_loads(): void
    {
        $project = Project::first();
        $this->assertNotNull($project);

        $response = $this->get(route('projects.show', $project->slug));

        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('Spesifikasi Teknis Proyek');
    }

    public function test_estimator_calculator_page_loads(): void
    {
        $response = $this->get(route('estimator.index'));

        $response->assertStatus(200);
        $response->assertSee('Kalkulator Estimasi');
        $response->assertSee('Pilih Jenis Bangunan');
    }

    public function test_estimator_api_calculate_returns_valid_estimate(): void
    {
        $response = $this->postJson(route('estimator.calculate'), [
            'building_type' => 'residential_standard',
            'finish_grade' => 'premium',
            'area_sqm' => 200,
            'floors' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'building_type',
            'finish_grade',
            'area_sqm',
            'floors',
            'min_cost',
            'max_cost',
            'min_cost_formatted',
            'max_cost_formatted',
        ]);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_guest_cannot_access_rfp_and_tracking_without_login(): void
    {
        // 1. Guest visiting RFP create form is redirected to login
        $createResponse = $this->get(route('rfp.create'));
        $createResponse->assertRedirect(route('customer.login'));

        // 2. Guest submitting RFP is redirected to login
        $storeResponse = $this->post(route('rfp.store'), []);
        $storeResponse->assertRedirect(route('customer.login'));

        // 3. Guest visiting RFP track is redirected to login
        $trackResponse = $this->get(route('rfp.track'));
        $trackResponse->assertRedirect(route('customer.login'));
    }

    public function test_rfp_tender_is_hidden_from_guest_and_visible_when_logged_in(): void
    {
        // 1. Guest visits home -> cannot see RFP Tender link, box, or Admin CMS in footer
        $guestResponse = $this->get(route('home'));
        $guestResponse->assertStatus(200);
        $guestResponse->assertDontSee('RFP TENDER');
        $guestResponse->assertDontSee('Pengajuan Penawaran (RFP)');
        $guestResponse->assertDontSee('Admin CMS');

        // 2. Authenticated user visits home -> can see RFP Tender link and box, but normal client does not see Admin CMS
        $customer = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);
        $authResponse = $this->actingAs($customer)->get(route('home'));
        $authResponse->assertStatus(200);
        $authResponse->assertSee('RFP TENDER');
        $authResponse->assertSee('Pengajuan Penawaran (RFP)');
        $authResponse->assertDontSee('Admin CMS');
    }

    public function test_rfp_create_page_loads(): void
    {
        $customer = User::first();
        $response = $this->actingAs($customer)->get(route('rfp.create'));

        $response->assertStatus(200);
        $response->assertSee('Pengajuan Permintaan');
        $response->assertSee('Identitas Pemohon');
    }

    public function test_rfp_submission_creates_record_and_redirects_to_track(): void
    {
        $customer = User::first();
        $payload = [
            'full_name' => 'Dr. Hendra Gunawan',
            'company_name' => 'RS Medika Sentosa',
            'email' => 'hendra@medikasentosa.com',
            'phone_number' => '081298765432',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'site_location' => 'Pontianak Barat',
            'payment_scheme' => 'cash_tempo',
            'estimated_budget_idr' => 15000000000,
            'planned_area_sqm' => 1800,
            'project_notes' => 'Pembangunan poliklinik 4 lantai dengan lift medis.',
            'source_channel' => 'website',
        ];

        $response = $this->actingAs($customer)->post(route('rfp.store'), $payload);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('inquiry_rfps', [
            'email' => 'hendra@medikasentosa.com',
            'site_location' => 'Pontianak Barat',
            'payment_scheme' => 'cash_tempo',
        ]);

        $createdRfp = InquiryRfp::where('email', 'hendra@medikasentosa.com')->first();
        $this->assertNotNull($createdRfp);
        $this->assertStringStartsWith('RFP-', $createdRfp->rfp_number);

        $response->assertRedirect(route('rfp.track', ['rfp_number' => $createdRfp->rfp_number]));
    }

    public function test_rfp_track_page_with_valid_ticket(): void
    {
        $customer = User::first();
        $rfp = InquiryRfp::first();
        $this->assertNotNull($rfp);

        $response = $this->actingAs($customer)->get(route('rfp.track', ['rfp_number' => $rfp->rfp_number]));

        $response->assertStatus(200);
        $response->assertSee($rfp->rfp_number);
        $response->assertSee($rfp->full_name);
        $response->assertSee('Tahapan Evaluasi Tender');
    }

    public function test_design_layouts_catalog_page_loads(): void
    {
        $response = $this->get(route('layouts.index'));

        $response->assertStatus(200);
        $response->assertSee('Katalog Referensi Desain');
        $response->assertSee('Enzo Prime 45');
    }

    public function test_specifications_comparison_matrix_loads(): void
    {
        $response = $this->get(route('specifications.index'));

        $response->assertStatus(200);
        $response->assertSee('Matriks Spesifikasi Teknis');
        $response->assertSee('Material Bangunan');
        $response->assertSee('Pondasi Batu Kali');
    }

    public function test_admin_dashboard_loads_with_kpi_and_pipeline(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Lead Pipeline Tracker');
        $response->assertSee('Plafon Pipeline');
        $response->assertSee('CMS PORTAL');
        $response->assertSee('Executive Tender Engine');
        $response->assertDontSee('<span>CALCULATOR</span>', false);
    }

    public function test_admin_can_update_rfp_status(): void
    {
        $rfp = InquiryRfp::first();
        $this->assertNotNull($rfp);

        $response = $this->post(route('admin.rfp.status', $rfp->id), [
            'status' => 'survey_scheduled',
            'internal_admin_notes' => 'Survey dikonfirmasi hari Selasa.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiry_rfps', [
            'id' => $rfp->id,
            'status' => 'survey_scheduled',
            'internal_admin_notes' => 'Survey dikonfirmasi hari Selasa.',
        ]);
    }
}
