<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class RestaurantTest extends TestCase
{
    use RefreshDatabase;   


    /*
     // 未ログインのユーザーは管理者側の店舗一覧ページにアクセスできない
    public function test_guest_cannot_access_admin_restaurants_index()
    {
        $response = $this->get(route('admin.restaurants.index'));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない
    public function test_user_cannot_access_admin_restaurants_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.index'));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる
    public function test_admin_can_access_admin_restaurants_index()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは管理者側の店舗詳細ページにアクセスできない
    public function test_guest_cannot_access_admin_restaurants_show()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.show', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは管理者側の店舗詳細ページにアクセスできない
    public function test_user_cannot_access_admin_restaurants_show()
    {
        $user = User::factory()->create();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.show', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は管理者側の店舗詳細ページにアクセスできる
    public function test_admin_can_access_admin_restaurants_show()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.show', $restaurant));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは管理者側の店舗登録ページにアクセスできない
    public function test_guest_cannot_access_admin_restaurants_create()
    {
        $response = $this->get(route('admin.restaurants.create'));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは管理者側の店舗登録ページにアクセスできない
    public function test_user_cannot_access_admin_restaurants_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.create'));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は管理者側の店舗登録ページにアクセスできる
    public function test_admin_can_access_admin_restaurants_create()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.create'));

        $response->assertStatus(200);
    }


    // 未ログインのユーザーは店舗を登録できない
    public function test_guest_cannot_access_admin_restaurants_store()
    {
        $restaurant_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50
        ];

        $response = $this->post(route('admin.restaurants.store'), $restaurant_data);

        $this->assertDatabaseMissing('restaurants', $restaurant_data);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは店舗を登録できない
    public function test_user_cannot_access_admin_restaurants_store()
    {
        $user = User::factory()->create();

        $restaurant_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50
        ];

        $response = $this->actingAs($user)->post(route('admin.restaurants.store'), $restaurant_data);

        $this->assertDatabaseMissing('restaurants', $restaurant_data);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は店舗を登録できる
    public function test_admin_can_access_admin_restaurants_store()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant_data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50
        ];

        $response = $this->actingAs($admin, 'admin')->post(route('admin.restaurants.store'), $restaurant_data);

        $this->assertDatabaseHas('restaurants', $restaurant_data);
        $response->assertRedirect(route('admin.restaurants.index'));
    }

    // 未ログインのユーザーは管理者側の店舗編集ページにアクセスできない
    public function test_guest_cannot_access_admin_restaurants_edit()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.edit', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは管理者側の店舗編集ページにアクセスできない
    public function test_user_cannot_access_admin_restaurants_edit()
    {
        $user = User::factory()->create();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.edit', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は管理者側の店舗編集ページにアクセスできる
    public function test_admin_can_access_admin_restaurants_edit()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.edit', $restaurant));

        $response->assertStatus(200);
    }

    // 未ログインのユーザーは店舗を更新できない
    public function test_guest_cannot_access_admin_restaurants_update()
    {
        $old_restaurant = Restaurant::factory()->create();

        $new_restaurant_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 5000,
            'highest_price' => 10000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '13:00:00',
            'closing_time' => '23:00:00',
            'seating_capacity' => 100
        ];

        $response = $this->patch(route('admin.restaurants.update', $old_restaurant), $new_restaurant_data);

        $this->assertDatabaseMissing('restaurants', $new_restaurant_data);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは店舗を更新できない
    public function test_user_cannot_access_admin_restaurants_update()
    {
        $user = User::factory()->create();

        $old_restaurant = Restaurant::factory()->create();

        $new_restaurant_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 5000,
            'highest_price' => 10000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '13:00:00',
            'closing_time' => '23:00:00',
            'seating_capacity' => 100
        ];

        $response = $this->actingAs($user)->patch(route('admin.restaurants.update', $old_restaurant), $new_restaurant_data);

        $this->assertDatabaseMissing('restaurants', $new_restaurant_data);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は店舗を更新できる
    public function test_admin_can_access_admin_restaurants_update()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $old_restaurant = Restaurant::factory()->create();

        $new_restaurant_data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 5000,
            'highest_price' => 10000,
            'postal_code' => '1234567',
            'address' => 'テスト更新',
            'opening_time' => '13:00:00',
            'closing_time' => '23:00:00',
            'seating_capacity' => 100
        ];

        $response = $this->actingAs($admin, 'admin')->patch(route('admin.restaurants.update', $old_restaurant), $new_restaurant_data);

        $this->assertDatabaseHas('restaurants', $new_restaurant_data);
        $response->assertRedirect(route('admin.restaurants.show', $old_restaurant));
    }

    // 未ログインのユーザーは店舗を削除できない
    public function test_guest_cannot_access_admin_restaurants_destroy()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));

        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの一般ユーザーは店舗を削除できない
    public function test_user_cannot_access_admin_restaurants_destroy()
    {
        $user = User::factory()->create();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.restaurants.destroy', $restaurant));

        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.login'));
    }

    // ログイン済みの管理者は店舗を削除できる
    public function test_admin_can_access_admin_restaurants_destroy()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.restaurants.destroy', $restaurant));

        $this->assertDatabaseMissing('restaurants', ['id' => $restaurant->id]);
        $response->assertRedirect(route('admin.restaurants.index'));
    }*/


    
    public function test_user_cannot_access_admin_index(){

        $response = $this->get(route('admin.restaurants.index'));
        
        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_access_admin_index(){

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_index(){
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));

        $response->assertStatus(200);


    /*
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));

        $response->assertStatus(200);*/ 
    }

    public function test_user_cannot_access_admin_show(){

        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.show', $restaurant));

        $response->assertRedirect(route('admin.login'));
        
    }

    public function test_loginUser_cannot_access_admin_show(){

        $user = User::factory()->create();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.show', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_show(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.show', $restaurant));

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_admin_create(){

        $response = $this->get(route('admin.restaurants.create'));

        $response->assertRedirect(route('admin.login'));
        
    }

    public function test_loginUser_cannot_access_admin_create(){

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.create'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_create(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.create'));

        $response->assertStatus(200);
    }

    public function test_user_cannot_created_admin_store(){

        $category = Category::factory()->count(3)->create();//->pluck('id')->toArray();
        $category_ids = $category->pluck('id')->toArray();

        $data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
            'category_ids' => $category_ids
        ];

        $response = $this->post(route('admin.restaurants.store'), $data);

        unset($data['category_ids']);

        $this->assertDatabaseMissing('restaurants', $data);

        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', ['category_id' => $category_id]);
        }
        
        $response->assertRedirect(route('admin.login'));
        
        
    }

    public function test_loginUser_cannot_create_admin_store(){

        $user = User::factory()->create();

        $category_ids = Category::factory()->count(3)->create()->pluck('id')->toArray();

        $data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
            'category_ids' => $category_ids
        ];

        $response = $this->actingAs($user)->post(route('admin.restaurants.store'), $data);

        unset($data['category_ids']);

        $this->assertDatabaseMissing('restaurants', $data);

        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', ['category_id' => $category_id]);
        }

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_store(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $category_id = Category::factory()->count(3)->create();
        $category_ids = $category_id->pluck('id')->toArray();


        $data = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
            'category_ids' => $category_ids

        ];

        $response = $this->actingAs($admin, 'admin')->post(route('admin.restaurants.store'), $data);

        unset($data['category_ids']);

        $this->assertDatabaseHas('restaurants', $data);

        $restaurant = Restaurant::latest('id')->first();
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseHas('category_restaurant', ['restaurant_id' => $restaurant->id, 'category_id' => $category_id]);
        }

        $response->assertRedirect(route('admin.restaurants.index'));
        
    }

    
    public function test_user_cannot_access_admin_edit(){

        $restaurant =Restaurant::factory()->create();

        $response = $this->get(route('admin.restaurants.edit', $restaurant));

        $response->assertRedirect(route('admin.login'));
        
    }

    public function test_loginUser_cannot_access_admin_edit(){

        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.restaurants.edit', $restaurant));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_edit(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.edit', $restaurant));

        $response->assertStatus(200);
    }

    
    public function test_user_cannot_created_admin_update(){

        $restaurant = Restaurant::factory()->create();

        $category_id = Category::factory()->count(3)->create();
        $category_ids = $category_id->pluck('id')->toArray();

        $data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1000000',
            'address' => 'テスト更新',
            'opening_time' => '11:00:00',
            'closing_time' => '21:00:00',
            'seating_capacity' => 60,
            'category_ids' => $category_ids,
        ];

        $response = $this->put(route('admin.restaurants.update', $restaurant), $data);

        unset($data['category_ids']);

        $this->assertDatabaseMissing('restaurants', $data);

        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', ['category_id' => $category_id]);
        }

        $response->assertRedirect(route('admin.login'));
        
    }

    public function test_loginUser_cannot_create_admin_update(){

        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $category_id = Category::factory()->count(3)->create();
        $category_ids = $category_id->pluck('id')->toArray();

        $data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1000000',
            'address' => 'テスト更新',
            'opening_time' => '11:00:00',
            'closing_time' => '21:00:00',
            'seating_capacity' => 60,
            'category_ids' => $category_ids
        ];

        $response = $this->actingAs($user)->put(route('admin.restaurants.update', $restaurant), $data);

        unset($data['category_ids']);

        $this->assertDatabaseMissing('restaurants', $data);

        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', ['category_id' => $category_id]);
        }

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_update(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $category_id = Category::factory()->count(3)->create();
        $category_ids = $category_id->pluck('id')->toArray();

        $data = [
            'name' => 'テスト更新',
            'description' => 'テスト更新',
            'lowest_price' => 2000,
            'highest_price' => 6000,
            'postal_code' => '1000000',
            'address' => 'テスト更新',
            'opening_time' => '11:00:00',
            'closing_time' => '21:00:00',
            'seating_capacity' => 60,
            'category_ids' => $category_ids
        ];

        $response = $this->actingAs($admin, 'admin')->put(route('admin.restaurants.update', $restaurant), $data);

        unset($data['category_ids']);

        $this->assertDatabaseHas('restaurants', $data);

        $restaurant = Restaurant::latest('id')->first();

        foreach ($category_ids as $category_id) {
        $this->assertDatabaseHas('category_restaurant', ['restaurant_id' => $restaurant->id, 'category_id' => $category_id]);
        }

        $response->assertRedirect(route('admin.restaurants.show', $restaurant));
    }
    
    public function test_user_cannot_created_admin_destroy(){

        $restaurant = Restaurant::factory()->create();

        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));

        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
        
        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginUser_cannot_create_admin_destroy(){

        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.restaurants.destroy', $restaurant));


        $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);

        $response->assertRedirect(route('admin.login'));
    }

    public function test_loginAdmin_can_access_admin_destroy(){

        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $restaurant = Restaurant::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.restaurants.destroy', $restaurant));

        $this->assertDatabaseMissing('restaurants', ['id' => $restaurant->id,]);

        $response->assertRedirect(route('admin.restaurants.index'));

       
    }

    


}
