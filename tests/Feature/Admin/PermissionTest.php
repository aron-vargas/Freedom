<?php

use App\Models\User;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an admin user for authentication
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($this->admin);
});

it('shows the permissions index page', function () {
    $response = $this->get(route('admin.permissions.index'));
    $response->assertStatus(200);
});

it('can create a new permission', function () {
    $data = ['name' => 'Test Permission'];
    $response = $this->post(route('admin.permissions.store'), $data);
    $response->assertRedirect(route('admin.permissions.index'));
    $this->assertDatabaseHas('permissions', $data);
});

it('shows the permission edit page', function () {
    $permission = Permission::factory()->create();
    $response = $this->get(route('admin.permissions.edit', $permission));
    $response->assertStatus(200);
});

it('can update a permission', function () {
    $permission = Permission::factory()->create();
    $data = ['name' => 'Updated Permission'];
    $response = $this->put(route('admin.permissions.update', $permission), $data);
    $response->assertRedirect(route('admin.permissions.index'));
    $this->assertDatabaseHas('permissions', $data);
});

it('can delete a permission', function () {
    $permission = Permission::factory()->create();
    $response = $this->delete(route('admin.permissions.destroy', $permission));
    $response->assertRedirect(route('admin.permissions.index'));
    $this->assertDatabaseMissing('permissions', ['id' => $permission-id]);
});
