<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

beforeEach(function ()
{
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->user = User::factory()->create(['is_admin' => false]);
});

// Test admin dashboard access
test('admin can access admin dashboard', function ()
{
    $response = $this->actingAs($this->admin)->get('/admin');
    $response->assertStatus(200);
});

test('non-admin cannot access admin dashboard', function ()
{
    $response = $this->actingAs($this->user)->get('/admin');
    $response->assertForbidden();
});

test('guest cannot access admin dashboard', function ()
{
    $response = $this->get('/admin');
    $response->assertRedirect('/login');
});

// Test admin users index
test('admin can view users list', function ()
{
    $response = $this->actingAs($this->admin)->get('/admin/users');
    $response->assertStatus(200);
});

test('non-admin cannot view users list', function ()
{
    $response = $this->actingAs($this->user)->get('/admin/users');
    $response->assertForbidden();
});

// Test admin can create a user
test('admin can create a user', function ()
{
    $data = [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $response = $this->actingAs($this->admin)->post('/admin/users', $data);
    $response->assertRedirect('/admin/users');
    $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
});

test('non-admin cannot create a user', function ()
{
    $data = [
        'name' => 'Test User',
        'email' => 'testuser2@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $response = $this->actingAs($this->user)->post('/admin/users', $data);
    $response->assertForbidden();
    $this->assertDatabaseMissing('users', ['email' => 'testuser2@example.com']);
});

// Test admin can delete a user
test('admin can delete a user', function ()
{
    $userToDelete = User::factory()->create();
    $response = $this->actingAs($this->admin)->delete("/admin/users/{$userToDelete->id}");
    $response->assertRedirect('/admin/users');
    $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
});

test('non-admin cannot delete a user', function ()
{
    $userToDelete = User::factory()->create();
    $response = $this->actingAs($this->user)->delete("/admin/users/{$userToDelete->id}");
    $response->assertForbidden();
    $this->assertDatabaseHas('users', ['id' => $userToDelete->id]);
});