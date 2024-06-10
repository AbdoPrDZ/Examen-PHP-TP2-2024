<?php

// include required php files
require "src/config.php";
require "models/Student.php";

// get the id from parameter
$id = getParameter("id");

// find the student by id
$student = Student::find(CON, $id);

// check if the student is not null and try to delete it
if ($student && $student->delete(CON)) 
  // show success message
  echo "Successfully deleting student $id";
else
  // show error message
  echo "Invalid id: $id";
