<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Lead;
use App\Models\Product;
use App\Services\LeadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadServiceTest extends TestCase
{
    use RefreshDatabase;

    private LeadService $service;
    private Product $product1;
    private Product $product2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(LeadService::class);

        // Создаем категорию для продуктов
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);

        $this->product1 = Product::create([
            'name' => 'Product 1',
            'slug' => 'product-1',
            'category_id' => $category->id,
            'price' => 1000,
        ]);

        $this->product2 = Product::create([
            'name' => 'Product 2',
            'slug' => 'product-2',
            'category_id' => $category->id,
            'price' => 2000,
        ]);
    }

    public function test_creates_a_lead_with_basic_data(): void
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+79991234567',
        ];

        $lead = $this->service->create($data);

        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertEquals('John Doe', $lead->name);
        $this->assertEquals('+79991234567', $lead->phone);
        $this->assertEquals(Lead::STATUS_NEW, $lead->status);
    }

    public function test_creates_a_lead_with_all_optional_fields(): void
    {
        $data = [
            'name' => 'Jane Smith',
            'phone' => '+79997654321',
            'email' => 'jane@example.com',
            'message' => 'Test message',
            'estimated_budget' => '50000',
            'delivery_city' => 'Moscow',
            'interested_products' => [$this->product1->id, $this->product2->id],
        ];

        $lead = $this->service->create($data);

        $this->assertEquals('jane@example.com', $lead->email);
        $this->assertEquals('Test message', $lead->message);
        $this->assertEquals('50000', $lead->estimated_budget);
        $this->assertEquals('Moscow', $lead->delivery_city);
    }

    public function test_converts_interested_products_to_integers(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'interested_products' => [(string) $this->product1->id, (string) $this->product2->id],
        ];

        $lead = $this->service->create($data);

        $this->assertEquals([$this->product1->id, $this->product2->id], $lead->interested_products);
        $this->assertIsInt($lead->interested_products[0]);
        $this->assertIsInt($lead->interested_products[1]);
    }

    public function test_handles_null_interested_products(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'interested_products' => null,
        ];

        $lead = $this->service->create($data);

        $this->assertNull($lead->interested_products);
    }

    public function test_handles_missing_interested_products(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
        ];

        $lead = $this->service->create($data);

        $this->assertNull($lead->interested_products);
    }

    public function test_handles_empty_interested_products_array(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'interested_products' => [],
        ];

        $lead = $this->service->create($data);

        $this->assertNull($lead->interested_products);
    }

    public function test_always_sets_status_to_status_new(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'status' => 'some_other_status',
        ];

        $lead = $this->service->create($data);

        $this->assertEquals(Lead::STATUS_NEW, $lead->status);
    }

    public function test_returns_the_created_lead_instance(): void
    {
        $data = [
            'name' => 'Test User',
            'phone' => '+79991234567',
        ];

        $lead = $this->service->create($data);

        $this->assertNotNull($lead);
        $this->assertTrue($lead->exists);
        $this->assertTrue($lead->wasRecentlyCreated);
    }
}
