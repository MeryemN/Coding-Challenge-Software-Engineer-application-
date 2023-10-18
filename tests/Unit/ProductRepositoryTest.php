<?php -->

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = new ProductRepository();
    }


    // Creating a product with valid details should return the created product.
    public function test_create_product_with_valid_details()
    {
        $productDetails = [
            'name' => 'Test Product',
            'price' => 10.99,
            'category_id' => 1
        ];

        $createdProduct = $this->productRepository->createProduct($productDetails);

        $this->assertInstanceOf(Product::class, $createdProduct);
        $this->assertEquals('Test Product', $createdProduct->name);
        $this->assertEquals(10.99, $createdProduct->price);
        $this->assertEquals(1, $createdProduct->category_id);
    }

    // The getAllProducts method returns all products with their categories when no parameters are passed.
    // public function test_get_all_products_no_parameters()
    // {
    //     $repository = new ProductRepository();
    //     $products = $repository->getAllProducts(null);

    //     $this->assertNotEmpty($products);
    //     $this->assertCount(3, $products);
    //     $this->assertArrayHasKey('category', $products[0]);
    // }

    // // The getAllProducts method returns all products with their categories sorted by price when sortBy parameter is passed.
    // public function test_get_all_products_sortBy_parameter()
    // {
    //     $repository = new ProductRepository();
    //     $request = new \stdClass();
    //     $request->sortBy = 'asc';
    //     $products = $repository->getAllProducts($request);

    //     $this->assertNotEmpty($products);
    //     $this->assertCount(3, $products);
    //     $this->assertArrayHasKey('category', $products[0]);
    //     $this->assertEquals(100, $products[0]['price']);
    // }

    // // The getAllProducts method returns all products with their categories filtered by category_id when category_id parameter is passed.
    // public function test_get_all_products_category_id_parameter()
    // {
    //     $repository = new ProductRepository();
    //     $request = new \stdClass();
    //     $request->category_id = 1;
    //     $products = $repository->getAllProducts($request);

    //     $this->assertNotEmpty($products);
    //     $this->assertCount(2, $products);
    //     $this->assertArrayHasKey('category', $products[0]);
    //     $this->assertEquals(1, $products[0]['category_id']);
    // }

    // // The getAllProducts method returns an empty array when no products are available.
    // public function test_get_all_products_empty_array()
    // {
    //     $repository = new ProductRepository();
    //     $request = new \stdClass();
    //     $products = $repository->getAllProducts($request);

    //     $this->assertEmpty($products);
    // }
}
