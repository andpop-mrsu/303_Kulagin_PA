<h1 align="center">Добавить работника</h1>

<?php
    $pdo = new PDO('sqlite:../../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');
?>

<center>
    <body>
        <form action="" method="post" enctype="application/x-www-form-urlencoded" action="add_emploee.php">
            <p><label>Имя: <input name="name"></label></p>
            <p><label>Фамилия: <input name="surname"></label></p>
            <p><label>Процентная ставка: <input name="percent"></label></p>
            <fieldset>
                <h3><label> Специализация</label></h3>
                <p><label> <input type=radio name=specialization value="male"> мужчины </label></p>
                <p><label> <input type=radio name=specialization value="female"> женщины </label></p>
                <p><label> <input type=radio name=specialization value="universal"> универсал </label></p>
            </fieldset>
            <p><button type="submit" style="font-size: 17px">Добавить работника</button></p>
        </form>
    </body>
</center>

<?php
if(isset($_POST['name'], $_POST['surname'], $_POST['percent'], $_POST['specialization']))
{
    $insert = $pdo->prepare("INSERT INTO 'emploee' ('name', 'surname', 'specialization', 'percent' ) VALUES (:name, :surname, :specialization, :percent)");
    $insert->bindValue(':name', $_POST['name']);
    $insert->bindValue(':surname', $_POST['surname']);
    $insert->bindValue(':percent', (int) $_POST['percent']);
    $insert->bindValue(':specialization', $_POST['specialization']);
    $insert->execute();
}
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Главная страница</button>
    </center>
</form>