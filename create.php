<?php

    $db = mysqli_connect('localhost', 'root', 'root') or 
        die ('Unable to connect. Check your connection parameters.');
    mysqli_select_db($db, 'moviesite')or die(mysqli_error($db));

    $query = 'CREATE TABLE employees (
        emp_no      INT  AUTO_INCREMENT,
        birth_date  DATE            NOT NULL,
        first_name  VARCHAR(14)     NOT NULL,
        last_name   VARCHAR(16)     NOT NULL,
        gender      ENUM ("M","F")  NOT NULL, 
        hire_date   DATE            NOT NULL,
        PRIMARY KEY (emp_no)
    );';

    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $query = 'CREATE TABLE departments (
        dept_no     CHAR(4)         NOT NULL,  
        dept_name   VARCHAR(40)     NOT NULL,
        PRIMARY KEY (dept_no),                
        UNIQUE  KEY (dept_name)                
    );';
    
   mysqli_query($db,$query) or die(mysqli_error($db));

    $query = 'CREATE TABLE dept_emp (
        emp_no      INT         NOT NULL,
        dept_no     CHAR(4)     NOT NULL,
        from_date   DATE        NOT NULL,
        to_date     DATE        NOT NULL,
        KEY         (emp_no),   
        KEY         (dept_no),  
        FOREIGN KEY (emp_no) REFERENCES employees (emp_no) ON DELETE CASCADE,
        FOREIGN KEY (dept_no) REFERENCES departments (dept_no) ON DELETE CASCADE,
        PRIMARY KEY (emp_no, dept_no)
    );';

    mysqli_query($db,$query) or die(mysqli_error($db));

    $query = 'CREATE TABLE dept_manager (
        dept_no      CHAR(4)  NOT NULL,
        emp_no       INT      NOT NULL,
        from_date    DATE     NOT NULL,
        to_date      DATE     NOT NULL,
        KEY         (emp_no),
        KEY         (dept_no),
        FOREIGN KEY (emp_no)  REFERENCES employees (emp_no)    ON DELETE CASCADE,                              
        FOREIGN KEY (dept_no) REFERENCES departments (dept_no) ON DELETE CASCADE,
        PRIMARY KEY (emp_no, dept_no)
     );';

    mysqli_query($db,$query) or die(mysqli_error($db));

        $query = "INSERT INTO employees (birth_date, first_name, last_name, gender, hire_date) VALUES 
            ('1990-05-15', 'Juan', 'López', 'M', '2010-03-20'),
        ('1985-12-10', 'María', 'Gómez', 'F', '2008-08-15'),
        ('1988-08-25', 'Carlos', 'Martínez', 'M', '2015-01-10')";
    mysqli_query($db, $query) or die(mysqli_error($db));

    
    $query = "INSERT INTO departments (dept_no, dept_name) VALUES 
        ('D001', 'Ventas'),
        ('D002', 'Recursos Humanos'),
        ('D003', 'Producción')";
    mysqli_query($db, $query) or die(mysqli_error($db));

        
    $query = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date) VALUES 
        (1, 'D001', '2010-03-20', '2022-01-01'),
        (2, 'D002', '2008-08-15', '2023-05-30'),
        (3, 'D003', '2015-01-10', '2021-12-31')";
    mysqli_query($db, $query) or die(mysqli_error($db));

        
    $query = "INSERT INTO dept_manager (emp_no, dept_no, from_date, to_date) VALUES 
        (1, 'D001', '2010-03-20', '2015-06-30'),
        (2, 'D002', '2008-08-15', '2013-12-31'),
        (3, 'D003', '2015-01-10', '2018-09-15')";
     mysqli_query($db, $query) or die(mysqli_error($db));


?>