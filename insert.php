<?php
// Establecer la conexión con la base de datos
$db = mysqli_connect('localhost', 'root', 'root') or 
    die ('Unable to connect. Check your connection parameters.');

// Asegurarnos de que nuestra base de datos recién creada sea la activa
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

$query_insert_employee = "INSERT INTO employees (emp_no, birth_date, first_name, last_name, gender, hire_date)
                         VALUES (1, '1990-01-15', 'John', 'Doe', 'M', '2020-05-01'),
                                (2, '1988-07-20', 'Jane', 'Smith', 'F', '2019-03-15')";
mysqli_query($db, $query_insert_employee) or die("Error al insertar datos en la tabla employees: " . mysqli_error($db));


$query_insert_department = "INSERT INTO departments (dept_no, dept_name)
                           VALUES ('HR', 'Human Resources'),
                                  ('IT', 'Information Technology')";
mysqli_query($db, $query_insert_department) or die("Error al insertar datos en la tabla departments: " . mysqli_error($db));


$query_insert_dept_emp = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date)
VALUES (1, 'HR', '2020-05-01', '2022-01-01'),
       (2, 'IT', '2019-03-15', '2023-06-30')";
mysqli_query($db, $query_insert_dept_emp) or die("Error al insertar datos en la tabla dept_emp: " . mysqli_error($db));

$query_insert_dept_manager = "INSERT INTO dept_manager (dept_no, emp_no, from_date, to_date)
                             VALUES ('HR', 1, '2020-05-01', '2022-01-01'),
                                    ('IT', 2, '2019-03-15', '2023-06-30')";
mysqli_query($db, $query_insert_dept_manager) or die("Error al insertar datos en la tabla dept_manager: " . mysqli_error($db));


// Cerrar conexión
mysqli_close($db);
?>
