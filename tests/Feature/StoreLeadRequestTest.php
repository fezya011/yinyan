<?php

namespace Tests\Feature;

use App\Http\Requests\Lead\StoreLeadRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreLeadRequestTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Создаем категорию для продукта
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);

        $this->product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'category_id' => $category->id,
            'price' => 1000,
        ]);
    }

    public function test_passes_validation_with_valid_data(): void
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+79991234567',
            'email' => 'john@example.com',
            'agree' => true,
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_fails_validation_without_name(): void
    {
        $data = [
            'phone' => '+79991234567',
            'agree' => true,
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
    }

    public function test_fails_validation_without_phone(): void
    {
        $data = [
            'name' => 'John Doe',
            'agree' => true,
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('phone'));
    }

    public function test_fails_validation_without_agree(): void
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+79991234567',
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('agree'));
    }

    public function test_allows_nullable_email(): void
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+79991234567',
            'email' => null,
            'agree' => true,
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_validates_email_format(): void
    {
        $data = [
            'name' => 'John Doe',
            'phone' => '+79991234567',
            'email' => 'invalid-email',
            'agree' => true,
        ];

        $validator = Validator::make($data, (new StoreLeadRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('email'));
    }

    public function test_authorizes_all_users(): void
    {
        $request = new StoreLeadRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_has_custom_validation_messages(): void
    {
        $messages = (new StoreLeadRequest())->messages();

        $this->assertArrayHasKey('name.required', $messages);
        $this->assertEquals('Укажите ваше имя', $messages['name.required']);
        $this->assertEquals('Укажите телефон для связи', $messages['phone.required']);
    }
}
