<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class='p-5' style="background-color: #a1ffd0;">
<div class="container mt-5 p-3 mx-auto" style="background-color: #ffffff; border-radius: 20px; max-width: 1000px;">
     <h1 style="margin-bottom: 50px; display: flex;">Cart</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3" role="alert">
        {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed bottom-0 end-0 m-3" role="alert">
        {{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- <table border="1" cellpadding="10"> -->
    <table class='table table-bordered table-hover text-center' style="margin-bottom: 20px;">
        <thead class="table-primary">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        </thead>
    
        @php
            $total = 0;
        @endphp

        @foreach($cart as $id => $item)

            @php
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            @endphp

            <tr>
                <td>{{ $item['name'] }}</td>

                <td>
                    Rp. {{ number_format($item['price'], 0, ',', '.') }}
                </td>

                <td>
                    <form action="/cart/update/{{ $id }}" method="POST">
                        @csrf

                        <input type="number"
                               name="quantity"
                               value="{{ $item['quantity'] }}"
                               min="1">

                        <button type="submit" class="btn btn-warning">
                            Update
                        </button>
                    </form>
                </td>

                <td>
                    Rp. {{ number_format($subtotal, 0, ',', '.') }}
                </td>

                <td>
                    <form action="/cart/remove/{{ $id }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-danger">
                            Remove
                        </button>
                    </form>
                </td>
            </tr>

        @endforeach

    </table>

    <h3 style="margin-bottom: 20px;" class="fs-5">
        Total Harga:
        Rp. {{ number_format($total, 0, ',', '.') }}
    </h3>

    <hr>

    <h2 style="margin-bottom: 50px;">Checkout</h2>

    <form action="/checkout" method="POST" onsubmit="return confirm('Checkout ini tidak bisa dibatalkan. Jika dilanjutkan, Anda akan diarahkan ke halaman cetak faktur. Lanjutkan?')">
        @csrf

        <div style="margin-bottom: 20px;">
            <label>Shipping Address</label>
            <textarea name="address" class='form-control' required></textarea>

            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div style="margin-bottom: 20px;">
            <label>Postal Code</label>
            <input type="text" name="postal_code" class='form-control' required>
            @error('postal_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    <div style="margin-bottom: 20px;">
        <button type="submit" class="btn btn-primary" style="margin-right: 20px;">
            Checkout
        </button>

        <a href="{{ route('userPage') }}">
            <button type="button" class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>

    </form>
</div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>