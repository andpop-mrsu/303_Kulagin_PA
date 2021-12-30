<h1 align="center">Добавление рабочего дня</h1>

<?php
    $pdo = new PDO('sqlite:../../data/salon.db');
    //$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\Task_09\data\salon.db');
    $emploee_id = $_GET['emploee_id'];
?>

<center>
    <form method="post" enctype="application/x-www-form-urlencoded" action="add_working_day.php?emploee_id=<?=$emploee_id?>">
        <table width="50%">
            <tr> 
                <td>Дата</td>
                <td>Начало рабочего дня</td>
                <td>Конец рабочего дня</td>
            </tr>
            <tr>
                <td> 
                    <input type=date name="date" ?>>
                </td>
                <td> 
                    <input type=time step=1 name="begin_time" ?>>
                </td>
                <td> 
                    <input type=time step=1 name="end_time" ?>>
                </td>
            </tr>
        </table>
        <button type="submit" style="font-size: 17px">Добавить</button>
    </form>
</center>

<?php
if(isset($_POST['date'], $_POST['begin_time'], $_POST['end_time']))
{
    echo $_POST['date'];
    echo $_POST['begin_time'];
    echo $_POST['end_time'];
    $insert = $pdo->prepare("INSERT INTO 'schedule' ('emploee_id', 'date', 'begin_time', 'end_time' ) VALUES (:emploee_id, :date, :begin_time, :end_time)");
    $insert->bindValue(':emploee_id', $emploee_id);
    $insert->bindValue(':date', $_POST['date']);
    $insert->bindValue(':begin_time', $_POST['begin_time']);
    $insert->bindValue(':end_time', $_POST['end_time']);
    $insert->execute();
}
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="schedule.php?emploee_id=<?=$emploee_id?>">
    <center>
    <button style="font-size: 17px">Отмена</button>
    </center>
</form>