<x-layout>
    <h1>Create Article</h1>

    <!-- Display validation errors if any -->
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

    <!-- Form to create article -->
    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Article Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>

        <label for="category_id">Category:</label>
        <select name="category_id" id="category_id" required>
            <option value="">Select a Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="content">Article Content:</label>
        <textarea id="content" name="content" required>{{ old('content') }}</textarea>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Submit</button>
    </form>
</x-layout>
