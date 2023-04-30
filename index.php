<?php
ini_set('display_errors', 1);
ini_set('date.timezone', 'Asia/Tokyo');

require_once '../libs/flight/Flight.php';
require_once '../libs/Parsedown.php';

require_once ("../libs/blade/BladeOne.php");
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG);
Flight::set('blade', $blade);

Flight::route('/cat', function(){//##################################################

    $db = new PDO('sqlite:./data.db');

    //$sql = "select * from cat";

    $sql = "select * from cat order by sort desc, id desc";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $rows = makeRows($stmt);

    $blade = Flight::get('blade');
    echo $blade->run("cat",array("rows"=>$rows)); //
});

Flight::route('/catInsExe', function(){//################################################## dataIns

    $title = Flight::request()->data->title;
    $sort = Flight::request()->data->sort;
    if($sort == null){

        $sort = 0;
    }


    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into cat (title,sort) values (?,?)");
    $array = array($title,$sort);

    $stmt->execute($array);

    Flight::redirect('/cat');
});

Flight::route('/catUpd', function(){//################################################## catUpd

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

  //$baseUrl = Flight::get('baseUrl');//

  $blade = Flight::get('blade');//
  echo $blade->run("catUpd",array("row"=>$row));//
});

Flight::route('/catUpdExe', function(){//################################################## catUpdExe

    $id = Flight::request()->data->id;

    $title = Flight::request()->data->title;//
    $sort = Flight::request()->data->sort;//

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update cat set title  = ?,sort = ? where id = ?");
    $array = array($title, $sort, $id);
    $stmt->execute($array);

    Flight::redirect('/cat');
});

Flight::route('/catDel', function(){//################################################## dataDel

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("delete from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    Flight::redirect('/cat');
/*

*/
});

Flight::route('/@id/datas', function($id){//##################################################

    $page = Flight::request()->query->page;

    if(!isset($page)){
        $page = 1;
    }

    //$page = 2;
    $records = 50;
    $offset = ($page - 1) * $records;

    $db = new PDO('sqlite:./data.db');

    //$sql = "select * from cat";

    $sql = "select * from data where catId = ? order by updated desc limit ? offset ?";
    //$sql = "select * from data where catId = ? order by updated desc";

    $stmt = $db->prepare($sql);
    $stmt->execute(array($id, $records, $offset));
    //$stmt->execute(array($id));


    $rows = makeRows($stmt);
    $rows = markdownParse($rows);
    //$rowNum = count($rows);

    $sql = "select * from find order by updated desc limit 30";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsFind = makeRows($stmt);

    $blade = Flight::get('blade');
    echo $blade->run("datas",array("rows"=>$rows,"id"=>$id,"page"=>$page,"rowsFind"=>$rowsFind)); //
});

Flight::route('/@id/dataInsExe', function($id){//################################################## dataIns

    //$id = Flight::request()->data->id;

    $title = Flight::request()->data->title;
    $text = Flight::request()->data->text;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into data (title,text,catId,updated) values (?,?,?,?)");
    $array = array($title,$text,$id,time());

    $stmt->execute($array);

    Flight::redirect('/' . $id . '/datas');

});

Flight::route('/@id/dataUpd', function($catId){//################################################## catUpd

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("select * from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

    $blade = Flight::get('blade');
    echo $blade->run("dataUpd",array("row"=>$row));//
});

Flight::route('/@id/dataUpdExe', function($catId){//################################################## dataUpdExe

    $id = Flight::request()->data->id;
    $title = Flight::request()->data->title;//
    $text = Flight::request()->data->text;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set title = ?, text = ? where id = ?");
    $array = array($title, $text, $id);
    $stmt->execute($array);

    Flight::redirect('/' . $catId . '/datas');

});

Flight::route('/@id/dataUp', function($catId){//################################################## dataUpdExe

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set updated = ? where id = ?");
    $array = array(time(), $id);
    $stmt->execute($array);

    Flight::redirect('/' . $catId . '/datas');

});

Flight::route('/@id/dataDel', function($catId){//################################################## dataDel

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("delete from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

    Flight::redirect('/' . $catId . '/datas');
});

Flight::route('/@id/find', function($id){//################################################## dataDel

    $word = Flight::request()->query->word;

    $page = Flight::request()->query->page;

    if(!isset($page)){
        $page = 1;
    }

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select * from data where catId = ? and title like ?");
    $array = array($id, "%{$word}%");
    //$array = array($id, "%" . $word . "%");


    $stmt->execute($array);

    $rows = makeRows($stmt);
    $rows = markdownParse($rows);

//findに登録
  //findテーブルになければ登録する
    $sql = "select count(*) from find where title like ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($word));
    $rowsCount = makeRows($stmt);

    if($rowsCount[0][0] == 0){
        $sql = "insert into find (title,updated) values (?,?)";
        $stmt = $db->prepare($sql);
        $array = array($word,time());
        $stmt->execute($array);
    }else{
        $sql = "update find set updated = ? where title like ?";
        $stmt = $db->prepare($sql);
        $array = array(time(),$word);
        $stmt->execute($array);
    }

//print_r($rowsCount);
//print($rowsCount[0][0]);


//datasと同じ
    $sql = "select * from find order by updated desc limit 30";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rowsFind = makeRows($stmt);
//datasと同じ

    $blade = Flight::get('blade');
    echo $blade->run("datas",array("rows"=>$rows,"id"=>$id,"page"=>$page,"rowsFind"=>$rowsFind)); //

/*
*/


});

//findDel?id=
Flight::route('/@id/findDel', function($id){//################################################## dataDel

    $findId = Flight::request()->query->id;
    $catId = $id;

//echo $findId;

    $db = new PDO('sqlite:data.db');

        $sql = "delete from find where id = ?";

        $stmt = $db->prepare($sql);

        $array = array($findId);
        $stmt->execute($array);

    Flight::redirect('/' . $catId . '/datas');
/*

*/
});


/*
ここから使わない

Flight::route('/upload', function(){//################################################## dataDel

    $blade = Flight::get('blade');
    echo $blade->run("upload"); //

});

Flight::route('/uploadExe', function(){//################################################## dataDel

$msg = null;

//echo isset($_FILES["image"]);

if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){

//echo "uploadeExe  in if";

    $old_name = $_FILES["image"]["tmp_name"];
    $new_name = date("ymd") . "_";
    $new_name .= $_FILES["image"]["name"];

    if(move_uploaded_file($old_name, "img/" . $new_name)){
        $msg = "uploaded!";
    }else{
        $msg = "not uploaded!"; 
    }
}

    Flight::redirect('/upload');

//echo $msg;

});

Flight::route('/files', function(){//################################################## dataDel

    //echo "test!";

    $files = glob('./img/*.*');
    rsort($files);

    //$files = glob('/Users/sanpeitakashi/Library/WebServer/Documents/*');

    //print_r($files);

    //foreach ($files as $file) {
	    //echo $file . '<br>';
    //}

    $blade = Flight::get('blade');
    echo $blade->run("files",array("files"=>$files));//

});
*/

function makeRows($stmt){
    $i = 0;
    $rows = [];
    while($row = $stmt->fetch()){
        $row["i"] = $i;
        $rows[$i] = $row;
        $i++;
    }
    return $rows;
}

function markdownParse($rows){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $i = 0;
   foreach($rows as $row){
     $rows[$i]["text"] = $parse->text($row["text"]);
     $text = $rows[$i]["text"];

     $copyStr = "/{copy}/";
     $text = preg_replace($copyStr,"</p><p><button type='button' class='btn btn-primary' onclick='myEvent(this);'>copy</button>",$text);
     $text = preg_replace("/<a href=/","<a target='_blank' href=",$text);
     $rows[$i]["text"] = $text;

     $rows[$i]["rawText"] = $row["text"];//元のテキスト
     $i++;
   }
  return $rows;
}

function markdownParseOne($row){
  $parse = new Parsedown();
  $parse->setBreaksEnabled(true);
  $parse->setMarkupEscaped(false);
  $row["text"] = $parse->text($row["text"]);
  $row["rawText"] = $row["text"];//元のテキスト
  return $row;
}

Flight::start();
