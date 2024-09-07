@extends('layouts.main')

@section('content')
    <div class="container">
        <h3 class="mt-5">
            Marketplace
        </h3>




        <div class="row row-cols-2 row-cols-md-6 g-7">
            @foreach ($merchants as $merchant)
                <a href="{{ '/merchant/' . $merchant->slug }}">
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $merchant->image != null ? asset('storage/images/' . $merchant->image) : '/assets/img/default.jpg' }}"
                                class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-title fw-bold text-truncate">{{ $merchant->company_name }}</p>
                                <p class="card-text">Tag : {{ $merchant->tag }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
@endsection
