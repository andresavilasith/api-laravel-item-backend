<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function default_data()
    {
        Item::factory(10)->create();
    }

    /** @test */
    public function test_item_index()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/item');

        $items = Item::paginate(5);
        $response->assertOk();

        $response->assertJsonStructure(['items', 'status']);
    }

    /** @test */
    public function test_item_show()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

        $item = Item::first();

        $response = $this->getJson('/api/item/' . $item->id);

        $response->assertOk();

        $response->assertJsonStructure(['item', 'status']);
    }

    /** @test */
    public function test_item_create()
    {
        $this->withoutExceptionHandling();


        $response = $this->getJson('/api/item/create');

        $response->assertOk();

        $response->assertJsonStructure([
            'status'
        ])->assertStatus(200);
    }


    /** @test  */
    public function test_item_store()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

        $name = 'Category 1 now';
        $description = 'New Category';


        $response = $this->postJson('/api/item', [
            'name' => $name,
            'description' => $description
        ]);


        $response->assertOk();

        $this->assertCount(8, Item::all());

        $item = Item::latest('id')->first();

        $this->assertEquals($item->name, $name);
        $this->assertEquals($item->description, $description);

        $response->assertJsonStructure([
            'status',
            'message'
        ])->assertStatus(200);
    }

    public function test_item_edit()
    {
        $this->withoutExceptionHandling();


        $item = Item::first();


        $response = $this->getJson('/api/item/' . $item->id . '/edit');

        $response->assertOk();

        $response->assertJsonStructure(['item', 'status'])->assertStatus(200);
    }

    public function test_item_update()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

        $item = Item::first();

        $name = 'category edit';
        $description = 'new category';

        $response = $this->putJson('/api/item/' . $item->id, [
            'name' => $name,
            'description' => $description
        ]);



        $response->assertOk();

        $this->assertCount(7, Item::all());

        $item = $item->fresh();

        $this->assertEquals($item->name, $name);
        $this->assertEquals($item->description, $description);

        $response->assertJsonStructure(['status', 'message'])->assertStatus(200);
    }

    public function test_item_destroy()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

        $item = Item::first();

        $response = $this->deleteJson('/api/item/' . $item->id);


        $response->assertOk();

        $this->assertCount(6, Item::all());

        $response->assertJsonStructure(['status', 'message', 'items'])->assertStatus(200);
    }
}
