<x-layout>

    <form action="{{ route('articles.search') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="Search articles...">
        <select name="category_id">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit">Search</button>
    </form>
    <h2>Articles</h2>
    @if($articles->count())
        @foreach($articles as $article)
            <div>
                <h3>ID:</h3> {{ $article->id }}
                <h1>Title:</h1> {{ $article->title }}
                <p>Content:</p> {{ $article->content }}
                <p>Category:</p> {{ $article->category->name ?? 'No category' }}</p>
                <p>Published By:</p> {{ $article->published_by }}</p>
            </div>
        @endforeach
    @else
        <p>No articles found.</p>
    @endif
</x-layout>
