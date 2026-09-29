@extends('layouts.app')

@section('title', 'Tambah Perkara')

@section('tabs')
    <a href="{{ route('perkara.index') }}">Data Perkara</a>
    <a href="{{ route('perkara.create') }}" class="active">Tambah Perkara</a>
@endsection

@section('content')
    <h1>Tambah Perkara</h1>

    <div class="card-box" style="max-width:720px">
        <form method="POST" action="{{ route('perkara.store') }}">
            @csrf
            @include('perkara._form')
        </form>
    </div>
@endsection