<?php
// Conexión a la base de datos
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));
?>

<html>
<head>
    <title>Employees database</title>
    <style type="text/css">
        th { background-color: #999; }
        .odd_row { background-color: #EEE; }
        .even_row { background-color: #FFF; }
    </style>
</head>
<body>
    <table style="width:100%;">
        <tr>
            <th colspan="2">Employees<a href="employees.php?action=add">[ADD]</a></th>
        </tr>
        <?php
        // Consulta para obtener todos los empleados de la base de datos
        $query = 'SELECT * FROM employees';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        $odd = true; // Variable para alternar entre filas pares e impares en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
            $odd = !$odd; // Alternar entre filas pares e impares
            echo '<td style="width:75%;">';
            echo $row['first_name'];
            echo '</td><td>';
            echo ' <a href="employees.php?action=edit&id=' . $row['emp_no'] . '"> [EDIT]</a>';
            echo ' <a href="delete.php?type=employees&id=' . $row['emp_no'] . '"> [DELETE]</a>';
            echo '</td></tr>';
        }
        ?>
    </table>
</body>
</html>
