<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;

class ItemController extends Controller
{
    public function userPage()
    {
        $itemList = Item::paginate(5);
        return view ('user', compact('itemList'));
    }

    public function adminPage()
    {
        $itemList = Item::paginate(5);
        return view ('admin', compact('itemList'));
    }

    public function showCreate()
    {   
        $categoryList = ItemCategory::all();
        return view('create', compact('categoryList'));
    }


    public function create(Request $req)
    {   
        $req->validate([
            'name' => 'required|string|min:5|max:80',
            'description' => 'required|string|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category_id' => 'required|exists:item_categories,id',
            'price' => 'required|integer|min:0'
        ]);

        $filename =null;

        if ($req->hasFile('image')) {
            $now = now()->format('Y-m-d_H.i.s');
            $filename = $now . '_' . $req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('images', $filename, 'public'); 
        }


        Item::create([
            'name' => $req->name,
            'description' => $req->description,
            'stock' => $req->stock,
            'image' => $filename,
            'category_id' => $req->category_id,
            'price' => $req->price
        ]);

        return redirect()->route('admin.page');
    }

    public function showUpdate($id)
    {   
        $categoryList = ItemCategory::all();
        $item = Item::findOrFail($id);
        return view('update', compact('item', 'categoryList'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|min:5|max:80',
            'description' => 'required|string|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'category_id' => 'required|exists:item_categories,id',
            'price' => 'required|integer|min:0'
        ]);

        $item = Item::findOrFail($id);
        $item->name = $req->name;
        $item->description = $req->description;
        $item->stock = $req->stock;
        $item->category_id = $req->category_id;
        $item->price = $req->price;

        if ($req->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete('images/' . $item->image);
            }
            $now = now()->format('Y-m-d_H.i.s');
            $filename = $now . '_' . $req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('images', $filename, 'public'); 
            $item->image = $filename;
        }

        $item->save();

        return redirect()->route('admin.page');
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);
        if ($item->image) {
            Storage::disk('public')->delete('images/' . $item->image);
        }
        $item->delete();
        
        return redirect()->route('admin.page');
    }

}
