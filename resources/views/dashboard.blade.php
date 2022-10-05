@extends('layouts.app')

@section('content')
    <div class="row d-flex justify-content-center align-items-center flex-column">
        <img src="https://is3.cloudhost.id/storage-feb/logo-feb.png?AWSAccessKeyId=F81RYXGH1N5R4MWUVBP9&Expires=1664934960&Signature=tkXQtLWxTRINqAdcLDng79yhUiQ%3D" class="img-fluid rounded" width="200px" alt="image-profile">
        <h5 class="font-weight-bold text-gray-900 mt-3">Welcome, {{ AuthUser::user()->name }}</h5>
        <p>Manage your info, privacy, and security to make Faculty work better for you.</p>
    </div>
@endsection