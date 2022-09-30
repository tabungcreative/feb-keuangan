@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-7 mt-2">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Nama</th>
                        <th>Saldo Awal</th>
                        <th>Aksi</th>
                    </tr>
                    @foreach ($data as $item)    
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td class="font-weight-bold">Rp. {{ number_format($item->saldo_awal) }}</td>
                            <td class="d-flex">
                                <button type="button" class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#modalUpdate-{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @include('akun.edit-modal')
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUpdateSaldo-{{ $item->id }}">
                                    update saldo
                                </button>
                                @include('akun.update-saldo-modal')
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-5 mt-2">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Akun</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('akun.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input type="number" name="saldo_awal" class="form-control">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection