<h1 align="center">Мастера парикмахерской</h1>

<?php
    $pdo = new PDO('sqlite:../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');

    $query = "SELECT id, name, surname, specialization FROM emploee where status = 'works' ORDER BY surname";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $statement->closeCursor();

?>

<table width="100%">
    <tr> 
        <td>Номер</td>
        <td>Имя</td>
        <td>Фамилия</td>
        <td>Специализация</td>
        <td>Редактирование</td>
        <td>Удаление</td>
        <td>График</td>
        <td>Выполненные работы</td>
    </tr>
    <?php 
        foreach ($rows as $row) {?>
            <tr>
                <td> <?= $row['id'] ?> </td>
                <td> <?= $row['name'] ?> </td>
                <td> <?= $row['surname'] ?> </td>
                <td> <?= $row['specialization'] ?> </td>
                <td>
                    <a href="edit_emploee/edit_emploee.php?emploee_id=<?= $row['id'] ?>">Редактировать</a>
                </td>
                <td>
                    <a href="delete_emploee/delete_emploee.php?emploee_id=<?= $row['id'] ?>">Удалить</a>
                </td>
                <td>
                    <a href="schedule/schedule.php?emploee_id=<?= $row['id'] ?>">График работы</a>
                </td>
                <td>
                    <a href="provided_services/provided_services.php?emploee_id=<?= $row['id'] ?>">Выполненные работы</a>
                </td>
            </tr>
    <?php } ?> 
   
</table>


<form method="post" enctype="application/x-www-form-urlencoded" action="add_emploee/add_emploee.php">
    <center>
    <button style="font-size: 17px">Добавить работника</button>
    </center>
</form>