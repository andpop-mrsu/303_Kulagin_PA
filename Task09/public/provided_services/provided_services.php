<h1 align="center">Оказанные услуги</h1>

<?php
    $pdo = new PDO('sqlite:../../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');

    $emploee_id = $_GET['emploee_id'];
    $query = "SELECT work.date, work.time, services.service_name, services.price FROM emploee INNER JOIN work ON emploee.id = work.emploee_id INNER JOIN appointment ON work.id = appointment.work_id INNER JOIN services ON appointment.service_id = services.id WHERE emploee.id = {$emploee_id} and work.done = 'yes' ORDER BY work.date, work.time";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $statement->closeCursor();
?>

<center>
    <table width="30%">
        <tr> 
            <td>Услуга</td>
            <td>Дата</td>
            <td>Время</td>
            <td>Цена</td>
        </tr>
        <?php 
            foreach ($rows as $row) {?>
                <tr>
                    <td> <?= $row['service_name'] ?> </td>
                    <td> <?= $row['date'] ?> </td>
                    <td> <?= $row['time'] ?> </td>
                    <td> <?= $row['price'] ?> </td>
                </tr>
        <?php } ?> 
    </table>
</center>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Главная страница</button>
    </center>
</form>