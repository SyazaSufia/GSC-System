<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SnackController extends Controller
{
    private function getSnacks()
    {
        return [
            ['id' => 1, 'name' => 'Popcorn (Large)', 'price' => 12.90, 'image' => 'popcorn.jpg'],
            ['id' => 2, 'name' => 'Nachos with Cheese', 'price' => 8.90, 'image' => 'nachos.jpg'],
            ['id' => 3, 'name' => 'Hot Dog', 'price' => 6.50, 'image' => 'hotdog.jpg'],
            ['id' => 4, 'name' => 'Coke (Medium)', 'price' => 5.90, 'image' => 'coke.jpg'],
            ['id' => 5, 'name' => 'Ice Cream', 'price' => 4.50, 'image' => 'icecream.jpg'],
            ['id' => 6, 'name' => 'Candy Mix', 'price' => 7.90, 'image' => 'candy.jpg']
        ];
    }

    public function index()
    {
        $snacks = $this->getSnacks();

        // Initialize cart if not exists
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        $cart = session('cart', []);

        // Calculate cart total and count
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $id => $quantity) {
            foreach ($snacks as $snack) {
                if ($snack['id'] == $id) {
                    $cartTotal += $snack['price'] * $quantity;
                    $cartCount += $quantity;
                    break;
                }
            }
        }

        return view('snacks.index', compact('snacks', 'cartTotal', 'cartCount'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart = session('cart', []);
        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session(['cart' => $cart]);

        return redirect()->route('snacks.index');
    }
}
