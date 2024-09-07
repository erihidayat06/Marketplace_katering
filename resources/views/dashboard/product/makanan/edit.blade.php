@extends('dashboard.layouts.main')

@section('container')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Edit Produk</h3>

                        <form action="/dashboard/product/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Product Name -->
                            <label class="mt-3" for="product_name">Nama Produk</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                name="product_name" id="product_name"
                                value="{{ old('product_name', $product->product_name) }}"
                                placeholder="Masukkan nama produk">
                            @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Image -->
                            <label class="mt-3" for="image">Upload Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                                id="image" accept="image/*" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <!-- Image Preview -->
                            <div class="mt-3">
                                <img id="image-preview"
                                    src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}"
                                    alt="Preview Gambar" class="img-fluid"
                                    style="max-height: 200px; {{ $product->image ? '' : 'display: none;' }}">
                            </div>

                            <!-- Description -->
                            <label class="mt-3" for="description">Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                cols="30" rows="5" placeholder="Masukkan deskripsi">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Price -->
                            <label class="mt-3" for="price">Harga</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                id="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan harga">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-sm btn-primary mt-5">Update Produk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const image = document.getElementById('image-preview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
@endsection
