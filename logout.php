<?php
// start session
session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();

// Redirect to login
header('Location: login.php');