@extends('layouts.main')


@section('content')
    <div class="container mt-5" style="margin-bottom: 300px">
        <div class="row">
            <div class="col mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <!-- Gambar Profil -->
                            <div class="me-3">
                                <img src="{{ $merchant->image ? asset('/storage/images/' . $merchant->image) : 'https://via.placeholder.com/150' }}"
                                    alt="merchant Image" class="img-fluid rounded-circle"
                                    style="max-height: 150px; width: auto;">
                            </div>
                            <!-- Informasi Profil -->
                            <div>
                                <h3 class="card-title">{{ $merchant->company_name }}</h3>
                                <p class="card-text"><strong>Alamat:</strong> {{ $merchant->address }}</p>
                                <p class="card-text"><strong>Kontak:</strong> {{ $merchant->contact }}</p>
                                <p class="card-text"><strong>Deskripsi:</strong> {{ $merchant->description }}</p>
                                <p class="card-text"><strong>Tags:</strong> {{ $merchant->tags }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5 fw-bold">Product</h3>
        <div class="row row-cols-2 row-cols-md-6 g-7">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $product->image != null ? asset('storage/' . $product->image) : '/assets/img/default.jpg' }}"
                            class="card-img-top" alt="{{ $product->product_name }}">
                        <div class="card-body">
                            <p class="card-title fw-bold text-truncate">{{ $product->product_name }}</p>
                            <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <!-- Tombol Pesan -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#orderModal{{ $product->id }}">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Pemesanan -->
                <div class="modal fade" id="orderModal{{ $product->id }}" tabindex="-1"
                    aria-labelledby="orderModalLabel{{ $product->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="orderModalLabel{{ $product->id }}">Pesan
                                    {{ $product->product_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <img src="{{ $product->image != null ? asset('storage/' . $product->image) : '/assets/img/default.jpg' }}"
                                class="card-img-top" alt="{{ $product->product_name }}"
                                style="height: 200px; object-fit:contain; width: 100%">
                            <div class="container">
                                <h3>{{ $product->product_name }}</h3>
                                <p>{{ $product->description }}</p>
                                <form action="/transaction/store" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Jumlah</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="decreaseQuantity({{ $product->id }})">−</button>
                                                <input type="number" name="quantity" id="quantity-{{ $product->id }}"
                                                    class="form-control text-center" value="1" min="1" readonly>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="increaseQuantity({{ $product->id }})">+</button>
                                            </div>
                                            <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <style>
            .footer {
                background-color: #f8f9fa;
                padding: 20px;
                border-top: 1px solid #e9ecef;
            }
        </style>

        <footer class="footer fixed-bottom">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h5>Total Quantity</h5>
                        <p>{{ $totalQuantity }}</p>
                    </div>
                    <div class="col">
                        <h5>Total Price</h5>
                        <p>{{ $totalPrice }}</p>
                    </div>
                    <div class="col">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal">
                            Detail
                        </button>


                    </div>
                </div>
            </div>

        </footer>

        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>

                            </tr>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->product->product_name }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->product->price }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div class="col">
                            <h5>Total Quantity</h5>
                            <p>{{ $totalQuantity }}</p>
                        </div>
                        <div class="col">
                            <h5>Total Price</h5>
                            <p>{{ $totalPrice }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Fungsi untuk menambah jumlah
        function increaseQuantity(productId) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }

        // Fungsi untuk mengurangi jumlah
        function decreaseQuantity(productId) {
            const quantityInput = document.getElementById(`quantity-${productId}`);
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }
    </script>
@endsection
