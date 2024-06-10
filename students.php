<?php

// include required php files
require "src/config.php";
require "models/Student.php";

// get parameters from request
$search    = getParameter('search', ''); // the search text
$orderBy   = getParameter('order_by', 'id'); // the order by column
$orderType = getParameter('order_type', 'ASC'); // the order type (ASC, DESC)

// check for the order by column
if (!in_array($orderBy, ["id", "first_name", "last_name", "gender", "birth_date"]))
  logError("Invalid order by: " . $orderBy);
// check for the order type
else if (!in_array($orderType, ["ASC", "DESC"]))
  logError("Invalid order type: " . $orderType);

/**
 * @var Student[] $student the students array
 */
$students = [];

// check if search text is not null
if ($search)
  // search for the students
  $students = Student::search(CON, $search, $orderBy, $orderType);
else
  // get all the students
  $students = Student::all(CON, $orderBy, $orderType);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Students</title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include 'views/menu.php';
    ?>

    <form action="" method="get">
      
      <div class="mb-3">
        <label for="search" class="form-label">Search: </label>
        <input type="text" name="search" id="search" class="form-control" value="<?= $search ?>">
      </div>
      
      <div class="mb-3">
        <label for="order-by" class="form-label">Order By</label>
        <select name="order_by" id="order-by" class="form-select">
          <option value="id" class="form-select" <?= $orderBy == 'id' ? 'selected' : '' ?>>
            Id
          </option>
          <option value="first_name" class="form-select" <?= $orderBy == 'first_name' ? 'selected' : '' ?>>
            First name
          </option>
          <option value="last_name" class="form-select" <?= $orderBy == 'last_name' ? 'selected' : '' ?>>
            Last name
          </option>
          <option value="gender" class="form-select" <?= $orderBy == 'gender' ? 'selected' : '' ?>>
            Gender
          </option>
          <option value="birth_date" class="form-select" <?= $orderBy == 'birth_date' ? 'selected' : '' ?>>
            Birth date
          </option>
        </select><br>
      </div>

      <div class="mb-3">
        <label for="order-type" class="form-label">Order Type:</label>
        <div id="order-type" class="form-check">
          <input type="radio" name="order_type" id="order-type-asc" value="ASC" <?= $orderType == 'ASC' ? 'checked' : '' ?> class="form-check-input">
          <label for="order-type-asc" class="form-check-label">ASC</label><br>
          <input type="radio" name="order_type" id="order-type-desc" value="DESC" <?= $orderType == 'DESC' ? 'checked' : '' ?> class="form-check-input">
          <label for="order-type-desc" class="form-check-label">DESC</label>
        </div>
      </div>

      <input type="submit" value="Load" class="btn btn-primary">

    </form>

    <hr>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">First name</th>
          <th scope="col">Last name</th>
          <th scope="col">Gender</th>
          <th scope="col">Birth date</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($students as $student) {?>
        <tr>
          <td scope="row"><?= $student->id ?></td>
          <td><?= $student->first_name ?></td>
          <td><?= $student->last_name ?></td>
          <td><?= $student->gender ?></td>
          <td><?= $student->birth_date ?></td>
          <td>
            <a href="./student.php?id=<?= $student->id?>">View</a>
            <a href="./create_edit_student.php?id=<?= $student->id?>">Edit</a>
            <a href="./delete_student.php?id=<?= $student->id?>">Delete</a>
          </td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>