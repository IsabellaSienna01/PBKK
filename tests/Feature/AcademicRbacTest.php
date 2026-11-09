<?php

namespace Tests\Feature;

use App\Models\IdeAgent;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicRbacTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected User $stafUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->adminUser = User::where('email', 'admin@academic.its.ac.id')->first();
        $this->stafUser = User::where('email', 'staf@academic.its.ac.id')->first();
    }

    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_home_page_renders_with_assets_and_content(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Academic Profile');
        $response->assertSee('Isabella Sienna Sulisthio');
        $response->assertSee('build/assets/app-');
    }

    public function test_auto_login_demo_works_for_admin_and_staf(): void
    {
        // 1. Demo Login Admin
        $responseAdmin = $this->post('/demo-login', ['role' => 'admin']);
        $responseAdmin->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->adminUser);

        // Logout
        $this->post('/logout');

        // 2. Demo Login Staf
        $responseStaf = $this->post('/demo-login', ['role' => 'staf']);
        $responseStaf->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->stafUser);
    }

    public function test_dashboard_displays_dynamic_aggregate_statistics_widgets(): void
    {
        Mahasiswa::factory()->create([
            'nrp' => '5025241099',
            'nama' => 'Test Mahasiswa',
            'email' => 'test@student.its.ac.id',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
            'ipk' => 3.85,
            'status' => 'Aktif',
        ]);

        MataKuliah::create([
            'kode' => 'IF123',
            'nama_mk' => 'Test Mata Kuliah',
            'sks' => 3,
            'semester' => 4,
            'dosen_pengampu' => 'Dosen Test',
        ]);

        IdeAgent::create([
            'nama' => 'Tester',
            'judul_ide' => 'Test Agent Idea',
            'deskripsi' => 'Testing description',
            'status' => 'Menunggu Review',
        ]);

        $response = $this->actingAs($this->adminUser)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Total Students');
        $response->assertSee('Curriculum Courses');
        $response->assertSee('Agentic AI Proposals');
        $response->assertSee('Registered Users');
    }

    public function test_staf_can_view_and_create_mahasiswa_but_cannot_delete(): void
    {
        $mahasiswa = Mahasiswa::create([
            'nrp' => '5025241088',
            'nama' => 'Mahasiswa Test RBAC',
            'email' => 'mhs.rbac@student.its.ac.id',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
            'ipk' => 3.75,
            'status' => 'Aktif',
        ]);

        // Staf can view list
        $this->actingAs($this->stafUser)
            ->get('/dashboard/mahasiswa')
            ->assertOk()
            ->assertSee('Mahasiswa Test RBAC');

        // Staf CANNOT delete mahasiswa (403 Forbidden)
        $this->actingAs($this->stafUser)
            ->delete("/dashboard/mahasiswa/{$mahasiswa->id}")
            ->assertForbidden();

        // Data still exists
        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id]);

        // Admin CAN delete mahasiswa (Hak Eksklusif)
        $this->actingAs($this->adminUser)
            ->delete("/dashboard/mahasiswa/{$mahasiswa->id}")
            ->assertRedirect('/dashboard/mahasiswa');

        // Data was deleted
        $this->assertDatabaseMissing('mahasiswas', ['id' => $mahasiswa->id]);
    }

    public function test_staf_cannot_access_user_management_module(): void
    {
        // Staf forbidden from User Management
        $this->actingAs($this->stafUser)
            ->get('/dashboard/users')
            ->assertForbidden();

        // Admin allowed
        $this->actingAs($this->adminUser)
            ->get('/dashboard/users')
            ->assertOk()
            ->assertSee('User Management');
    }

    public function test_search_and_when_query_filters_results_cleanly(): void
    {
        Mahasiswa::create([
            'nrp' => '5025241011',
            'nama' => 'Alice Wonder',
            'email' => 'alice@student.its.ac.id',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
            'ipk' => 3.80,
            'status' => 'Aktif',
        ]);

        Mahasiswa::create([
            'nrp' => '5025241022',
            'nama' => 'Bob Marley',
            'email' => 'bob@student.its.ac.id',
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2023,
            'ipk' => 3.50,
            'status' => 'Cuti',
        ]);

        // Search Alice
        $response = $this->actingAs($this->adminUser)
            ->get('/dashboard/mahasiswa?search=Alice');

        $response->assertOk();
        $response->assertSee('Alice Wonder');
        $response->assertDontSee('Bob Marley');

        // Filter Jurusan Sistem Informasi
        $responseJurusan = $this->actingAs($this->adminUser)
            ->get('/dashboard/mahasiswa?jurusan=Sistem+Informasi');

        $responseJurusan->assertOk();
        $responseJurusan->assertSee('Bob Marley');
        $responseJurusan->assertDontSee('Alice Wonder');
    }
}
