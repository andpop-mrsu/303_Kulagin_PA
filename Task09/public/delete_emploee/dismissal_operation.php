<?php
$pdo = new PDO('sqlite:../../data/salon.db');
//$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');

$emploee_id = $_POST['emploee_id'];

$query = "UPDATE emploee SET status = 'fired' WHERE emploee.id = $emploee_id;";
$statement = $pdo->prepare($query);
$statement->execute();

?>

<h1 align="center">Данные о рабочем удалены</h1>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Главный экран</button>
    </center>
</form>