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
    <h1 class ="page-title">Articles</h1>
    @if($articles->count())
        @foreach($articles as $article)
            <section class="articles">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 200px;">

                <h2>{{ $article->title }}</h2>
                <p>{{ $article->content }}</p>
                <p>{{ $article->category->name ?? 'No category' }}</p>
                <p>Published By:{{ $article->published_by }}</p>
                <!-- Comments Section -->
                <section class="comment-section">
                    <h4>Comments:</h4>
                    @if($article->comments->count())
                        @foreach($article->comments as $comment)
                            <section class="comment">
                                <p>
                                    <p>{{ $comment->user->name }}</p>: {{ $comment->body }}
                                    @if(auth()->check() && auth()->user()->is_admin)
                                        <!-- Delete Button for Admin -->
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                                @endif
                                </p>
                                <p>Posted on {{ $comment->created_at->format('M d, Y') }}</p>
                            </section>
                        @endforeach
                    @else
                        <p>No comments yet. Be the first to comment!</p>
                    @endif

                    <!-- Add Comment Form -->
                    @auth
                        <form action="{{ route('comments.store', $article->id) }}" method="POST">
                            @csrf
                            <textarea name="body" rows="3" placeholder="Add a comment..." required></textarea>
                            <button type="submit">Submit</button>
                        </form>
                    @else
                        <p><a href="{{ route('login') }}">Log in</a> to leave a comment.</p>
                    @endauth
                </section>
            </section>
        @endforeach
    @else
        <p>No articles found.</p>
    @endif

</x-layout>
