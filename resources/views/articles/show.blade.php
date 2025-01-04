<x-layout>
    <section class="article-details">
        <h1>{{ $article->title }}</h1>
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 400px;">
        <p>Category: {{ $article->category->name ?? 'No category' }}</p>
        <p>{{ $article->content }}</p>
        <p><strong>Published By:</strong> {{ $article->published_by }}</p>

        <!-- Comments Section -->
        <section class="comment-section">
            <h4>Comments:</h4>
            @if($article->comments->count())
                @foreach($article->comments as $comment)
                    <section class="comment">
                        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}</p>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <!-- Delete Button for Admin -->
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif
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
                <p><a href="{{ route('login') }}">Log in</a> or <a href="{{route('register')}}">Register</a> to leave a comment.</p>
            @endauth
        </section>
    </section>
</x-layout>
