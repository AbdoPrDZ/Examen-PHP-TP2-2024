<?php

// define the app database information
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'examen_school');

/**
 * Create pdo connection for app database
 *
 * @return PDO | null the pdo connection
 */
function connect(): PDO | null {
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
  $user = DB_USER;
  $password = DB_PASS;

  $con = null;

  try {
    $con = new PDO($dsn,$user,$password);
  } catch (Exception $e) {
    logError("Connection failed: " . $e->getMessage());
  }

  return $con;
}
