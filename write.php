<?php

var_dump($_POST);

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

try {
    //インサート文
    $stmt = $pdo->prepare('INSERT INTO contents(sbmit_name , sbmit_contents, sbmit_genre, releasedate) 
    VALUES(:sbmit_name, :sbmit_contents, :sbmit_genre, :releasedate)');

    // 値をセット
    $stmt->bindValue(':sbmit_name', $_POST['sbmit_name']);
    $stmt->bindValue(':sbmit_contents', $_POST['sbmit_contents']);
    $stmt->bindValue(':sbmit_genre', $_POST['sbmit_genre']);
    $stmt->bindValue(':releasedate', $_POST['releasedate']);
    $stmt->bindValue(':hard', $_POST['hard']);


    // SQL実行
    $stmt->execute();

} catch (PDOException $e) {
// エラー発生
echo $e->getMessage();

} finally {
// DB接続を閉じる
$pdo = null;
}
?>
