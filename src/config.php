<?php

require 'connection.php';

// define the database connection
define('CON', connect());

/**
 * Get parameter from request if exists
 *
 * @param string $name the name of parameter
 * @param mixed $default the default value of not exists
 * @return mixed the parameter value
 */
function getParameter(string $name, mixed $default = null): string | null {
  return isset($_REQUEST) && isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

/**
 * Get the request method
 *
 * @return string the request method (POST, GET)
 */
function getMethod(): string {
  return $_SERVER['REQUEST_METHOD'];
}

/**
 * print error and die
 *
 * @param string $message the message
 * @return void
 */
function logError(string $message) {
  echo $message;
  die();
}

/**
 * Redirect from current location to new url
 *
 * @param string $url the new url
 * @return void
 */
function redirect(string $url) {
  header("Location: $url");
}
