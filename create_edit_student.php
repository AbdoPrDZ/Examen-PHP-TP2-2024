<?php

// include required php files
require "src/config.php";
require "models/Student.php";

// get parameters from request
$id        = getParameter('id');
$firstName = getParameter('first_name', '');
$lastName  = getParameter('last_name', '');
$gender    = getParameter('gender', 'male');
$birthDate = getParameter('birth_date', '');

/**
 * @var Student | null $student the student
 */
$student = null;

// set all the request errors to null
$errors = [
  'first_name' => null,
  'last_name'  => null,
  'gender'     => null,
  'birth_date' => null,
];

// check for the id if not null
if ($id) {
  // find the student by id
  $student = Student::find(CON, $id);

  // check if the student is null
  if (!$student)
    logError("Invalid id: " . $id); // log error
  else if (getMethod() == 'GET') { // check if the request method is GET
    // fill the fields by the founded student
    $firstName = $student->first_name;
    $lastName  = $student->last_name;
    $gender    = $student->gender;
    $birthDate = $student->birth_date;
  }
}

// check if the request method is POST
if (getMethod() == 'POST') {
  // set the request validation to true
  $valid = true;

  // validate the first name
  if ($firstName == null || $firstName == "") {
    $errors['first_name'] = "The first name is required";
    $valid = false;
  }

  // validate the last name
  if ($lastName == null || $lastName == "") {
    $errors['last_name'] = "The last name is required";
    $valid = false;
  }

  // validate the gander
  if ($gender == null || $gender == "") {
    $errors['gender'] = "The gender is required";
    $valid = false;
  } else if (!in_array($gender, ['male', 'female'])){
    $errors['gender'] = "Invalid gender";
    $valid = false;
  }

  // validate the birth date
  if ($birthDate == null || $birthDate == "") {
    $errors['birth_date'] = "The birth date is required";
    $valid = false;
  }

  // check if the request is valid
  if ($valid) {
    // check if there is student
    if ($student) {
      // change the current student with the new values
      $student->first_name = $firstName;
      $student->last_name  = $lastName;
      $student->gender     = $gender;
      $student->birth_date = $birthDate;

      // update the student values and if is success
      if (!$student->update(CON))
        logError("cannot edit student"); // log failed error
    } else {
      // create an instance for the new student
      $student = new Student(
        null,
        $firstName,
        $lastName,
        $gender,
        $birthDate,
      );

      // insert the new student and get the inserted id
      $id = Student::create(CON, $student);
    }
    
    // check if the id not null
    if ($id)
      // redirect the student page with the id
      redirect(" ./student.php?id=$id");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$id ? 'Edit' : 'Create' ?> Student</title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include 'views/menu.php';
    ?>

    <h1><?=$id ? 'Edit' : 'Create' ?> Student <?= $id ?></h1>

    <form action="" method="post">

      <div class="mb-3">
        <label for="first-name" class="form-label">First name:</label>
        <input type="text" name="first_name" id="first-name" value="<?= $firstName ?>" class="form-control <?= $errors['first_name'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['first_name']) echo $errors['first_name'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="last-name" class="form-label">Last name:</label>
        <input type="text" name="last_name" id="last-name" value="<?= $lastName ?>" class="form-control <?= $errors['last_name'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['last_name']) echo $errors['last_name'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="gender" class="form-label">Gender:</label>
        <div id="gender" class="form-check">
          <input type="radio" name="gender" id="gender-male" value="male" <?= $gender == 'male' ? 'checked' : '' ?> class="form-check-input">
          <label for="gender-male" class="form-check-label">Male</label>
          <br>
          <input type="radio" name="gender" id="gender-female" value="female" <?= $gender == 'female' ? 'checked' : '' ?> class="form-check-input">
          <label for="gender-female" class="form-check-label">Female</label>
        </div>
        <div class="invalid-feedback">
          <?php if ($errors['gender']) echo $errors['gender'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="birth-date" class="form-label">Birth date:</label>
        <input type="date" name="birth_date" id="birth-date" value="<?= $birthDate ?>" class="form-control <?= $errors['birth_date'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['birth_date']) echo $errors['birth_date'] ?>
        </div>
      </div>

      <input type="submit" value="<?=$id ? 'Edit' : 'Create' ?>" class="btn btn-primary">
    </form>

    <?php if ($id) echo '<a href="./delete_student.php?id=' . $id . '">Delete</a>'; ?>
  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>