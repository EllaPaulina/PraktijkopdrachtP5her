<!-- resources/views/articles/edit.blade.php -->

<x-layout>
    <h1>Edit Article</h1>

    @if ($errors->any())
        <section class="errors">
            <h3>Whoops!</h3> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Specify the PUT method for updates -->

        <section class="article-title">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required>
        </section>

        <section class="article-content">
            <label for="content">Content:</label>
            <textarea id="content" name="content" required>{{ old('content', $article->content) }}</textarea>
        </section>
        <section class="article-image">
        <label for="image">Upload Image</label>
        <input type="file" name="image" enctype="multipart/form-data">
        </section>

        <section class="article-visibility">
            <label for="visible">Visible:</label>
            <input type="checkbox" id="visible" name="visible" value="1" {{ $article->visible ? 'checked' : '' }}>
        </section>

        <button type="submit">Update Article</button>
    </form>

    <a href="{{ route('articles.index') }}">Back to Articles</a>
</x-layout>
