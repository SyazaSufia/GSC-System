@extends('layouts.app')

@section('title', 'GSC Snack Delivery - Seat F12')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/snack_delivery_styles.css') }}">
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
        <div class="cart-icon">
            <a href="{{ route('cart.index') }}">
                <span class="cart-count">{{ $cartCount }}</span>
                🛒 RM{{ number_format($cartTotal, 2) }}
            </a>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <h2>Order Snacks to Your Seat</h2>
        <p class="subtitle">Enjoy your movie with delicious snacks delivered right to your seat!</p>

        <div class="snacks-grid">
            @foreach($snacks as $snack)
            <div class="snack-card">
                <div class="snack-image">
                    <img src="{{ asset('images/' . $snack['image']) }}" alt="{{ $snack['name'] }}">
                </div>
                <div class="snack-info">
                    <h3>{{ htmlspecialchars($snack['name']) }}</h3>
                    <p class="price">RM{{ number_format($snack['price'], 2) }}</p>
                    <form method="POST" action="{{ route('snacks.addToCart') }}" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $snack['id'] }}">
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn minus" onclick="decreaseQty(this)">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="10" class="qty-input">
                            <button type="button" class="qty-btn plus" onclick="increaseQty(this)">+</button>
                        </div>
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; 2025 Golden Screen Cinemas. All rights reserved.</p>
    </div>
</footer>
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
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    setInterval(function() {
        console.log('Checking for cart updates...');
    }, 5000);
</script>
@endsection
