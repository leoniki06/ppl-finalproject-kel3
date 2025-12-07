<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - LastBite</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #3F2305;
            margin-bottom: 30px;
            border-bottom: 2px solid #3F2305;
            padding-bottom: 10px;
        }

        .nav {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .nav-link.active {
            background: #3F2305;
            color: white;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .order-id {
            font-weight: 600;
            color: #3F2305;
        }

        .order-date {
            color: #666;
            font-size: 0.9rem;
        }

        .order-status {
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .order-items {
            margin-bottom: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #ddd;
        }

        .item-name {
            font-weight: 500;
        }

        .item-price {
            color: #3F2305;
        }

        .order-total {
            font-weight: 600;
            color: #3F2305;
            font-size: 1.1rem;
            text-align: right;
            margin-top: 10px;
        }

        .no-orders {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .btn {
            background: #3F2305;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #5a3510;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3F2305;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nav">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('profile') }}" class="nav-link">Profile</a>
            <a href="{{ route('profile.orders') }}" class="nav-link active">My Orders</a>
            <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>

        <h1>My Orders</h1>

        @if ($orders->count() > 0)
            @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <div class="order-id">Order #{{ $order->id }}</div>
                            <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <span class="order-status status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="order-items">
                        @foreach ($order->items as $item)
                            <div class="order-item">
                                <span class="item-name">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                <span class="item-price">Rp
                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-orders">
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('dashboard') }}" class="btn" style="margin-top: 15px;">
                    Browse Products
                </a>
            </div>
        @endif

        <a href="{{ route('profile') }}" class="back-link">← Back to Profile</a>
    </div>
</body>

</html>
