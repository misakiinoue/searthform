<?php
try{
    //DBに接続
    $dsn = 'mysql:dbname=misaki;host=localhost;charset=utf8mb4';
    $username='misaki';
    $password='misaki';
    $pdo = new PDO($dsn, $username, $password);

    //SQL文を実行して、結果を$stmtに代入する。
    $pre = $pdo->prepare(' SELECT * FROM contacts WHERE sbmit_name LIKE :name;');
    $pre->bindvalue('name','%" . $_POST["search_name"] . "%');

    $pre->execute();
    //実行する
    $pre ->execute();
    echo "OK";
    echo "<br>";
} catch(PDOException $e){
    echo "失敗;" . $e->getMessage() . "\n";
    exit();
}
var_dump($pre); exit;
?>
<html>
    <body>
        <table>
            <tr><th>ID</th><th>Name</th><th>remark</th></tr>
            <!--ここでPHPのforeachを使って結果を使って-->
            <?php foreach ($stmt as $row):?>
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                </tr>
                <?php endforeach; ?>
        </table>
    </body>
</html>