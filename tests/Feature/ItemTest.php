<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Item;
use Tests\TestCase;

class ItemTest extends TestCase
{

    use RefreshDatabase;
    //skenario 1
    public function test_halaman_utama() : void {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    //skenario 2
    public function test_fungsi_create() : void {
        $response = $this->post('/create', [
            'name' => 'laptop ASUS ROG',
            'description' => 'ini laptop gaming',
            'stock' => 10
        ]);

        $response->assertRedirect(route('showItem'));

        $this->assertDatabaseHas('items', [
            'name' => 'laptop ASUS ROG',
            'stock' => 10
        ]);
    }

    //skenario 3
    public function test_fungsi_delete() :void {
        $item = Item::create([
            'name' => 'buku pelajar',
            'description' => 'ini adlaah buku pelajar',
            'stock' => 100
        ]);

        $response = $this->delete('/delete/' . $item->id);
        $response->assertRedirect(route('showItem'));

        $this->assertDatabaseMissing('items', [
            'id' => $item->id
        ]);
    }
}
