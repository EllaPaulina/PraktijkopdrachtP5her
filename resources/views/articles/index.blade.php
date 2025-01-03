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
                <!-- Comments Section -->
                <div>
                    <h4>Comments:</h4>
                    @if($article->comments->count())
                        @foreach($article->comments as $comment)
                            <div>
                                <p>
                                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}
                                    @if(auth()->check() && auth()->user()->is_admin)
                                        <!-- Delete Button for Admin -->
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                                @endif
                                </p>
                                <small>Posted on {{ $comment->created_at->format('M d, Y') }}</small>
                            </div>
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
                </div>
        @endforeach
    @else
        <p>No articles found.</p>
    @endif

</x-layout>
