<h1 align="center">Расписание работника</h1>

<?php
    $pdo = new PDO('sqlite:../../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');

    $emploee_id = $_GET['emploee_id'];
    $query = "SELECT date, begin_time, end_time FROM schedule WHERE emploee_id ='$emploee_id'";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $statement->closeCursor();

?>
<center>
    <table width="50%">
        <tr> 
            <td>Дата</td>
            <td>Начало рабочего дня</td>
            <td>Конец рабочего дня</td>
            <td>Сохранение</td>
            <td>Удаление</td>
        </tr>
        <?php 
            for ($i = 0; $i < count($rows); $i++) {?>
                <form method="post" enctype="application/x-www-form-urlencoded" action="schedule.php?emploee_id=<?=$emploee_id?>">
                    <tr>
                        <td> 
                            <input type=date name="date" value=<?= $rows[$i]['date'] ?>>
                        </td>
                        <td> 
                            <input type=time step=1 name="begin_time" value=<?= $rows[$i]['begin_time'] ?>>
                        </td>
                        <td> 
                            <input type=time step=1 name="end_time" value=<?= $rows[$i]['end_time'] ?>>
                        </td>
                        <td>
                            <button name="save" type="submit" value="save" style="font-size: 17px">Сохранить</button>
                        </td>
                        <td>
                            <button name="delete" type="submit" value="delete" style="font-size: 17px">Удалить</button>
                            <input type="hidden" name="index" value = <?=$i?>>
                        </td>
                    </tr>
                </form>
        <?php } ?> 
    
    </table>
</center>

<?php
    if ($_POST) {
        if (isset($_POST['save'])) {
            save($pdo, $rows, $emploee_id, $_POST['index'], $_POST['date'], $_POST['begin_time'], $_POST['end_time']);
        } elseif (isset($_POST['delete'])) {
            delete($pdo, $rows, $emploee_id, $_POST['index']);
        }
    }

    function save($pdo, $rows, $emploee_id, $index, $date, $begin_time, $end_time)
    {
        $update = $pdo->prepare("UPDATE schedule SET date = :date, begin_time = :begin_time, end_time = :end_time WHERE emploee_id = :emploee_id AND date = :old_date");
        $update->bindValue(':emploee_id', $emploee_id);
        $update->bindValue(':date', $date);
        $update->bindValue(':begin_time', $begin_time);
        $update->bindValue(':end_time', $end_time);
        $update->bindValue(':old_date',$rows[$index]['date']);
        $update->execute();
    }

    function delete($pdo, $rows, $emploee_id, $index,)
    {
        $del = $pdo->prepare("DELETE FROM schedule WHERE emploee_id=:emploee_id AND date=:date");
        $del->bindValue(':emploee_id', $emploee_id);
        $del->bindValue(':date', $rows[$index]['date']);
        $del->execute();
    }
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="add_working_day.php?emploee_id=<?=$emploee_id?>">
    <center>
    <button style="font-size: 17px">Добавить рабочий день</button>
    </center>
</form>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Главная страница</button>
    </center>
</form>