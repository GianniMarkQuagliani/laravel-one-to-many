@extends('layouts.admin')

@section('content')

    <h1>Elenco post</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Crea un nuovo post</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titolo</th>
                <th scope="col">Data</th>
                <th scope="col">Tempo di lettura</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tag</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->date }}</td>
                    <td>{{ $post->reading_time }}</td>
                    <td>{{ $post->category?->name ?? '-'}}</td>
                    <td>
                        @forelse ($post->tags as $tag)

                        <a class="badge text-bg-info text-white text-decoration-none " href="{{ route('admin.post-tag', $tag) }}">{{ $tag->name }}</a>

                        @empty
                            -
                        @endforelse
                    </td>
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
    {{ $posts->links() }}

@endsection
