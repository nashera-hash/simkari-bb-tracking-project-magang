@extends('layouts.app')

@section('title', 'Ubah Perkara')

@section('tabs')
    <a href="{{ route('perkara.index') }}">Data Perkara</a>
    <a href="{{ route('perkara.edit', $perkara) }}" class="active">Ubah Perkara</a>
@endsection

@section('content')
    <h1>Ubah Perkara</h1>

    <div class="card-box" style="max-width:720px">
        <form method="POST" action="{{ route('perkara.update', $perkara) }}">
            @csrf
            @method('PUT')
            @include('perkara._form')
        </form>
    </div>
@endsection