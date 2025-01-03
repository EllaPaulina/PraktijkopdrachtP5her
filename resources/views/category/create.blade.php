
<x-layout>

    <form action="{{ url(route('categories.store')) }}" method="POST">
        @csrf
        <label for="title">Category Name:</label>
        <input type="text" id="name" name="name">
        <button type="submit">Submit</button>
    </form>
</x-layout>
