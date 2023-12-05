@php
    use App\Functions\Helper;
@endphp

@extends('layouts.admin')

@section('content')
    <h1>{{ $post->title }}<a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Modifica</a>
    </h1>
    <p>Categoria: <strong>{{ $post->category?->name ?? '-' }}</strong></p>

    @forelse ($post->tags as $tag)
        <span class="badge text-bg-info">{{ $tag->name }}</span>
    @empty
        <span class="badge text-bg-warning">Non sono presenti tag</span>
    @endforelse

    <div class="w-50">
        <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
        <p>{{ $post->image_original_name }}</p>
    </div>
    <p>Data di creazione: {{ Helper::formatDate($post->date) }}</p>
    <p>Tempo di lettura previsti: {{ $post->reading_time }} min</p>
    <p>{!! $post->text !!}</p>

@endsection
