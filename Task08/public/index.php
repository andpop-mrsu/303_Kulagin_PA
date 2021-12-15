<?php
$pdo = new PDO('sqlite:../data/salon.db');
//$pdo = new PDO('sqlite:C:\Users\140\Desktop\Univercity\5 semester\Базы днных\task08\data\salon.db');
?>

<h1>Add new emploee</h1>
<body>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" action="index.php">
        <p><label>Name: <input name="name"></label></p>
        <p><label>Surname: <input name="surname"></label></p>
        <p><label>Percent: <input name="percent"></label></p>
        <fieldset>
            <legend> specialization </legend>
            <p><label> <input type=radio name=specialization value="male"> male </label></p>
            <p><label> <input type=radio name=specialization value="female"> female </label></p>
            <p><label> <input type=radio name=specialization value="universal"> universal </label></p>
        </fieldset>
        <p><button type="submit">Save emploee</button></p>
    </form>
</body>

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

///////////////////////////////////
<?php
$query = "SELECT id, name, surname FROM emploee where status = 'works' ORDER BY id";
$statement = $pdo->query($query);
$rows_emploee = $statement->fetchAll();
?>

<h1>Add schedule of emploee</h1>
<form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
    <p>Emploee:
        <select name="id">
            <?php foreach ($rows_emploee as $row) { ?>
                <option value= <?= $row['id']?>>
                    <?=$row['id'] . '  ' . $row['name']. '  ' . $row['surname'] ?>
                </option>
            <?php 
                } 
                $statement->closeCursor(); 
            ?>
        </select>
    </p>
    <p><label>Date of work: <input type=date name="date"></label> </p>
    <p><label>Beginning of work: <input type=time step="1" name="begin_time"></label></p>
    <p><label>End of work: <input type=time step="1" name="end_time"></label></p>
    <p><button type="submit">Save schedule</button></p>
</form>

<?php
if(isset($_POST['id'], $_POST['date'], $_POST['begin_time'], $_POST['end_time']))
{
    $insert = $pdo->prepare("INSERT INTO 'schedule' ('emploee_id', 'date', 'begin_time', 'end_time' ) VALUES (:emploee_id, :date, :begin_time, :end_time)");
    $insert->bindValue(':emploee_id', $_POST['id']);
    $insert->bindValue(':date', $_POST['date']);
    $insert->bindValue(':begin_time', $_POST['begin_time']);
    $insert->bindValue(':end_time', $_POST['end_time']);
    $insert->execute();
}
?>


/////////////////////////////////////////////
<?php
$query = "SELECT id, service_name, gender, duration FROM services ORDER BY id";
$statement = $pdo->query($query);
$rows_services = $statement->fetchAll();
?>

<h1>Make an appointment</h1>
<form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
    <p>Service:
        <select name="service">
            <?php foreach ($rows_services as $row) { ?>
                <option value= <?= $row['id']?>>
                    <?=$row['id'] . '  ' . $row['service_name']?>
                </option>
            <?php 
                } 
                $statement->closeCursor(); 
            ?>
        </select>
        <button type="submit">Select service</button>
    </p>
</form>


<?php
if(isset($_POST['service']) )
{
    $service_id = $_POST['service'];
    $query = "SELECT gender from services where id = '{$service_id}';";
    $statement = $pdo->query($query);
    $tmp = $statement->fetch();
    $specialization = $tmp['gender'];
    $query = "SELECT emploee.id, emploee.surname FROM emploee where emploee.specialization = '{$specialization}'";
    $statement = $pdo->query($query);
    $rows_specialists = $statement->fetchAll();
}
?>


<form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
    <p>Emploee:
        <select name="id">
            <?php foreach ($rows_specialists as $row) { ?>
                <option value= <?= $row['id']?>>
                    <?=$row['id'] . '  ' . $row['surname'] ?>
                </option>
            <?php 
                } 
                $statement->closeCursor(); 
            ?>
        </select>
        <button type="submit">Select an employee</button>
        <p><input type=hidden name="service_id" value="<?= $service_id ?>"></p>
    </p>
</form>

<?php
$selected_employee_id = 0;
$service_id = $_POST['service_id'];
if(isset($_POST['id']))
{
    $selected_employee_id = (int) $_POST['id'];
}
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
    <p><label>Date: <input type=date name="date_appointment"></label> </p>
    <p><label>Time: <input type=time step="1" name="time_appointment"></label></p>
    <p><input type=hidden name="selected_employee_id" value="<?= $selected_employee_id ?>"></p>
    <p><input type=hidden name="service_id" value="<?= $service_id ?>"></p>
    <p><button type="submit">Make an appointment</button></p>
</form>

<?php
if(isset($_POST['date_appointment'], $_POST['time_appointment']))
{
    $date_appointment = $_POST['date_appointment'];
    $time_appointment = $_POST['time_appointment'];
    $selected_employee_id = $_POST['selected_employee_id'];
    $service_id = $_POST['service_id'];
    $query = "SELECT date, begin_time, end_time FROM schedule where emploee_id = '{$selected_employee_id}'";
    $statement = $pdo->query($query);
    $emploee_schedule = $statement->fetchAll();
    $date_is_ok = false;
    $time_is_ok = false;
    foreach($emploee_schedule as $row)
    {
        if ($row['date'] == $date_appointment)
        {
            $date_is_ok = true;
            $unix_datetime_appointment = strtotime($date_appointment. " " . $time_appointment);
            $unix_datetime_begin_work = strtotime($row['date']. " " . $row['begin_time']);
            $unix_datetime_end_work = strtotime($row['date']. " " . $row['end_time']);
            if ($unix_datetime_begin_work <= $unix_datetime_appointment and $unix_datetime_appointment <= $unix_datetime_end_work)
            {
                
                $time_is_ok = true;
                $insert = $pdo->prepare("INSERT INTO 'work' ('emploee_id', 'date', 'time' ) VALUES (:emploee_id, :date, :time)");
                $insert->bindValue(':emploee_id', $selected_employee_id);
                $insert->bindValue(':date', $date_appointment);
                $insert->bindValue(':time', $time_appointment);
                $insert->execute();
                $query = "select MAX(id) from work;";
                $statement = $pdo->query($query);
                $work_id = $statement->fetch();
                $insert = $pdo->prepare("INSERT INTO 'appointment' ('work_id', 'service_id') VALUES (:work_id, :service_id)");
                $insert->bindValue(':work_id', $work_id["MAX(id)"]);
                $insert->bindValue(':service_id', $service_id);
                $insert->execute();
                  
            }
        }
    }
    if ((!$date_is_ok or !$time_is_ok) and isset($_POST['date_appointment']))
    {
        if (!$date_is_ok)
        {
            echo "this employee does not work on this day";
        }
        else 
        {
            echo "this employee does not work on this time";
        }
    }
}
?>
