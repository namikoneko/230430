@extends("layout")

@section("content")

    <form class="ins-form" action='./catUpdExe' method='post'>

        <input type='hidden' name='id' value="{{$row['id']}}">

        <label for="ins-title">名前</label>
        <input type="title" class="inputText form-control" name="title" id="ins-title" value="{{$row['title']}}">

        <label for="ins-sort">sort</label>
        <input type="sort" class="inputText form-control" name="sort" id="ins-sort" value="{{$row['sort']}}">

        <input class="btn btn-light mt-2" type='submit' value='送信'>

    </form>

<div class="mt-4 mb-2 d-flex justify-content-end">
        <a class="d-inline text-decoration-none px-2 py-1" href='catDel?id={{$row["id"]}}'>delete</a>
</div>


@endsection
