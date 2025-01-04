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
    <h1 class="page-title">Articles</h1>

    @if($articles->count())
        @foreach($articles as $article)
            <section class="articles">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 200px;">
                <h2>{{ $article->title }}</h2>
                <p>{{ $article->category->name ?? 'No category' }}</p>
                <p>Published By: {{ $article->published_by }}</p>
                <a href="{{ route('articles.show', $article->id) }}" class="details">Read More</a>
            </section>
        @endforeach
    @else
        <p>No articles found.</p>
    @endif
</x-layout>
