<!-- resources/views/articles/edit.blade.php -->

<x-layout>
    <h1>Edit Article</h1>

    @if ($errors->any())
        <div>
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Specify the PUT method for updates -->

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div>
            <label for="visible">Visible:</label>
            <input type="checkbox" id="visible" name="visible" value="1" {{ $article->visible ? 'checked' : '' }}>
        </div>

        <button type="submit">Update Article</button>
    </form>

    <a href="{{ route('articles.index') }}">Back to Articles</a>
</x-layout>
