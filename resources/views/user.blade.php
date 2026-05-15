<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #a1ffd0;">
    
    <h1 style= "font-family: 'Franklin Gothic Medium'; background-color: #00fe7f; height: 100px; padding: 20px; display: flex; align-items: center; gap: 15px;">
        <img src="{{ asset('images/Londo_Bell_Logo.svg') }}" alt="Londo Bell Logo" style="height: 60px; width: auto; margin-right: 10px;">
        <div>Londo Bell E-Shop User Page</div>                               
    </h1>
    

    <div class="p-5">
    <a href="/cart" class="btn btn-primary" style="margin-bottom: 40px; margin-top: 100px;">
    <img src="{{ asset('images/Cart_Logo.svg') }}" alt="Cart Logo" style="height: 35px; width: auto;">
    Cart
    </a>
    <h2 style="margin-bottom: 40px; border-radius: 5px; display: flex; align-items: center; gap: 15px;">
    Item List
    </h2>
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

    <table class='table table-bordered table-hover text-center' style="margin-bottom: 40px;">
        <thead class="table-primary">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemList as $item)
                <tr>
    
                    <td>
                        @if ($item->image)
                            <img src="{{ asset('storage/images/' . $item->image)}}" width='80' alt="Image">
                        @else
                            <span class='text-muted'>No Image</span>
                        @endif
                    </td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->stock}}</td>
                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->category->category ?? '-' }}</td>
                    <td>
                        <form action="/cart/add/{{ $item->id }}" method="POST">
                        @csrf
                            <button type="submit" class="btn btn-success">
                                + Add To Cart
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class='d-flex justify-content-center mt-4'>
        {{$itemList->links('pagination::bootstrap-5')}}
    </div>
    <form action="{{route('logout')}}" method='POST'>
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
        </form>   
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>