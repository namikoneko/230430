@extends("layout")

@section("content")

    <form class="ins-form" action='dataUpdExe' method='post'>

        <input type='hidden' name='id' value="{{$row['id']}}">

        <label for="ins-title">依頼者名</label>
        <input type="title" class="inputText form-control" name="title" id="ins-title" value="{{$row['title']}}">

        <label for="ins-text">内容</label>
        <textarea class="form-control vh-80 mt-0" name='text' id="ins-text">{{$row["text"]}}</textarea>

        <input class="btn btn-light mt-2" type='submit' value='send'>

    </form>

<div class="mt-4 mb-2 d-flex justify-content-end">
        <a class="d-inline text-decoration-none px-2 py-1" href='dataDel?id={{$row["id"]}}'>delete</a>
</div>


@endsection
