<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_guest_can_access_user_home_index()
    {$this->withoutExceptionHandling();
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_loginUser_can_access_user_home_index()
    {$this->withoutExceptionHandling();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_user_home_index()
    {$this->withoutExceptionHandling();
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('home'));

        $response->assertRedirect(route('admin.home'));
    }
}
