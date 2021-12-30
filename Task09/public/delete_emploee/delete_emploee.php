<h1 align="center">Вы действительно хотите удалить этого работника?</h1>

<?php
    $emploee_id = $_GET['emploee_id'];
?>

<form method="post" enctype="application/x-www-form-urlencoded" action="dismissal_operation.php">
    <input type="hidden" name="emploee_id" value=<?= $emploee_id ?>>
    <center>
    <button style="font-size: 17px">Удалить работника</button>
    </center>
</form>

<form method="post" enctype="application/x-www-form-urlencoded" action="../index.php">
    <center>
    <button style="font-size: 17px">Отмена</button>
    </center>
</form>



