@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produk Makanan</h5>

                    <a href="/dashboard/product/create" class="btn btn-sm btn-primary">Tambah Produk Makanan</a>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    Gambar
                                </th>
                                <th>
                                    Nama Makanan
                                </th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                {{-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="Product" width="100">
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a href="/dashboard/product/{{ $product->id }}/edit"
                                            class="btn btn-sm btn-success">Edit</a>

                                        <form action="/dashboard/product/{{ $product->id }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
@endsection
