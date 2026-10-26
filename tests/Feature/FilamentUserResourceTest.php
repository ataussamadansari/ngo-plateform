<?php

namespace Tests\Feature;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentUserResourceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_users_index(): void
    {
        $this->get('/admin/users')
            ->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_users_table(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/users')
            ->assertSuccessful()
            ->assertSee('Staff & Admin Users')
            ->assertSee($this->admin->email);
    }

    public function test_admin_can_create_new_manager_user_via_form(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'Aarav Sharma',
                'email' => 'aarav.manager@example.org',
                'phone' => '9876543210',
                'role' => 'manager',
                'password' => 'SecurePass123!',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'Aarav Sharma',
            'email' => 'aarav.manager@example.org',
            'role' => 'manager',
            'is_active' => true,
        ]);

        $created = User::where('email', 'aarav.manager@example.org')->first();
        $this->assertTrue(Hash::check('SecurePass123!', $created->password));
    }

    public function test_admin_can_edit_existing_user(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old.staff@example.org',
            'role' => 'manager',
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $user->getKey()])
            ->fillForm([
                'name' => 'Updated Staff Member',
                'is_active' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Staff Member',
            'is_active' => false,
        ]);
    }

    public function test_admin_cannot_delete_their_own_account_via_page_action(): void
    {
        Livewire::actingAs($this->admin)
            ->test(EditUser::class, ['record' => $this->admin->getKey()])
            ->assertActionHidden('delete');
    }
}
