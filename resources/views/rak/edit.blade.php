@extends('layouts.app')

@section('title', 'Ubah Rak')

@section('tabs')
    <a href="{{ route('rak.index') }}">Data Rak</a>
    <a href="{{ route('rak.edit', $rak) }}" class="active">Ubah Rak</a>
@endsection

@section('content')
    <h1>Ubah Rak</h1>

    <div class="card-box" style="max-width:640px">
        <form method="POST" action="{{ route('rak.update', $rak) }}">
            @csrf
            @method('PUT')
            @include('rak._form')
        </form>
    </div>
@endsection