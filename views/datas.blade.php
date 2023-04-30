@extends("layout")

@section("content")

<button type="button" class="btn btn-light mt-2" id="toggleDataFormBtn">開く</button>

<!-- ins
-->

<div id="toggleDataForm">

<div class="row">

    <form class="ins-form mt-2 col-6" action="dataInsExe" method="post">

               <div class="">
                    <label for="title" class="form-label">登録</label>
                </div>

               <div class="">
                    <input type="text" class="form-control" name='title' id="title">
                </div>

            <div class="">
                    <input class="btn btn-light mt-2" type='submit' value='登録'>
            </div>

    </form>

<!-- find -->
    <form class="ins-form mt-2 col-6" action="find" method="get">

            <div class="">
                <label for="word" class="form-label">検索</label>
            </div>

            <div class="">
                <input type="text" class="inputText form-control" name="word" id="word">
            </div>

            <div class="">
                <input class="btn btn-light mt-2" type='submit' value='検索'>
            </div>

    </form>

</div>

</div>

<div class="d-flex mt-2">

  @foreach($rowsFind as $row)

    <span class="border round px-2 bg-light">
        <a class="text-decoration-none" href="find?word={{$row['title']}}">{{$row['title']}} </a>
        <a class="text-decoration-none border text-center bg-light" href='findDel?id={{$row["id"]}}'>X</a>
    </span>

  @endforeach

</div>
  

  @foreach($rows as $row)

    <div class="row mt-2 border-bottom pb-2">

    <div class="col-3">

        <div class="data-title border rounded d-flex p-1 bg-light">
            <span class="">{{$row["title"]}}</span>
        </div>

        <div class="">
            <a class="text-decoration-none py-1 border rounded d-block text-center bg-light" href='dataUp?id={{$row["id"]}}'>up</a>
        </div>

        <div class="">
            <a class="text-decoration-none py-1 border rounded d-block text-center bg-light" href='dataUpd?id={{$row["id"]}}'>update</a>
        </div>

    </div>

        <div class='col-9 data-text bg-light'>
                    {!!$row["text"]!!}
        </div>

    </div><!--row-->

<!--

        <div class="data-title border rounded toggleBtn d-flex align-self-center py-1 bg-light">

        <div class="col-1">
            <button class="d-inline text-decoration-none py-1 toggleBtn">btn</button>
        </div>

-->

  @endforeach

    <a class="text-decoration-none py-1 me-3" href='datas?page={{$page - 1}}'>前のページ</a>

    <a class="text-decoration-none py-1" href='datas?page={{$page + 1}}'>次のページ</a>

  <script src="/230326/script.js"></script>


@endsection
