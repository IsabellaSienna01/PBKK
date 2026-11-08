<?php

namespace Tests\Feature;

use App\Models\IdeAgent;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Database\Seeders\AcademicSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndpointHtmlCssTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $staf;

    protected Mahasiswa $mahasiswa;

    protected MataKuliah $mataKuliah;

    protected IdeAgent $ideAgent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(AcademicSeeder::class);

        $this->admin = User::where('email', 'admin@academic.its.ac.id')->first();
        $this->staf = User::where('email', 'staf@academic.its.ac.id')->first();

        $this->mahasiswa = Mahasiswa::first();
        $this->mataKuliah = MataKuliah::first();
        $this->ideAgent = IdeAgent::first();
    }

    /**
     * Helper assertion for verifying AdminLTE HTML & CSS structure
     */
    protected function assertValidAdminLteHtmlCss($response, string $expectedTitleKeyword): void
    {
        $response->assertOk();
        $content = $response->getContent();

        // 1. Valid HTML5 Doctype & HTML tags
        $this->assertStringContainsString('<!DOCTYPE html>', $content, 'Page missing <!DOCTYPE html>');
        $this->assertStringContainsString('<html', $content, 'Page missing <html tag');
        $this->assertStringContainsString('<body', $content, 'Page missing <body tag');

        // 2. CSS Stylesheets: AdminLTE, Bootstrap, or Source Sans
        $hasAdminLteCss = str_contains($content, 'adminlte.min.css') || str_contains($content, 'adminlte');
        $this->assertTrue($hasAdminLteCss, 'Page missing AdminLTE stylesheet link');

        // 3. Bootstrap Icons
        $hasIcons = str_contains($content, 'bootstrap-icons') || str_contains($content, 'bi bi-') || str_contains($content, 'bi-');
        $this->assertTrue($hasIcons, 'Page missing Bootstrap Icons');

        // 4. Expected Page Title / Keyword
        $response->assertSee($expectedTitleKeyword, false);

        // 5. Structure: Content Wrapper & Navbar Brand
        $response->assertSee('Portal', false);
        $response->assertSee('Akademik', false);
    }

    /**
     * 1. POST /demo-login (Instant Auto-Login)
     */
    public function test_post_demo_login_authenticates_and_redirects(): void
    {
        $response = $this->post('/demo-login', ['role' => 'admin']);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);

        // Also test staf demo login
        $this->post('/logout');
        $responseStaf = $this->post('/demo-login', ['role' => 'staf']);
        $responseStaf->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->staf);
    }

    /**
     * 2. GET /dashboard (AdminLTE Dashboard)
     */
    public function test_get_dashboard_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');

        $this->assertValidAdminLteHtmlCss($response, 'Dashboard Backoffice');
        $response->assertSee('Total Mahasiswa');
        $response->assertSee('Mata Kuliah Kurikulum');
        $response->assertSee('Proposal Ide Agentic');
        $response->assertSee('small-box');
    }

    /**
     * 3. GET /dashboard/mahasiswa (Search when())
     */
    public function test_get_dashboard_mahasiswa_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/mahasiswa');

        $this->assertValidAdminLteHtmlCss($response, 'Data Mahasiswa');
        $response->assertSee('Filter');
        $response->assertSee('Pencarian Data');
        $response->assertSee('when()');
        $response->assertSee('table-responsive');
        $response->assertSee('pagination');
    }

    /**
     * 4. POST /dashboard/mahasiswa (Store)
     */
    public function test_post_dashboard_mahasiswa_stores_record_and_redirects(): void
    {
        $newNrp = '5025249988';
        $payload = [
            'nrp' => $newNrp,
            'nama' => 'Budi Santoso Pratama',
            'email' => 'budi.santoso@student.its.ac.id',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
            'ipk' => 3.85,
            'status' => 'Aktif',
        ];

        $response = $this->actingAs($this->admin)->post('/dashboard/mahasiswa', $payload);

        $response->assertRedirect('/dashboard/mahasiswa');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('mahasiswas', ['nrp' => $newNrp]);
    }

    /**
     * 5. GET /dashboard/mahasiswa/{id} (Show)
     */
    public function test_get_dashboard_mahasiswa_show_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get("/dashboard/mahasiswa/{$this->mahasiswa->id}");

        $this->assertValidAdminLteHtmlCss($response, 'Profil Lengkap Mahasiswa');
        $response->assertSee($this->mahasiswa->nama);
        $response->assertSee($this->mahasiswa->nrp);
        $response->assertSee('Rincian Akademik');
    }

    /**
     * 6. GET /dashboard/mahasiswa/{id}/edit (Edit)
     */
    public function test_get_dashboard_mahasiswa_edit_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get("/dashboard/mahasiswa/{$this->mahasiswa->id}/edit");

        $this->assertValidAdminLteHtmlCss($response, 'Edit Data Mahasiswa');
        $response->assertSee($this->mahasiswa->nama);
        $response->assertSee('Formulir Pembaruan Data');
        $response->assertSee('Perbarui Perubahan');
    }

    /**
     * 7. DELETE /dashboard/mahasiswa/{id} (Destroy - Admin Only)
     */
    public function test_delete_dashboard_mahasiswa_deletes_and_redirects(): void
    {
        $target = Mahasiswa::factory()->create([
            'nrp' => '5025247711',
            'nama' => 'Mahasiswa Siap Dihapus',
            'email' => 'siap.hapus@student.its.ac.id',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2024,
            'ipk' => 3.20,
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($this->admin)->delete("/dashboard/mahasiswa/{$target->id}");

        $response->assertRedirect('/dashboard/mahasiswa');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('mahasiswas', ['id' => $target->id]);
    }

    /**
     * 8. GET /dashboard/matakuliah (Index)
     */
    public function test_get_dashboard_matakuliah_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/matakuliah');

        $this->assertValidAdminLteHtmlCss($response, 'Kurikulum Mata Kuliah');
        $response->assertSee('Daftar Mata Kuliah');
        $response->assertSee('Filter Mata Kuliah');
        $response->assertSee('table-responsive');
    }

    /**
     * 9. DELETE /dashboard/matakuliah/{id} (Destroy - Admin Only)
     */
    public function test_delete_dashboard_matakuliah_deletes_and_redirects(): void
    {
        $targetMk = MataKuliah::create([
            'kode' => 'DEL999',
            'nama_mk' => 'Mata Kuliah Hapus Test',
            'sks' => 2,
            'semester' => 4,
            'dosen_pengampu' => 'Dosen Hapus',
        ]);

        $response = $this->actingAs($this->admin)->delete("/dashboard/matakuliah/{$targetMk->id}");

        $response->assertRedirect('/dashboard/matakuliah');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('mata_kuliahs', ['id' => $targetMk->id]);
    }

    /**
     * 10. GET /dashboard/ide-agent (Index)
     */
    public function test_get_dashboard_ide_agent_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/ide-agent');

        $this->assertValidAdminLteHtmlCss($response, 'Proposal Ide Agentic AI');
        $response->assertSee('Usulan Inovasi Agentic AI');
        $response->assertSee('Filter Ide Agentic AI');
        $response->assertSee('table-responsive');
    }

    /**
     * 11. GET /dashboard/users (Index - Admin Only)
     */
    public function test_get_dashboard_users_renders_valid_html_and_css(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard/users');

        $this->assertValidAdminLteHtmlCss($response, 'Manajemen Pengguna');
        $response->assertSee('Aturan Hak Akses Berbasis Peran');
        $response->assertSee('Daftar Akun Pengguna');
        $response->assertSee('Tambah Pengguna Baru');
        $response->assertSee('table-responsive');
    }
}
