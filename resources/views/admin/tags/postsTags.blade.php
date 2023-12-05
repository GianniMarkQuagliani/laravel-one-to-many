@php
    use App\Functions\Helper;
@endphp

@extends('layouts.admin')

@section('content')

<h1>Elenco post del tag {{ $tag->name }}</h1>

<table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nome post</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tag->posts as $post)
      <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>
            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i>Visualizza</a>
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Modifica</a>
            @include('admin.partials.form', [
                'route' => route('admin.posts.destroy', $post),
                'message' => 'Sei sicuro di voler eliminare?'
            ])
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
