<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Update Item</title>
</head>
<body class='p-5' style="background-color: #a1ffd0;">
    <div class="container mt-5 p-3" style="background-color: #ffffff; border-radius: 20px;">
    <h2 style="margin-bottom: 50px; display: flex; align-items: center;">Update Item</h2>
    <form action="{{route('update', $item->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class='mb-3'>
            <label>Item Name</label>
            <input type="text" name='name' class='form-control' value = "{{$item->name}}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class='mb-3'>
            <label>Description</label>
            <textarea name='description' class='form-control' required>{{$item->description}}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class='mb-3'>
            <label>Stock</label>
            <input type="number" name='stock' class='form-control' value = "{{$item->stock}}" required>
            @error('stock')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class='mb-3'>
            <label>Price</label>
            <input type="number" name='price' class='form-control' value = "{{$item->price}}" required>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class='mb-3'>
            <label>Current Image</label><br>
            @if ($item->image)
                <img src="{{ asset('storage/images/' . $item->image)}}" width="100" class='mb-2' alt="">
            @else
                <span class='text-muted'>No Image Available</span>
            @endif
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class='mb-3'>
            <label>Upload New Image</label>
            <input type="file" name='image' class='form-control'>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" style="margin-bottom: 50px;" required>
                <option value="">Select Category</option>
                @foreach($categoryList as $category)
                    <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class='btn btn-success' style="margin-right: 20px;">Update</button>
        <a href="{{route('admin.page')}}" class='btn btn-secondary'>Cancel</a>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>