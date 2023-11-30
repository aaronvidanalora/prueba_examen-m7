<?php
// Conexión a la base de datos
$db = mysqli_connect('localhost', 'root', 'root') or die('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));
?>

<html>
<head>
    <title>Commit</title>
</head>
<body>

<?php
// Acciones basadas en los parámetros de la URL (GET)
switch ($_GET['action']) {
    case 'add':
        switch ($_GET['type']) {
            case 'employees':
                // Consulta para insertar un nuevo empleado en la tabla employees
                $query = 'INSERT INTO employees (first_name, last_name, birth_date, hire_date, gender)
                          VALUES
                          ("' . $_POST['first_name'] . '",
                          "' . $_POST['last_name'] . '",
                          "' . date('Y-m-d', strtotime($_POST['birth_date'])) . '",
                          "' . date('Y-m-d', strtotime($_POST['hire_date'])) . '",
                          "' . $_POST['gender'] . '")';

                // Ejecutar la consulta
                $result = mysqli_query($db, $query) or die(mysqli_error($db));

                // Obtener el emp_no del empleado recién insertado
                $emp_no = mysqli_insert_id($db);

                // Consulta para insertar en dept_emp
                $query_dept_emp = 'INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date)
                                   VALUES
                                   (' . $emp_no . ',
                                   (SELECT dept_no FROM departments WHERE dept_name = "' . $_POST['dept_name'] . '"),
                                   "' . date('Y-m-d', strtotime($_POST['from_date'])) . '",
                                   "' . date('Y-m-d', strtotime($_POST['to_date'])) . '")';

                // Ejecutar la consulta
                $result_dept_emp = mysqli_query($db, $query_dept_emp) or die(mysqli_error($db));

                // Consulta para insertar en dept_manager
                $query_dept_manager = 'INSERT INTO dept_manager (emp_no, dept_no, from_date, to_date)
                                       VALUES
                                       (' . $emp_no . ',
                                       (SELECT dept_no FROM departments WHERE dept_name = "' . $_POST['dept_name'] . '"),
                                       "' . date('Y-m-d', strtotime($_POST['from_date'])) . '",
                                       "' . date('Y-m-d', strtotime($_POST['to_date'])) . '")';

                // Ejecutar la consulta
                $result_dept_manager = mysqli_query($db, $query_dept_manager) or die(mysqli_error($db));

                break;
        }
        break;
    case 'edit':
        switch ($_GET['type']) {
            case 'employees':
                // Verificar si $_POST['emp_no'] está presente y no está vacío
                if (isset($_POST['emp_no']) && !empty($_POST['emp_no'])) {
                    // Consulta para actualizar la información del empleado en la tabla employees
                    $query = 'UPDATE employees SET
                              first_name = "' . $_POST['first_name'] . '",
                              last_name = "' . $_POST['last_name'] . '",
                              birth_date = "' . date('Y-m-d', strtotime($_POST['birth_date'])) . '",
                              hire_date = "' . date('Y-m-d', strtotime($_POST['hire_date'])) . '",
                              gender = "' . $_POST['gender'] . '"
                              WHERE
                              emp_no = ' . $_POST['emp_no'];

                    // Ejecutar la consulta
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));

                    // Consulta para actualizar en dept_emp
                    $query = 'UPDATE dept_emp SET
                              dept_no = (SELECT dept_no FROM departments WHERE dept_name = "' . $_POST['dept_name'] . '"),
                              from_date = "' . date('Y-m-d', strtotime($_POST['from_date'])) . '",
                              to_date = "' . date('Y-m-d', strtotime($_POST['to_date'])) . '"
                              WHERE
                              emp_no = ' . $_POST['emp_no'];

                    // Ejecutar la consulta
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));

                    // Consulta para actualizar en dept_manager
                    $query = 'UPDATE dept_manager SET
                              dept_no = (SELECT dept_no FROM departments WHERE dept_name = "' . $_POST['dept_name'] . '"),
                              from_date = "' . date('Y-m-d', strtotime($_POST['from_date'])) . '",
                              to_date = "' . date('Y-m-d', strtotime($_POST['to_date'])) . '"
                              WHERE
                              emp_no = ' . $_POST['emp_no'];

                    // Ejecutar la consulta
                    $result = mysqli_query($db, $query) or die(mysqli_error($db));
                } else {
                    // Manejar el caso en que $_POST['emp_no'] no está presente o está vacío
                    echo "Error: Employee number is not provided.";
                }

                break;
        }
        break;
}

?>
<p>Done!</p>
</body>
</html>
