<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function ()
{
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($this->admin);
});

it('shows the roles index page', function ()
{
    $response = $this->get(route('admin.roles.index'));
    $response->assertStatus(200);
});

it('can create a new role', function ()
{
    $data = ['name' => 'Test Role'];
    $response = $this->post(route('admin.roles.store'), $data);
    $response->assertRedirect(route('admin.roles.index'));
    $this->assertDatabaseHas('roles', $data);
});

it('shows the role edit page', function ()
{
    $role = Role::factory()->create();
    $response = $this->get(route('admin.roles.edit', $role));
    $response->assertStatus(200);
});

it('can update a role', function ()
{
    $role = Role::factory()->create();
    $data = ['name' => 'Updated Role'];
    $response = $this->put(route('admin.roles.update', $role), $data);
    $response->assertRedirect(route('admin.roles.index'));
    $this->assertDatabaseHas('roles', $data);
});

it('can delete a role', function ()
{
    $role = Role::factory()->create();
    $response = $this->delete(route('admin.roles.destroy', $role));
    $response->assertRedirect(route('admin.roles.index'));
    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

it('can assign a permission to a role and check the assignment', function ()
{
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();

    $role->permissions()->attach($permission);

    $this->assertTrue($role->permissions->contains($permission));
    $this->assertDatabaseHas('permission_role', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);
});

// Additional tests

it('cannot create a role with duplicate name', function ()
{
    $role = Role::factory()->create(['name' => 'UniqueRole']);
    $data = ['name' => 'UniqueRole'];
    $response = $this->post(route('admin.roles.store'), $data);
    $response->assertSessionHasErrors('name');
});

it('cannot update a role to a duplicate name', function ()
{
    $role1 = Role::factory()->create(['name' => 'RoleOne']);
    $role2 = Role::factory()->create(['name' => 'RoleTwo']);
    $data = ['name' => 'RoleOne'];
    $response = $this->put(route('admin.roles.update', $role2), $data);
    $response->assertSessionHasErrors('name');
});

it('shows validation errors when creating a role without a name', function ()
{
    $response = $this->post(route('admin.roles.store'), []);
    $response->assertSessionHasErrors('name');
});

it('shows validation errors when updating a role without a name', function ()
{
    $role = Role::factory()->create();
    $response = $this->put(route('admin.roles.update', $role), []);
    $response->assertSessionHasErrors('name');
});

it('can detach a permission from a role', function ()
{
    $role = Role::factory()->create();
    $permission = Permission::factory()->create();
    $role->permissions()->attach($permission);

    $role->permissions()->detach($permission);

    $role->refresh();
    $this->assertFalse($role->permissions->contains($permission));
    $this->assertDatabaseMissing('permission_role', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);
});

it('returns 404 when editing a non-existent role', function ()
{
    $response = $this->get(route('admin.roles.edit', 99999));
    $response->assertNotFound();
});

it('returns 404 when updating a non-existent role', function ()
{
    $response = $this->put(route('admin.roles.update', 99999), ['name' => 'DoesNotExist']);
    $response->assertNotFound();
});

it('returns 404 when deleting a non-existent role', function ()
{
    $response = $this->delete(route('admin.roles.destroy', 99999));
    $response->assertNotFound();
});