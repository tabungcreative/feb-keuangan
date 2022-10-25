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
                        <th>No</th>
                        <th>Kode Akun</th>
                        <th>Nama</th>
                        <th>Akun Kas</th>
                        <th>Aksi</th>
                    </tr>
                    @php($no=1)
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <i class="badge badge-secondary">{{ $item->akun_kas }}</i>
                            </td>
                            {{-- <td class="font-weight-bold">Rp. {{ number_format($item->saldo_awal) }}</td> --}}
                            <td class="d-flex">
                                <button type="button" class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#modalUpdate-{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                {{-- @include('akun.edit-modal')
                                @if ($item->akun_kas == 'kas_jalan')
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUpdateSaldo-{{ $item->id }}">
                                        update saldo
                                    </button>
                                    @include('akun.update-saldo-modal')
                                @endif --}}
                            </td>
                        </tr>
                    @php($no++)
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- {{ Auth::user() }} --}}
    <div class="col-md-5 mt-2">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Akun</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('akun.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Kode Akun</label>
                        <input type="text" name="kode" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Akun Kas</label>
                        <select class="form-control" name="akun_kas" aria-label="Default select example">
                            <option selected value=""> --- Pilih Akun Kas -- </option>
                            <option value="kas_masuk">Kas Masuk</option>
                            <option value="kas_keluar">Kas Keluar</option>
                            <option value="kas_jalan">Kas Jalan</option>
                            <option value="kas_bank">Kas Bank</option>
                            <option value="piutang">Piutang</option>
                            <option value="modal">Modal</option>
                            <option value="hutang">Hutang</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
