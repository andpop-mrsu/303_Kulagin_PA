<?php
$pdo = new PDO('sqlite:salon.db');

$query = "SELECT id, surname FROM emploee ORDER BY id";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
?>
<div>
    Выберите Мастера

</div>
<form action="" method="POST">
<label>
    <select name="id">
        <option value = 0>
            Все
        </option>
        <?php foreach ($rows as $row) { ?>
            <option value= <?= $row['id']?>>
                <?=$row['id'] . '  ' . $row['surname'] ?>
            </option>
        <?php } 
    $statement->closeCursor(); ?>
    </select>
        </label>
    <button type="submit">Поиск по номеру</button>
</form>

<?php
    $emploee_num = 0;
    if(isset($_POST['id']) )
    {
        $emploee_num = (int) $_POST['id'] ;
    }
    if (0 == $emploee_num){
        $query = "SELECT emploee.id, emploee.name, emploee.surname, work.date, work.time, services.service_name, services.price FROM emploee INNER JOIN work ON emploee.id = work.emploee_id INNER JOIN appointment ON work.id = appointment.work_id INNER JOIN services ON appointment.service_id = services.id where work.done = 'yes' ORDER BY emploee.surname, work.date, work.time";
    }
    else {
        $query = "SELECT emploee.id, emploee.name, emploee.surname, work.date, work.time, services.service_name, services.price FROM emploee INNER JOIN work ON emploee.id = work.emploee_id INNER JOIN appointment ON work.id = appointment.work_id INNER JOIN services ON appointment.service_id = services.id WHERE emploee.id = {$emploee_num} and work.done = 'yes' ORDER BY emploee.surname, work.date, work.time";
    }
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $statement->closeCursor();

?>

<table width="100%">
    <tr> 
        <td>Номер</td>
        <td>Имя</td>
        <td>Фамилия</td>
        <td>Дата</td>
        <td>Время</td>
        <td>Услуга</td>
        <td>Цена</td>
    </tr>
    <?php 
        foreach ($rows as $row) {?>
            <tr>
                <td> <?= $row['id'] ?> </td>
                <td> <?= $row['name'] ?> </td>
                <td> <?= $row['surname'] ?> </td>
                <td> <?= $row['date'] ?> </td>
                <td> <?= $row['time'] ?> </td>
                <td> <?= $row['service_name'] ?> </td>
                <td> <?= $row['price'] ?> </td>
            </tr>
    <?php } ?> 
   
</table>



