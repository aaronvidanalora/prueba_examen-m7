<?php
$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

if (!isset($_GET['do']) || $_GET['do'] != 1) {
    switch ($_GET['type']) {
        case 'employees':
            echo 'Are you sure you want to delete this employee?<br/>';
            break;
        // Agrega más casos según sea necesario para otras tablas
    } 
    echo '<a href="' . $_SERVER['REQUEST_URI'] . '&do=1">yes</a> '; 
    echo 'or <a href="select.php">no</a>';
} else {
    switch ($_GET['type']) {
        case 'employees':
            $emp_no = $_GET['id'];

            // Eliminar de la tabla dept_emp
            $query_dept_emp = 'DELETE FROM dept_emp 
                               WHERE emp_no = ' . $emp_no;
            $result_dept_emp = mysqli_query($db, $query_dept_emp) or die(mysqli_error($db));

            // Eliminar de la tabla dept_manager
            $query_dept_manager = 'DELETE FROM dept_manager 
                                   WHERE emp_no = ' . $emp_no;
            $result_dept_manager = mysqli_query($db, $query_dept_manager) or die(mysqli_error($db));

            // Eliminar de la tabla employees
            $query_employees = 'DELETE FROM employees 
                                WHERE emp_no = ' . $emp_no;
            $result_employees = mysqli_query($db, $query_employees) or die(mysqli_error($db));
            ?>
            <p style="text-align: center;">The employee has been deleted successfully!
            <a href="admin.php">Return to Index</a></p>
            <?php
            break;
        // Agrega más casos según sea necesario para otras tablas
    }
}
?>
