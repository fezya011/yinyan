<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\Lead\LeadController;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Product;
use App\Services\LeadNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;

    private Product $product1;
    private Product $product2;

    protected function setUp(): void
    {
        parent::setUp();

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

    public function test_can_successfully_store_a_lead_with_minimal_required_data(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'John Doe',
            'phone' => '+79991234567',
            'agree' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.')
            ->assertJsonStructure([
                'success',
                'message',
                'lead_id',
            ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'John Doe',
            'phone' => '+79991234567',
            'status' => Lead::STATUS_NEW,
        ]);
    }

    public function test_can_store_a_lead_with_all_optional_fields(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Jane Smith',
            'phone' => '+79997654321',
            'email' => 'jane@example.com',
            'message' => 'Interested in your products',
            'estimated_budget' => '50000-100000',
            'delivery_city' => 'Moscow',
            'interested_products' => [$this->product1->id, $this->product2->id],
            'agree' => true,
        ]);

        $response->assertStatus(201);

        $lead = Lead::first();
        $this->assertEquals('jane@example.com', $lead->email);
        $this->assertEquals('Interested in your products', $lead->message);
        $this->assertEquals('50000-100000', $lead->estimated_budget);
        $this->assertEquals('Moscow', $lead->delivery_city);
        $this->assertContains($this->product1->id, $lead->interested_products);
        $this->assertContains($this->product2->id, $lead->interested_products);
    }

    public function test_can_store_a_lead_with_single_product_id(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Bob Wilson',
            'phone' => '+79991112233',
            'product_id' => $this->product1->id,
            'agree' => true,
        ]);

        $response->assertStatus(201);

        $lead = Lead::first();
        $this->assertEquals($this->product1->id, $lead->product_id);
    }

    public function test_allows_nullable_email(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'email' => null,
            'agree' => true,
        ]);

        $response->assertStatus(201);
    }


    public function test_sends_notification_after_creating_lead(): void
    {
        $this->mock(LeadNotificationService::class, function ($mock) {
            $mock->shouldReceive('notify')
                ->once()
                ->withArgs(function ($lead) {
                    return $lead instanceof Lead
                        && $lead->name === 'Test User';
                });
        });

        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'agree' => true,
        ]);

        $response->assertStatus(201);
    }

    public function test_sets_lead_status_to_new(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'agree' => true,
        ]);

        $lead = Lead::first();
        $this->assertNotNull($lead, 'Lead was not created');
        $this->assertEquals(Lead::STATUS_NEW, $lead->status);
    }

    public function test_handles_empty_interested_products_array(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'interested_products' => [],
            'agree' => true,
        ]);

        $response->assertStatus(201);

        $lead = Lead::first();
        $this->assertNull($lead->interested_products);
    }

    public function test_returns_correct_http_status_code_201(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'agree' => true,
        ]);

        $response->assertCreated();
    }

    public function test_accepts_g_recaptcha_response_field(): void
    {
        $response = $this->postJson(action([LeadController::class, 'store']), [
            'name' => 'Test User',
            'phone' => '+79991234567',
            'g_recaptcha_response' => 'test-recaptcha-token',
            'agree' => true,
        ]);

        $response->assertStatus(201);
    }
}
