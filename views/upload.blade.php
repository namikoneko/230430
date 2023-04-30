@extends("layout")

@section("content")

<div class="mt-2">
    <a class="text-decoration-none py-1 px-2 border rounded text-center bg-light" href='./files'>ファイル一覧</a>
</div>

    <form class="ins-form mt-2" action="uploadExe" method="post" enctype="multipart/form-data">

        <input type="file" class="form-control" name='image' id="image">

        <input class="btn btn-light mt-2" type='submit' value='登録'>

    </form>

@endsection
