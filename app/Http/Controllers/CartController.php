<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว');
    }
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_slip')->store('payment_slips', 'public');

         // ✅ ดึงข้อมูลตะกร้า
        $cart = session()->get('cart', []);

        // ตรวจสอบสินค้าคงเหลือ (ถ้าต้องการ)
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product && $product->Amount < $item['quantity']) {
                return back()->with('error', "สินค้า {$product->name} คงเหลือไม่พอ");
            }
        }
        
        // สมมุติบันทึก order (ไม่มี user_id)
        Order::create([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'payment_slip_path' => $path,
            'cart_data' => json_encode(session('cart')), // ถ้าใช้ session cart
        ]);
        
        // ✨ ลด stock ของสินค้า
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $product->Amount = max(0, $product->Amount - $item['quantity']); // ป้องกันติดลบ
                    $product->save();
                }
            }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'ขอบคุณที่สั่งซื้อ เราได้รับคำสั่งซื้อของคุณแล้ว');
    }
    public function order()
    {
        $orders = Order::latest()->get(); // ดึงทั้งหมด เรียงล่าสุดก่อน
        return view('order', compact('orders'));
    }
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'ลบคำสั่งซื้อเรียบร้อยแล้ว');
    }
}
