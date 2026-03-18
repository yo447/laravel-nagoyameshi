<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\category;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_admin_index(){

        $response = $this->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_access_admin_index(){

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.categories.index'));

        $response->assertRedirect(route('admin.login'));
            

    }

    public function test_loginAdmin_can_access_admin_index(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }

    public function test_user_cannot_register_admin_store(){

        $category = ['name' => 'テスト'];

        $response = $this->post(route('admin.categories.store'), $category);
        $this->assertDatabaseMissing('categories', $category);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_register_admin_store(){

        $user = User::factory()->create();
        $category = ['name' => 'テスト'];

        $response = $this->actingAs($user)->post(route('admin.categories.store'), $category);
        $this->assertDatabaseMissing('categories', $category);

        $response->assertRedirect(route('admin.login'));

    }

    public function test_loginAdmin_can_register_admin_store(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $data = ['name' => 'テスト'];

        $response = $this->actingAs($admin, 'admin')->post(route('admin.categories.store'), $data);
        $this->assertDatabaseHas('categories', $data);

        $response->assertRedirect(route('admin.categories.index'));
    }

    public function test_user_cannot_update_admin_update(){

        $category = Category::factory()->create();
        $category_data = ['name' => 'テスト更新'];

        $response = $this->patch(route('admin.categories.update', $category), $category_data);
        $this->assertDatabaseMissing('categories', $category_data);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_update_admin_update(){

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_data = ['name' => 'テスト更新'];

        $response = $this->actingAs($user)->patch(route('admin.categories.update', $category), $category_data);
        $this->assertDatabaseMissing('categories', $category_data);

        $response->assertRedirect(route('admin.login'));

    }

    public function test_loginAdmin_can_update_admin_update(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $category = Category::factory()->create();
        $category_data = ['name' => 'テスト更新'];

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.categories.update', $category), $category_data);
        $this->assertDatabaseHas('categories', $category_data);

        $response->assertRedirect(route('admin.categories.index'));
    }

    public function test_user_cannot_delete_admin_destroy(){

        $category = Category::factory()->create();
        $category_data = ['id' => $category->id];

        $response = $this->delete(route('admin.categories.destroy', $category));
        $this->assertDatabaseHas('categories', $category_data);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_delete_admin_destroy(){

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $category_data = ['id' => $category->id];

        $response = $this->actingAs($user)->delete(route('admin.categories.destroy', $category));
        $this->assertDatabaseHas('categories', $category_data);

        $response->assertRedirect(route('admin.login'));

    }

    public function test_loginAdmin_can_delete_admin_destroy(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $category = Category::factory()->create();
        $category_data = ['name' => 'テスト'];

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.categories.destroy', $category), $category_data);
        $this->assertDatabaseMissing('categories', $category_data);

        $response->assertRedirect(route('admin.categories.index'));
    }
}
