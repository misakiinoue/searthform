<?php

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }

// ドライバ呼び出しを使用して MySQL データベースに接続します
$dsn = 'mysql:dbname=misaki;host=localhost;charset=utf8mb4';
$username='misaki';
$password='misaki';
$options = [
    \PDO::ATTR_EMULATE_PREPARES => false, // エミュレート無効
    \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, // 複文無効
    ];
$pdo = new PDO($dsn, $username, $password,$options);
try {
    $dbh = new PDO($dsn, $username, $password, $options);
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}

//
$sbmit_name = $_GET['sbmit_name'] ?? '';
var_dump($sbmit_name);
//
$sbmit_genre = $_GET['sbmit_genre'] ?? '';

// 素敵な処理
$sql = "SELECT * FROM contents WHERE sbmit_name=:sbmit_name AND sbmit_genre LIKE :sbmit_genre ORDER BY releasedate  ASC;";
$pre = $dbh->prepare($sql);

// プレースホルダーに値をバインドする
$pre->bindValue(":sbmit_name",$sbmit_name,PDO::PARAM_STR);
$pre->bindValue(":sbmit_genre", "%{$sbmit_genre}%", PDO::PARAM_STR);
// XXX このプログラムでは特にバインドする値はないので省略

// SQLを実行する
$res = $pre->execute();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <title>Document</title>
</head>
<body>
    <h1>2021年以降のお勧めゲーム</h1>
    <form action="index.php" method="get">
    <input type="radio" name="sbmit_name" value="game"<?php if('game' ===$sbmit_name){echo 'checked';} ?> >game
    <input type="radio" name="sbmit_name" value="Soshage"<?php if('Soshage' ===$sbmit_name){echo 'checked';} ?> >Soshage
    <input type="text"  name="sbmit_genre">
    <br>
    <button>検索</button>
</form>
    <table class="table table-striped table-hover">
    <?php
//$row = $pre->fetch(PDO::FETCH_ASSOC);
//var_dump($row);
// 情報を取得し、テーブルとして出力する

//echo $row["content_id"]."\n";
//echo $row["sbmit_name"]."\n";

 //
while($row = $pre->fetch(PDO::FETCH_ASSOC)) {
  //""
  echo "  <tr>\n";
  echo "<td>" , h($row["content_id"]);
  echo "<td>" , h($row["sbmit_name"]);
  echo "<td>" , '<a href="' , h($row['sbmit_url']) , '">' , h($row["sbmit_contents"]) , "</a>";
  echo "<td>" , h($row["sbmit_genre"]);
  echo "<td>" , h($row["releasedate"]);
  echo "<td>" , h($row["hard"]);   


  echo "  </tr>\n\n";
}
    //""
    
?>
</table>
<h1>入力フォーム</h1>
<form action="write.php" method="POST">
種類
<input type="radio" name="sbmit_name" value="game"<?php if('game' ===$sbmit_name){echo 'checked';} ?> >game
    <input type="radio" name="sbmit_name" value="Soshage"<?php if('Soshage' ===$sbmit_name){echo 'checked';} ?> >Soshage
    <br>
タイトル名<input type = "text" name ="sbmit_contents"><br/>
ジャンル<input type="text" name="sbmit_genre"><br>
発売日<input type="date" name="releasedate"><br>
URL<input type="VARBINARY" name="sbmit_url"><br>
ハード<input type="hard" name="hard">
<button type="submit">送信</button>
</form>
</body>
</html>
