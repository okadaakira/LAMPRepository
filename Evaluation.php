<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    header('Location:/Evaluation.php');
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=hyouka_com;charset=utf8mb4',
        'root',
        'password',
        array(PDO::ATTR_EMULATE_PREPARES => false)
    );
    $item_name = $_POST["textbox"];

    if($item_name && isset($_POST["btn"])) {
        unset($_POST["btn"]);
        $item_point = $_POST["number"];

        $stmt = $pdo -> prepare("INSERT INTO  evaluations(name, point) VALUES (:name, :point)");
        $stmt->bindParam(':name', $item_name, PDO::PARAM_STR);
        $stmt->bindValue(':point', $item_point, PDO::PARAM_INT);
        $stmt->execute();
    }

    $select_sql = "SELECT * FROM evaluations";
    $select_result = $pdo -> query($select_sql);
    foreach($select_result as $row) {
        $item_evaluations[] = [$row[1], $row[2]];
    }
} catch (PDOException $e) {
    exit('データベース接続失敗．'. $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charaset="UTF-8">
    <title>評価.com</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h1>評価.com</h1>
    </div>
    
    <form action="Evaluation.php" method="post">
    <div class="container">
        <div class="input">
            <input type="text" name="textbox">
            <select name="number">
                <option value="1">1点</option>
                <option value="2">2点</option>
                <option value="3">3点</option>
                <option value="4">4点</option>
                <option value="5">5点</option>
            </select>
        </div>
        <div class="send">
            <input type="submit" value="評価" name="btn">
        </div>  
        <div class="output">
            <?php foreach ($item_evaluations as $item_evaluation): ?>
                <p><?php echo $item_evaluation[0].':'. $item_evaluation[1]."点"; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
    </form>

    <div class="footer">
        <p>© 2019 okada</p>
    </div>
</body>
</html>
