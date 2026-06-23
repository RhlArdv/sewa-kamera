<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Product $camera;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Category
        $category = Category::create([
            'kategori_name' => 'Mirrorless',
            'slug' => 'mirrorless',
        ]);

        // Setup Product
        $this->camera = Product::create([
            'produk_name' => 'Sony Alpha A6400',
            'unit' => 2,
            'price' => 30000,
            'description' => 'Sony Mirrorless',
            'category_id' => $category->id_kategori,
        ]);

        // Setup Pelanggan User
        $this->user = User::create([
            'name' => 'Pelanggan Biasa',
            'email' => 'pelanggan@sewakamera.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);
    }

    public function test_unauthenticated_user_cannot_access_cart(): void
    {
        $response = $this->get(route('cart.index'));
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_cart(): void
    {
        $response = $this->actingAs($this->user)->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertViewHas('cartItems');
    }

    public function test_can_add_camera_to_cart_successfully(): void
    {
        $startTime = Carbon::now()->addHour()->toDateTimeString();
        $endTime = Carbon::now()->addHours(3)->toDateTimeString(); // 2 hours duration

        $response = $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'produk_id' => $this->camera->id_produk,
                'banyak' => 1,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tb_chart', [
            'user_id' => $this->user->id,
            'produk_id' => $this->camera->id_produk,
            'banyak' => 1,
            'duration_hours' => 2,
            'total' => 60000, // 30000 * 1 unit * 2 hours
        ]);
    }

    public function test_cannot_add_camera_if_not_enough_stock(): void
    {
        $startTime = Carbon::now()->addHour()->toDateTimeString();
        $endTime = Carbon::now()->addHours(3)->toDateTimeString();

        // Request 3 units, but stock is only 2
        $response = $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'produk_id' => $this->camera->id_produk,
                'banyak' => 3,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

        $response->assertSessionHasErrors(['banyak']);
        $this->assertDatabaseMissing('tb_chart', [
            'user_id' => $this->user->id,
            'produk_id' => $this->camera->id_produk,
        ]);
    }

    public function test_cannot_add_camera_with_duration_less_than_one_hour(): void
    {
        $startTime = Carbon::now()->addHour()->toDateTimeString();
        // same time + 10 mins (less than 1 hour)
        $endTime = Carbon::now()->addHour()->addMinutes(10)->toDateTimeString();

        $response = $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'produk_id' => $this->camera->id_produk,
                'banyak' => 1,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

        $response->assertSessionHasErrors(['end_time']);
    }

    public function test_can_remove_item_from_cart(): void
    {
        $cart = Cart::create([
            'user_id' => $this->user->id,
            'produk_id' => $this->camera->id_produk,
            'banyak' => 1,
            'start_time' => Carbon::now()->addHour(),
            'end_time' => Carbon::now()->addHours(2),
            'duration_hours' => 1,
            'total' => 30000,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('cart.destroy', ['id' => $cart->id_chart]));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tb_chart', [
            'id_chart' => $cart->id_chart,
        ]);
    }
}
