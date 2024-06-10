<?php

// include required php files
require "src/config.php";
require "models/Student.php";

// get the id from parameter
$id = getParameter("id");

/**
 * @var Student | null $student the student
 */
$student = null;

// check if the id is not null
if ($id)
  // find the student
  $student = Student::find(CON, $id);

// check if ths student is null
if ($student == null)
  logError("Invalid id $id"); // log error

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - <?= $id ?></title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include 'views/menu.php';
    ?>

    <h1>Student Details: </h1>
    <h2>ID: <?= $student->id ?></h2>
    <h2>First name: <?= $student->first_name ?></h2>
    <h2>Last name: <?= $student->last_name ?></h2>
    <h2>Gender: <?= $student->gender ?></h2>
    <h2>Birth date: <?= $student->birth_date ?></h2>

    <a href="./create_edit_student.php?id=<?= $id?>">Edit</a>
    <a href="./delete_student.php?id=<?= $id?>">Delete</a>

  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
