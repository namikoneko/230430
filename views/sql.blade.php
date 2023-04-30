@extends("layout")

@section("content")

    <form class="ins-form mt-3" action='./sqlExe' method='post'>

        <label for="ins-sql">作業</label>
        <textarea class="myTextarea form-control vh-50 mt-3" name='text' id="ins-sql">{{$row["text"]}}</textarea>

        <input class="btn btn-light mt-2" type='submit' value='send'>

    </form>


@endsection
