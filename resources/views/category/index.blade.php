<x-layout>
    @foreach($categories as $category)
        <li>Category:</li> {{$category->name}}
    @endforeach

</x-layout>
