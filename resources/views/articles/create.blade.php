<x-layout>
    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <label for="title">Article Title:</label>
        <input type="text" id="title" name="title">

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id">
            <option value="">Select a Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="content">Article Content:</label>
        <textarea id="content" name="content"></textarea>

        <label for="published_by">Published By:</label>
        <input type="text" id="published_by" name="published_by">

        <button type="submit">Submit</button>
    </form>
</x-layout>
