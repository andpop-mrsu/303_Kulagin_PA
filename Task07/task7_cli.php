<?php
$pdo = new PDO('sqlite:salon.db');

$query = "SELECT id, surname FROM emploee ORDER BY id";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();

echo "\nВыберите Мастера\n";
foreach ($rows as $row) {
    echo $row['id'] . ' ' . $row['surname'] . "\n";
}
$statement->closeCursor();

$emploee_num = readline("\n");

$number_is_correct = false;
foreach ($rows as $row) {
    if ($row['id'] == $emploee_num){
        $number_is_correct = true;
    }
}

if ('' == $emploee_num){
    $number_is_correct = true;
}

if (!$number_is_correct){
    echo "Вы ввели некорректный номер мастера";
}
else if ('' == $emploee_num){
    $query = "SELECT emploee.id, emploee.name, emploee.surname, work.date, work.time, services.service_name, services.price FROM emploee INNER JOIN work ON emploee.id = work.emploee_id INNER JOIN appointment ON work.id = appointment.work_id INNER JOIN services ON appointment.service_id = services.id where work.done = 'yes' ORDER BY emploee.surname, work.date, work.time";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();

    foreach ($rows as $row) {
        echo $row['id'] . ' ' . $row['name'] . ' ' . $row['surname'] . ' ' . $row['date'] . ' ' . $row['time'] . ' ' . $row['service_name'] . ' ' . $row['price'] . "\n";
    }
    $statement->closeCursor();
}
else{
    $query = "SELECT emploee.id, emploee.name, emploee.surname, work.date, work.time, services.service_name, services.price FROM emploee INNER JOIN work ON emploee.id = work.emploee_id INNER JOIN appointment ON work.id = appointment.work_id INNER JOIN services ON appointment.service_id = services.id WHERE emploee.id = :id and work.done = 'yes' ORDER BY emploee.surname, work.date, work.time";
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $emploee_num]);
    $rows = $statement->fetchAll();

    foreach ($rows as $row) {
        echo $row['id'] . ' ' . $row['name'] . ' ' . $row['surname'] . ' ' . $row['date'] . ' ' . $row['time'] . ' ' . $row['service_name'] . ' ' . $row['price'] . "\n";
    }
    $statement->closeCursor();

}
