<html>
<body>
<?php
require_once 'config.php';

$udaje = $conn->prepare("SELECT login, time, type FROM approaches");
$udaje->execute();
$result = $udaje->fetchAll(PDO::FETCH_ASSOC);
?>
<h3>Login History:</h3>
<table id="customers">
    <tr>
        <th>Login/email</th>
        <th>Time</th>
        <th>Type</th>
    </tr>
    <?php
    foreach ($result as $row){
        echo "<tr>
                        <td>".$row['login']."</td>
                        <td>".$row['time']."</td>
                        <td>".$row['type']."</td>
                    </tr>";
    }
    ?>
</table>
</body>
</html>