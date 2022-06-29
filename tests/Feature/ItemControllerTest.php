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

        $this->default_data();

        $response = $this->get('/api/item');

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

        $titulo = 'Titulo 1';
        $descripcion = 'New Titulo descripcion';
        $precio = 10.50;

        $response = $this->postJson('/api/item', [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'precio' => $precio
        ]);

        $response->assertOk();

        $this->assertCount(11, Item::all());

        $item = Item::latest('id')->first();

        $this->assertEquals($item->titulo, $titulo);
        $this->assertEquals($item->descripcion, $descripcion);
        $this->assertEquals($item->precio, $precio);


        $response->assertJsonStructure([
            'status',
            'message',
            'item'
        ])->assertStatus(200);
    }

    public function test_item_edit()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

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

        $titulo = 'Titulo 1 editado';
        $descripcion = 'New Titulo descripcion editado';
        $precio = 20.50;

        $response = $this->putJson('/api/item/' . $item->id, [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'precio' => $precio
        ]);


        $response->assertOk();

        $this->assertCount(10, Item::all());

        $item = $item->fresh();

        $this->assertEquals($item->titulo, $titulo);
        $this->assertEquals($item->descripcion, $descripcion);
        $this->assertEquals($item->precio, $precio);

        $response->assertJsonStructure(['status', 'message', 'item'])->assertStatus(200);
    }

    public function test_item_destroy()
    {
        $this->withoutExceptionHandling();

        $this->default_data();

        $item = Item::first();

        $response = $this->deleteJson('/api/item/' . $item->id);

        $response->assertOk();

        $this->assertCount(9, Item::all());

        $response->assertJsonStructure(['status', 'message', 'items'])->assertStatus(200);
    }
}
