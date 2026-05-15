<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $item = Item::findOrFail($id);

        if ($item->stock <= 0) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'item_id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        
        return back()->with('success', 'Barang ditambahkan ke cart');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        unset($cart[$id]);

        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cart diupdate');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required|min:10|max:100',
            'postal_code' => 'required|digits:5'
        ]);

        $cart = session()->get('cart', []);

        if (!$cart) {
            return back()->with('error', 'Cart kosong');
        }

        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }

        $invoice = Invoice::create([
            'invoice_number' => 'TEMP',
            'user_id' => auth()->id(),
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'total_price' => $total
        ]);

        $invoice->invoice_number = 'INV-' .str_pad($invoice->id, 3, '0', STR_PAD_LEFT);
        $invoice->save();

        foreach ($cart as $cartItem) {

            $item = Item::find($cartItem['item_id']);

            if ($item->stock < $cartItem['quantity']) {
                return back()->with('error', 'Stok tidak cukup untuk ' . $item->name);
            }

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_id' => $item->id,
                'quantity' => $cartItem['quantity'],
                'subtotal' => $item->price * $cartItem['quantity']
            ]);

            $item->stock -= $cartItem['quantity'];
            $item->save();
        }

        session()->forget('cart');

        return redirect('/invoice/' . $invoice->id)
            ->with('success', 'Checkout berhasil');
    }

    public function show($id)
    {
        $invoice = Invoice::with('items.item.category')->findOrFail($id);
        return view('invoice', compact('invoice'));
    }
}