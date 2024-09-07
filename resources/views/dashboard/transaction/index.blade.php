@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produk Makanan</h5>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>
                                        Nama Pembeli
                                    </th>
                                    <th>
                                        Kode Transaksi
                                    </th>

                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    {{-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> --}}
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>{{ $transaction->kode_pesanan }}</td>
                                        <td>
                                            {{ $transactionSum->where('kode_pesanan', $transaction->kode_pesanan)->sum('quantity') }}
                                        </td>
                                        <td>
                                            {{ $transactionSum->where('kode_pesanan', $transaction->kode_pesanan)->sum('quantity') * $transaction->product->price }}
                                        </td>
                                        <td> <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $transaction->id }}">
                                                Detail
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="detailModal{{ $transaction->id }}" tabindex="-1"
                                                aria-labelledby="detailModal{{ $transaction->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="detailModal{{ $transaction->id }}Label">Modal title
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table>
                                                                <tr>
                                                                    <th>Produk</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga</th>

                                                                </tr>
                                                                @foreach ($transactionSum->where('kode_pesanan', $transaction->kode_pesanan) as $transaction)
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
                                                                <p> {{ $transactionSum->where('kode_pesanan', $transaction->kode_pesanan)->sum('quantity') }}
                                                                </p>
                                                            </div>
                                                            <div class="col">
                                                                <h5>Total Price</h5>
                                                                <p> {{ $transactionSum->where('kode_pesanan', $transaction->kode_pesanan)->sum('quantity') * $transaction->product->price }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
@endsection
