<x-layout>
    <h1>Admin - Manage Articles</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Visible</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->visible ? 'Visible' : 'Hidden' }}</td> <!-- Show visible status -->
                <td>
                    <form action="{{ route('articles.toggleVisibility', $article->id) }}" method="POST">
                        @csrf
                        <button type="submit">
                            {{ $article->visible ? 'Hide' : 'Show' }} <!-- Toggle button label -->
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>
