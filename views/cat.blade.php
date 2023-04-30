@extends("layout")

@section("content")

<!-- ins -->
    <form class="ins-form mt-2" action="catInsExe" method="post">

<div class="row">

    <div class="col-3">
            <label for="title" class="form-label">title</label>
            <input type="text" class="form-control" name='title' id="title">
    </div>

    <div class="col-3">
            <label for="sort" class="form-label">sort</label>
            <input type="text" class="form-control" name='sort' id="sort">
    </div>
</div>

    <div class="col-2 d-flex">
            <input class="btn btn-light mt-2 align-self-bottom" type='submit' value='insert'>
    </div>


    </form>

    <div class="row mt-2 border-bottom bg-light rounded">

        <div class="col-1">
            <span class="">id</span>
        </div>

        <div class="col-4">
            <span class="">title</span>
        </div>

        <div class="col-2">
            <span class="">sort</span>
        </div>

        <div class="col-2">
            <span class="">update</span>
        </div>

    </div><!--row-->


  @foreach($rows as $row)

    <div class="row mt-2 border-bottom bg-light rounded">

        <div class="col-1">
            <span class="">{{$row["id"]}}</span>
        </div>

        <div class="col-4">
            <span class=""><a class="text-decoration-none" href="/230326/{{$row['id']}}/datas">{{$row["title"]}}</a></span>
        </div>

        <div class="col-2">
            <span class="">{{$row["sort"]}}</span>
        </div>

        <div class="col-2">
            <a class="d-inline text-decoration-none py-1" href='catUpd?id={{$row["id"]}}'>update</a>
        </div>

    </div><!--row-->

  @endforeach

@endsection
