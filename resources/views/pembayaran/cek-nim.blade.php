@extends('layouts.app')

@section('content')
    <div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cek NIM Mahasiswa</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pembayaran.post-cek-nim') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Masukan Nomer Induk Mahasiswa</label>
                        <input type="text" name="nim" class="form-control" value="{{ old('nim') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Cek</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection