@extends("layout")

@section("content")

  @foreach($files as $file)

<ul class="mt-2 p-0">
    <li class="list-unstyled bg-light p-1 rounded">{{$file}}</li>
</ul>

  @endforeach


@endsection
