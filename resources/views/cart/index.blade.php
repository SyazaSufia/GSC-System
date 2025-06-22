@extends('layouts.app')

@section('title', 'GSC Cart - Seat F12')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart_styles.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="container">
        <div class="logo">
            <h1>GSC</h1>
            <span>Golden Screen Cinemas</span>
        </div>
        <div class="seat-info">
            <span>Hall 3 - Seat F12</span>
            <span class="movie-title">Spider-Man: Across the Spider-Verse</span>
        </div>
        <div class="back-btn">
            <a href="{{ route('snacks.index') }}">← Back to Menu</a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        @if($orderStatus == 'confirmed')
            <!-- Order Tracking Section -->
            <div class="order-tracking">
                <h2>Order Tracking</h2>
                <div class="tracking-progress">
                    <div class="progress-step {{ in_array($orderProgress, ['preparing', 'on_the_way', 'delivered']) ? 'active' : '' }}">
                        <div class="step-icon">🍿</div>
                        <div class="step-label">Preparing</div>
                    </div>
                    <div class="progress-line {{ in_array($orderProgress, ['on_the_way', 'delivered']) ? 'active' : '' }}"></div>
                    <div class="progress-step {{ in_array($orderProgress, ['on_the_way', 'delivered']) ? 'active' : '' }}">
                        <div class="step-icon">🚶</div>
                        <div class="step-label">On the Way</div>
                    </div>
                    <div class="progress-line {{ $orderProgress == 'delivered' ? 'active' : '' }}"></div>
                    <div class="progress-step {{ $orderProgress == 'delivered' ? 'active' : '' }}">
                        <div class="step-icon">✅</div>
                        <div class="step-label">Delivered</div>
                    </div>
                </div>

                <div class="order-status">
                    @if($orderProgress == 'preparing')
                        <p class="status-text">Your order is being prepared! 🍿</p>
                        <p class="eta">Estimated delivery: {{ date('H:i', session('estimated_delivery')) }}</p>
                    @elseif($orderProgress == 'on_the_way')
                        <p class="status-text">Your order is on the way to your seat! 🚶</p>
                        <p class="eta">Should arrive in 2-3 minutes</p>
                    @elseif($orderProgress == 'delivered')
                        <p class="status-text">Your order has been delivered! Enjoy your snacks! 🎉</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Cart Section -->
        <div class="cart-section">
            <h2>Your Cart</h2>

            @if(empty($cartItems))
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <a href="{{ route('snacks.index') }}" class="continue-shopping-btn">Continue Shopping</a>
                </div>
            @else
                <div class="cart-items">
                    @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="item-info">
                            <h3>{{ htmlspecialchars($item['name']) }}</h3>
                            <p class="item-price">RM{{ number_format($item['price'], 2) }} each</p>
                        </div>
                        <div class="item-controls">
                            <form method="POST" action="{{ route('cart.update') }}" class="quantity-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus" onclick="decreaseQty(this)">-</button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="10" class="qty-input">
                                    <button type="button" class="qty-btn plus" onclick="increaseQty(this)">+</button>
                                </div>
                                <button type="submit" name="update_cart" class="update-btn">Update</button>
                            </form>
                            <form method="POST" action="{{ route('cart.remove') }}" class="remove-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <button type="submit" name="remove_item" class="remove-btn">Remove</button>
                            </form>
                        </div>
                        <div class="item-total">
                            <strong>RM{{ number_format($item['total'], 2) }}</strong>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <div class="total-amount">
                        <h3>Total: RM{{ number_format($cartTotal, 2) }}</h3>
                    </div>

                    @if($orderStatus != 'confirmed')
                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button type="submit" name="checkout" class="checkout-btn">
                            Proceed to Checkout
                        </button>
                    </form>
                    @endif
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    function increaseQty(btn) {
        const input = btn.previousElementSibling;
        const currentValue = parseInt(input.value);
        if (currentValue < 10) {
            input.value = currentValue + 1;
        }
    }

    function decreaseQty(btn) {
        const input = btn.nextElementSibling;
        const currentValue = parseInt(input.value);
        if (currentValue >= 0) {
            input.value = currentValue - 1;
        }
    }

    @if($orderStatus == 'confirmed')
    setInterval(function() {
        location.reload();
    }, 30000);
    @endif

    setInterval(function() {
        console.log('Checking order status...');
    }, 5000);
</script>
@endsection
