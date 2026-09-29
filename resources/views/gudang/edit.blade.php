@extends('layouts.app')

@section('title', 'Ubah Gudang')

@section('tabs')
    <a href="{{ route('gudang.index') }}">Data Gudang</a>
    <a href="{{ route('gudang.edit', $gudang) }}" class="active">Ubah Gudang</a>
@endsection

@section('content')
    <h1>Ubah Gudang</h1>

    <div class="card-box" style="max-width:640px">
        <form method="POST" action="{{ route('gudang.update', $gudang) }}">
            @csrf
            @method('PUT')
            @include('gudang._form')
        </form>
    </div>
@endsection