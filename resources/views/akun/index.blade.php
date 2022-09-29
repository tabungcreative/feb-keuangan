@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-left my-4">
    <div class="col-md-8 mt-2">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Nama</th>
                        <th>Jenis Akun</th>
                        <th>Saldo</th>
                        <th>Aksi</th>
                    </tr>
                    @foreach ($data as $item)    
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <span class="badge {{ ($item->jenis_akun == 'debit') ? 'badge-warning' : 'badge-danger'}}">
                                    {{ $item->jenis_akun }}
                                </span>
                            </td>
                            <td class="font-weight-bold">Rp. {{ number_format($item->saldo) }}</td>
                            <td>
                                @if (!in_array($item->nama, $jenisPembayaran))
                                    <a href="{{ route('akun.edit', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                @endif
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUpdateSaldo-{{ $item->id }}">
                                    Update Saldo
                                </button>
                                @include('akun.modal-update-saldo')
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mt-2">
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
                        <label class="form-label">Jenis Akun</label>
                        <select class="form-control" name="jenis_akun" aria-label="Default select example">
                            <option selected value=""> --- Jenis Akun -- </option>
                            <option value="debit">Debit</option>
                            <option value="kredit">Kredit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Saldo</label>
                        <input type="number" name="saldo" class="form-control">
                    </div>
                
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection