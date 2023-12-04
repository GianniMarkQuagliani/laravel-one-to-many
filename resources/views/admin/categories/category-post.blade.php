@extends('layouts.admin')

@section('content')

<h1>Elenco categorie e post</h1>

<table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Categoria</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
      <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td>
            <ul class="list-group">
                @foreach ($category->posts as $post)
                    <li class="list-group-item">
                        <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a>
                    </li>
                @endforeach
            </ul>
         </td>
      </tr>
        @endforeach
    </tbody>
  </table>

@endsection
