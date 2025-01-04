<x-layout>
    <h1>Admin - Manage Articles</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <section class="admin-section">
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->visible ? 'Visible' : 'Hidden' }}</td>
                    <td>
                        <section class="admin-actions">
                            <!-- Toggle Visibility Form -->
                            <form action="{{ route('articles.toggleVisibility', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">
                                    {{ $article->visible ? 'Hide' : 'Show' }}
                                </button>
                            </form>

                            <!-- Edit Article Button -->
                            <a href="{{ route('articles.edit', $article->id) }}" style="display:inline; margin-left: 10px;">
                                <button>Edit</button>
                            </a>

                            <!-- Delete Article Form -->
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') <!-- Specify the DELETE method -->
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this article?');">Delete</button>
                            </form>
                        </section>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</x-layout>
