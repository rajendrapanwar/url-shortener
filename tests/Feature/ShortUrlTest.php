<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $admin;
    private User $member;
    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        // Create company
        $this->company = Company::create([
            'name' => 'Test Company',
            'slug' => 'test-company',
        ]);

        // Create users
        $this->superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'company_id' => null,
        ]);

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $this->company->id,
        ]);

        $this->member = User::create([
            'name' => 'Member',
            'email' => 'member@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'company_id' => $this->company->id,
        ]);
    }

    /** @test */
    public function admin_can_create_short_urls()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/short-urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertRedirect('/short-urls');
        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.com',
            'user_id' => $this->admin->id,
            'company_id' => $this->company->id,
        ]);
    }

    /** @test */
    public function member_can_create_short_urls()
    {
        $this->actingAs($this->member);

        $response = $this->post('/short-urls', [
            'original_url' => 'https://example.org',
        ]);

        $response->assertRedirect('/short-urls');
        $this->assertDatabaseHas('short_urls', [
            'original_url' => 'https://example.org',
            'user_id' => $this->member->id,
            'company_id' => $this->company->id,
        ]);
    }

    /** @test */
    public function super_admin_cannot_create_short_urls()
    {
        $this->actingAs($this->superAdmin);

        $response = $this->post('/short-urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('short_urls', 0);
    }

    /** @test */
    public function admin_can_only_see_short_urls_in_their_own_company()
    {
        // Create another company with its own URLs
        $otherCompany = Company::create([
            'name' => 'Other Company',
            'slug' => 'other-company',
        ]);

        $otherAdmin = User::create([
            'name' => 'Other Admin',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $otherCompany->id,
        ]);

        // Create URLs for both companies
        $ownUrl = ShortUrl::create([
            'user_id' => $this->admin->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://own-company.com',
            'short_code' => 'own123',
        ]);

        $otherUrl = ShortUrl::create([
            'user_id' => $otherAdmin->id,
            'company_id' => $otherCompany->id,
            'original_url' => 'https://other-company.com',
            'short_code' => 'oth456',
        ]);

        $this->actingAs($this->admin);

        $response = $this->get('/short-urls');

        $response->assertSee('own-company.com');
        $response->assertDontSee('other-company.com');
    }

    /** @test */
    public function member_can_only_see_short_urls_created_by_themselves()
    {
        // Create another member in same company
        $otherMember = User::create([
            'name' => 'Other Member',
            'email' => 'othermember@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'company_id' => $this->company->id,
        ]);

        // Create URLs for both members
        $ownUrl = ShortUrl::create([
            'user_id' => $this->member->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://my-url.com',
            'short_code' => 'my12345',
        ]);

        $otherUrl = ShortUrl::create([
            'user_id' => $otherMember->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://other-url.com',
            'short_code' => 'ot67890',
        ]);

        $this->actingAs($this->member);

        $response = $this->get('/short-urls');

        $response->assertSee('my-url.com');
        $response->assertDontSee('other-url.com');
    }

    /** @test */
    public function short_urls_are_publicly_resolvable_and_redirect()
    {
        $shortUrl = ShortUrl::create([
            'user_id' => $this->member->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://laravel.com',
            'short_code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://laravel.com');
    }

    /** @test */
    public function super_admin_can_see_all_short_urls_from_all_companies()
    {
        $otherCompany = Company::create([
            'name' => 'Another Co',
            'slug' => 'another-co',
        ]);

        $otherUser = User::create([
            'name' => 'Other User',
            'email' => 'otheruser@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'company_id' => $otherCompany->id,
        ]);

        ShortUrl::create([
            'user_id' => $this->member->id,
            'company_id' => $this->company->id,
            'original_url' => 'https://company-one.com',
            'short_code' => 'comp1aa',
        ]);

        ShortUrl::create([
            'user_id' => $otherUser->id,
            'company_id' => $otherCompany->id,
            'original_url' => 'https://company-two.com',
            'short_code' => 'comp2bb',
        ]);

        $this->actingAs($this->superAdmin);

        $response = $this->get('/short-urls');

        $response->assertSee('company-one.com');
        $response->assertSee('company-two.com');
    }
}