@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('tabs')
    <a href="{{ route('gudang.index') }}">Data Gudang</a>
    <a href="{{ route('gudang.create') }}" class="active">Tambah Gudang</a>
@endsection

@section('content')
    <h1>Tambah Gudang</h1>

    <div class="card-box" style="max-width:640px">
        <form method="POST" action="{{ route('gudang.store') }}">
            @csrf
            @include('gudang._form')
        </form>
    </div>
@endsection