@extends('layouts.admin')

@section('content')

<h1>{{ $title }}</h1>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-8">
        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="mb-3">
                <label for="title" class="form-label">Titolo post *</label>
                <input id="title" class="form-control @error('title') is-invalid @enderror" name="title" type="text" value="{{ old('title', $post?->title) }}">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria</label>
                <option value="" >Selezionare una categoria</option>
                <select class="form-select" id="category_id" name="category_id">
                    @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @if ($category->id === old('category_id', $post?->category?->id)) selected @endif>{{ $category->name }}
                </option>
                @endforeach
                </select>
            </div>

            <div class="mb-3">
                <div class="btn-group" role="group" aria-label="Tags">

                    @foreach ($tags as $tag)
                    <input id="tag_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" type="checkbox" class="btn-check" autocomplete="off"

                    @if (($errors->any() && in_array($tag->id, old('tags', [])))
                    || ($post?->tags->contains('id', $tag->id)))
                    checked
                    @endif

                    >
                    <label class="btn btn-outline-primary" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                    @endforeach

                </div>
            </div>

            <div class="mb-3">
                <label for="reading_time" class="form-label">Tempo di lettura</label>
                <input id="reading_time" class="form-control @error('reading_time') is-invalid @enderror" name="reading_time" type="number" value="{{ old('reading_time', $post?->reading_time) }}">
                @error('reading_time')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input onchange="showImage(event)" id="image" class="form-control @error('image') is-invalid @enderror" name="image" type="file" value="{{ old('image', $post?->image) }}">
                @error('image')
                    <p class="text-danger">{{ $image }}</p>
                @enderror
                <img width="150" src="/img/placeholder.png" id="thumb" src="{{ asset('storage/' . $post?->image) }}">
            </div>
            <div class="form-floating mb-5">
                <textarea id="text" class="form-control" name="text" style="height: 200px">{{ old('text',$post?->text)  }}</textarea>
                @error('text')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <label for="text">Testo del post</label>
                @error('text')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Invia</button>
            <button type="reset" class="btn btn-secondary">Annulla</button>

        </form>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#text'))
        .catch(error => {
            console.error(error);
        });

    function showImage(event) {
        const image = document.getElementById('image');

        thumb.src = URL.createObjectURL(event.target.files[0]);
        thumb.onload = function() {
            URL.revokeObjectURL(thumb.src);
        }
    }
</script>
@endsection
