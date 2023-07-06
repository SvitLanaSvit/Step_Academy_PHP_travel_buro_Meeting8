<?
session_start();
unset($_SESSION['login']);
unset($_SESSION['roleUser']);
header("Location: index.php?page=5");