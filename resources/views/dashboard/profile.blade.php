@extends('dashboard.layouts.main')


@section('container')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Profil Merchant</div>

                    <form action="/dashboard/profile/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Perusahaan -->
                        <label class="mt-3" for="company_name">Nama Perusahaan</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                            name="company_name" id="company_name" value="{{ old('company_name', $profile->company_name) }}">
                        @error('company_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Alamat -->
                        <label class="mt-3" for="address">Alamat</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" cols="30"
                            rows="5">{{ old('address', $profile->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Kontak -->
                        <label class="mt-3" for="contact">Kontak</label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact"
                            id="contact" value="{{ old('contact', $profile->contact) }}">
                        @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Deskripsi -->
                        <label class="mt-3" for="description">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                            cols="30" rows="5">{{ old('description', $profile->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Upload Gambar -->
                        <label class="mt-3" for="image">Upload Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"
                            id="image" onchange="previewImage(event)">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Preview Gambar -->
                        <div class="mt-3">
                            <img id="imagePreview"
                                src="{{ $profile->image ? asset('storage/images/' . $profile->image) : '#' }}"
                                alt="Preview Image" style="max-height: 200px;">
                        </div>

                        <!-- Input Tags -->
                        <label class="mt-3" for="tag">Tag</label>
                        <input type="text" class="form-control @error('tag') is-invalid @enderror" name="tag"
                            id="tag" value="{{ old('tag', $profile->tag) }}" placeholder="Pisahkan tag dengan koma">
                        @error('tag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <button type="submit" class="btn btn-sm btn-primary mt-5">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
