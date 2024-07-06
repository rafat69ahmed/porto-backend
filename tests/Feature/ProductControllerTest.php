<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching the product list.
     *
     * @return void
     */
    public function testFetchProductList()
    {
        $user = User::factory()->create();
        // $products = Product::factory()->count(15)->create();

        $response = $this->actingAs($user, 'api')->get('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'data' => [
                    '*' => ['id', 'name', 'description', 'category', 'price', 'stock', 'image', 'sku', 'created_at', 'updated_at']
                ]
            ]
        ]);
    }

    /**
     * Test creating a new product.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $user = User::factory()->create();
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'category' => 'Test Category',
            'price' => 100.00,
            'stock' => 50,
            'image' => 'test_image.png',
            'sku' => 'TESTSKU123'
        ];

        $response = $this->actingAs($user, 'api')->post('/api/v1/products', $productData);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => [
                'name' => 'Test Product',
                'description' => 'This is a test product.',
                'category' => 'Test Category',
                'price' => 100.00,
                'stock' => 50,
                'image' => 'test_image.png',
                'sku' => 'TESTSKU123'
            ]
        ]);

        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Test showing a product by ID.
     *
     * @return void
     */
    public function testShowProduct()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->get('/api/v1/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'category' => $product->category,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'sku' => $product->sku
            ]
        ]);
    }

    /**
     * Test deleting a product.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->delete('/api/v1/products/' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'category' => $product->category,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'sku' => $product->sku
            ]
        ]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
