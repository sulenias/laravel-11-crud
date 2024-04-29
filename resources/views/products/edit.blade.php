<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-dark">Back</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg my-3">
                    <div class="card-header bg-dark">
                        <h3 class="text-white">Edit Products</h3>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('products.update', $product->id) }}"
                        method="post">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label h5">Name</label>
                                <input value="{{ old('name', $product->name) }}" type="text"
                                    class="@error('name') is-invalid @enderror form-control form-control-lg form-control"
                                    placeholder="Name" name="name">
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Sku</label>
                                <input value="{{ old('sku', $product->sku) }}" type="text"
                                    class="@error('sku') is-invalid @enderror form-control form-control-lg"
                                    placeholder="Sku" name="sku">
                                @error('sku')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Price</label>
                                <input value="{{ old('price', $product->price) }}" type="text"
                                    class="@error('price') is-invalid @enderror form-control form-control-lg"
                                    placeholder="Price" name="price">
                                @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Description</label>
                                <textarea name="description" cols="30" rows="5" class="form-control" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Image</label>
                                <input type="file" class="form-control form-control-lg" placeholder="Price"
                                    name="image">

                                @if ($product->image != '')
                                    <img class="w-50 my-3" src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="">
                                @endif
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
