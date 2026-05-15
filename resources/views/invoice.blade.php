<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print Invoice</title>
    <style>@media print {.no-print{display:none !important;}}</style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body style="margin-left: 10px; margin-top: 50px; max-width: fit-content; background-color: #a1ffd0;">
    <h1 class="no-print mb-5 p-3" style="background-color: #00fe7f; border-radius: 20px; font-family: 'Franklin Gothic Medium';">Halaman Cetak Faktur</h1>
    <div class="container mt-5 p-3" style="background-color: #ffffff; border-radius: 20px;">
    
    <h1 style= "font-family: 'Franklin Gothic Medium'; margin-bottom: 20px; height: 100px; padding: 20px; display: flex; align-items: center; gap: 15px;">
        <img src="{{ asset('images/Londo_Bell_Logo.svg') }}" alt="Londo Bell Logo" style="height: 60px; width: auto; margin-right: 10px;">
        <div>Londo Bell</div>
    </h1>

    <h2>
        Faktur Pembelian
    </h2>
    <hr>

    <div style="margin-bottom: 20px;">
        <strong>Invoice No:</strong>
        {{ $invoice->invoice_number }}
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Shipping Address:</strong>
        {{ $invoice->address }}
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Postal Code:</strong>
        {{ $invoice->postal_code }}
    </div>

    <hr>

    <table class='table table-bordered' style="max-width: 500px; margin-top: 50px; margin-bottom: 50px;">
        <thead class="table-primary">
        <tr>
            <th>Category</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        @foreach($invoice->items as $item)

        <tr>

    <td style="margin-bottom: 20px;">
        {{ $item->item->category->category }}
    </td>

    <td style="margin-bottom: 20px;">
        {{ $item->item->name }}
    </td>

    <td style="margin-bottom: 20px;">
        {{ $item->quantity }}
    </td>

    <td style="margin-bottom: 20px;">
        Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
    </td>

</tr>

        @endforeach

    </table>

    <h2 class="fs-5" style="margin-bottom: 20px;">
        Total:
        Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}
    </h2>

    <hr>

    <button onclick="window.print()" class="btn btn-primary no-print" style="margin-bottom: 20px; margin-right: 10px;">
        Cetak Faktur
    </button>
    <!-- <a href="{{ route('userPage') }}">
    <button type="button" class="btn btn-secondary no-print">Back</button>
</a> -->
    <a href="{{ route('userPage') }}" class="btn btn-secondary no-print" onclick="return confirm('Kembali ke halaman dashboard?')" style="margin-bottom: 20px;">
        Back
    </a>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>