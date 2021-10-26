<?php
// 直接アクセスされたらリダイレクト
if(!isset($_POST['word'])){
  header('Location:https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/');
  exit();
}

// $_POST['word']で入力値を取得 文字前後の空白除去&エスケープ処理
$word = trim(htmlspecialchars($_POST['word'],ENT_QUOTES));
// 文字列の中の「　」(全角空白)を「」(何もなし)に変換
$word = str_replace("　","",$word);
// 対象文字列が何もなかったらキーワード指定なしとする
if($word === ""){
  $word = "キーワード指定なし";
}
?>
// 〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜
<?php
try{
  // 例外が発生する可能性のあるコード
  // ここにこれからのコードを記述していく
}catch(PDOException $e){
  // 例外発生時の処理
  // 例外のメッセージを格納しておく
  $error = "接続エラー : {$e->getMessage()}";
} 
finally{ 
  // 例外の有無に関わらす実行されるコード 
  // データベース接続を終了するコードは例外の有無に関わらず実行する
  $dbh = NULL;
}
?>

<?php
// tryの中〜
  $sql = 'SELECT * FROM post_table WHERE title LIKE :word OR descri LIKE :word2' ;
  // SQL文をセット
  $stmt = $dbh->prepare($sql);
  // bindValueでプレイスホルダーに値(ワイルドカードで挟む)を入れ込む
  $stmt->bindValue(':word',"%{$word}%",PDO::PARAM_STR);
  $stmt->bindValue(':word2',"%{$word}%",PDO::PARAM_STR);
  // 実行処理
  $stmt->execute();
  // 記事があるかないかの指標用
  $judge = false;

  //〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜
      $judge = false;
    // ここから
    // trueの間繰り返す($result=記事の情報を1行ずつ取り出す)
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
      $judge = true;  // 記事がある時の
      $resultItem = $resultItem .'<li><a href="'.$result['file'].'"><div><p>'.$result['title'].'：'.$result['descri'].'</p></div></a></li>';
    }
    if($judge === false){  // 記事があったかないか
      $resultItem  = '<p>該当の記事がありませんでした</p>';
      // ない場合はメッセージを格納する
    }

    $resultList = '<h2><i class="fas fa-search"></i> キーワード：'.$word.'</h2><ul>'.$resultItem."</ul>";
    // ここまで
}catch(PDOException $e){
    
// 〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜〜
?>