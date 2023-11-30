<?php
// Conexión a la base de datos
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

// Inicialización de variables
if ($_GET['action'] == 'edit') {
    // Recuperar información del empleado para editar
    $id = $_GET["id"];
    $query = "SELECT * FROM employees WHERE emp_no = $id ";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    extract(mysqli_fetch_assoc($result));

    // Recuperar información del departamento desde dept_emp
    $deptEmpQuery = "SELECT dept_no, from_date, to_date FROM dept_emp WHERE emp_no = $id ORDER BY to_date DESC LIMIT 1";
    $deptEmpResult = mysqli_query($db, $deptEmpQuery) or die(mysqli_error($db));
    $deptEmpInfo = mysqli_fetch_assoc($deptEmpResult);

    // Recuperar información del departamento desde dept_manager
    $deptManagerQuery = "SELECT dept_no, from_date, to_date FROM dept_manager WHERE emp_no = $id ORDER BY to_date DESC LIMIT 1";
    $deptManagerResult = mysqli_query($db, $deptManagerQuery) or die(mysqli_error($db));
    $deptManagerInfo = mysqli_fetch_assoc($deptManagerResult);
} else {
    // Valores por defecto para un nuevo empleado
    $first_name = '';
    $last_name = '';
    $gender = '';
    $birth_date = time();
    $hire_date = time();
    $dept_name = '';
    $from_date = time();
    $to_date = time();
}
?>

<html>
<head>
    <title><?php echo ucfirst($_GET['action']); ?> Employees</title>
    <style type="text/css">
        #error {
            background-color: #600;
            border: 1px solid #FF0;
            color: #FFF;
            text-align: center;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Mostrar mensaje de error si existe
    if (isset($_GET['error']) && $_GET['error'] != '') {
        echo '<div id="error">' . $_GET['error'] . '</div>';
    }
    ?>

    <form action="commit.php?action=<?php echo $_GET['action']; ?>&type=employees" method="post">
        <table>
            <tr>
                <td>First Name</td>
                <td><input type="text" name="first_name" value="<?php echo $first_name; ?>" /></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><input type="text" name="last_name" value="<?php echo $last_name; ?>" /></td>
            </tr>
            <tr>
                <td>Birth Date<br /><small>(dd-mm-yyyy)</small></td>
                <td><input type="date" name="birth_date" value="<?php echo $birth_date; ?>" /></td>
            </tr>
            <tr>
                <td>Hire Date<br /><small>(dd-mm-yyyy)</small></td>
                <td><input type="date" name="hire_date" value="<?php echo $hire_date; ?>" /></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <select name="gender">
                        <option value="M" <?php if ($gender == 'M') echo 'selected="selected"'; ?>>M</option>
                        <option value="F" <?php if ($gender == 'F') echo 'selected="selected"'; ?>>F</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Department Name</td>
                <td>
                    <select name="dept_name">
                        <?php
                        // Obtener nombres de departamentos de la base de datos
                        $query = "SELECT dept_name FROM departments";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));

                        // Mostrar opciones en el menú desplegable
                        while ($row = mysqli_fetch_assoc($result)) {
                            $deptName = $row['dept_name'];
                            echo '<option value="' . $deptName . '" ' . ($dept_name == $deptName ? 'selected="selected"' : '') . '>' . $deptName . '</option>';
                        }

                        mysqli_free_result($result);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>From Date<br /><small>(dd-mm-yyyy)</small></td>
                <td><input type="date" name="from_date" value="<?php echo $from_date; ?>" /></td>
            </tr>
            <tr>
                <td>To Date<br /><small>(dd-mm-yyyy)</small></td>
                <td><input type="date" name="to_date" value="<?php echo $to_date; ?>" /></td>
            </tr>
            <?php
            // Agregar campo oculto para el número de empleado si se está editando
            if ($_GET['action'] == 'edit') {
                echo '<input type="hidden" name="emp_no" value="' . $id . '" />';
            }
            ?>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="submit" value="<?php echo ucfirst($_GET['action']); ?>" />
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
