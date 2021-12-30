<h1 align="center">Редактирование персональных данных мастера</h1>

<?php
    $pdo = new PDO('sqlite:../../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');

    $emploee_id = $_GET['emploee_id'];
    $query = "SELECT name, surname, specialization, percent FROM emploee WHERE emploee.id='$emploee_id'";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $emploee = $rows[0];
    $statement->closeCursor();

?>

<center>
    <body>
        <form action="" method="post" enctype="application/x-www-form-urlencoded" action="index.php">
            <table width="70%">
                <td><label>Имя: <input name="name" value=<?= $emploee['name'] ?>></label></td>
                <td><label>Фамилия: <input name="surname" value=<?= $emploee['surname'] ?>></label></td>
                <td><label>Специализация: <input name="specialization" value=<?= $emploee['specialization'] ?>></label></td>
                <td><label>Процентная ставка: <input name="percent" value=<?= $emploee['percent'] ?>></label></td>
                <td><button type="submit" style="font-size: 17px">Сохранить изменения </button></td>
            </table>
        </form>
    </body>
</center>


<?php
    if(isset($_POST['name'], $_POST['surname'], $_POST['percent'], $_POST['specialization']))
    {
        //$insert = $pdo->prepare("INSERT INTO 'emploee' ('name', 'surname', 'specialization', 'percent' ) VALUES (:name, :surname, :specialization, :percent)");
        $update = $pdo->prepare("UPDATE emploee SET name = :name, surname = :surname, specialization = :specialization, percent = :percent WHERE id = $emploee_id");
        $update->bindValue(':name', $_POST['name']);
        $update->bindValue(':surname', $_POST['surname']);
        $update->bindValue(':percent', (int) $_POST['percent']);
        $update->bindValue(':specialization', $_POST['specialization']);
        $update->execute();
    }
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Главная страница</button>
    </center>
</form>