@extends('layouts.app')

@section('title', 'GSC Cinema Real-Time System')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="container">
        <div class="logo">
            <h1>GSC</h1>
            <span>Golden Screen Cinemas - Real-Time System</span>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="container">
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome to GSC Cinema Real-Time System</h1>
            <p class="welcome-subtitle">
                Experience our cutting-edge real-time features designed for modern cinema operations.
                This demonstration showcases live countdown tracking and seat-to-seat snack delivery services.
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎬</div>
                    <h3 class="feature-title">Real-Time Movie Countdown</h3>
                    <p class="feature-description">
                        Dynamic countdown system that tracks different movie phases including pre-show,
                        ads, lights-off, intermission, and end times. Features live updates and
                        phase-appropriate visual themes.
                    </p>
                    <a class="feature-btn">View Countdown</a>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🍿</div>
                    <h3 class="feature-title">Seat-to-Seat Snack Delivery</h3>
                    <p class="feature-description">
                        Order snacks directly to your seat with real-time order tracking.
                        Features live cart updates, order status monitoring, and delivery tracking
                        from preparation to seat delivery.
                    </p>
                    <a href="{{ route('snacks.index') }}" class="feature-btn">Order Snacks</a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; 2025 Golden Screen Cinemas - Real-Time System Demo. Built for CSE443 Assignment.</p>
    </div>
</footer>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.feature-card');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });

    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-GB', { hour12: false });
        console.log('Current time:', timeString);
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection
