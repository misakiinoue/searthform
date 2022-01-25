
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title></title>
</head>

<body>
<?php

// 出力時に必須の関数
// (HTML用 エスケープ関数)
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// DBに接続


// ドライバ呼び出しを使用して MySQL データベースに接続します
$dsn = 'mysql:dbname=misaki;host=localhost;charset=utf8mb4';
$username='misaki';
$password='misaki';
$options = [
    \PDO::ATTR_EMULATE_PREPARES => false, // エミュレート無効
    \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, // 複文無効
    ];
try {
    $dbh = new PDO($dsn, $username, $password, $options);
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
var_dump($dbh);
// 素敵な処理



// DBから情報を一式読み出す
// ------------------------------

// 「準備された文(prepared statement)」を用意する
$sql = 'SELECT * FROM contents WHERE sbmit_name=\'game\';';
$sql = "SELECT * FROM contents WHERE sbmit_name='game';";
$sql = "SELECT * FROM contents ;";
$sql = "SELECT * FROM contents WHERE sbmit_name='Soshage' ORDER BY content_id ASC;";
$pre = $dbh->prepare($sql);

// プレースホルダーに値をバインドする
// XXX このプログラムでは特にバインドする値はないので省略

// SQLを実行する
$res = $pre->execute();

// 情報を取得し、テーブルとして出力する
echo "<table border='1'>\n";
//
while($row = $pre->fetch(PDO::FETCH_ASSOC)) {
  //
  echo "  <tr>\n";
  foreach($row as $key => $val) {
    echo "    <td>", h($val), "</td>\n";
  }
  echo "  </tr>\n\n";
}
echo "</table>\n";

