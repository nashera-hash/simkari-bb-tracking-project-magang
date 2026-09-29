@extends('layouts.app')

@section('title', 'Tambah Rak')

@section('tabs')
    <a href="{{ route('rak.index') }}">Data Rak</a>
    <a href="{{ route('rak.create') }}" class="active">Tambah Rak</a>
@endsection

@section('content')
    <h1>Tambah Rak</h1>

    <div class="card-box" style="max-width:640px">
        <form method="POST" action="{{ route('rak.store') }}">
            @csrf
            @include('rak._form')
        </form>
    </div>
@endsection