<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CartController extends Controller
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

        // Initialize cart and order status
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }
        if (!session()->has('order_status')) {
            session(['order_status' => '']);
        }

        $cart = session('cart', []);

        // Calculate cart total
        $cartTotal = 0;
        $cartItems = [];
        foreach ($cart as $id => $quantity) {
            foreach ($snacks as $snack) {
                if ($snack['id'] == $id) {
                    $itemTotal = $snack['price'] * $quantity;
                    $cartTotal += $itemTotal;
                    $cartItems[] = [
                        'id' => $id,
                        'name' => $snack['name'],
                        'price' => $snack['price'],
                        'quantity' => $quantity,
                        'total' => $itemTotal
                    ];
                    break;
                }
            }
        }

        // Determine order status for simulation
        $orderStatus = session('order_status', '');
        $orderProgress = '';
        if ($orderStatus == 'confirmed') {
            $orderTime = session('order_time', time());
            $elapsedTime = time() - $orderTime;
            if ($elapsedTime < 300) { // 5 minutes
                $orderProgress = 'preparing';
            } elseif ($elapsedTime < 900) { // 15 minutes
                $orderProgress = 'on_the_way';
            } else {
                $orderProgress = 'delivered';
            }
        }

        return view('cart.index', compact('cartItems', 'cartTotal', 'orderStatus', 'orderProgress'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0|max:10'
        ]);

        $cart = session('cart', []);
        $productId = $request->product_id;
        $quantity = $request->quantity;

        if ($quantity > 0) {
            $cart[$productId] = $quantity;
        } else {
            unset($cart[$productId]);
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (!empty($cart)) {
            session([
                'order_status' => 'confirmed',
                'order_time' => time(),
                'estimated_delivery' => time() + (15 * 60) // 15 minutes
            ]);
        }

        return redirect()->route('cart.index');
    }
}
