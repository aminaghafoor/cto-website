<?php
session_start();


$conn = new mysqli('localhost', 'root', '', 'amna');
$id = (int)$_GET['id'];
$conn->query("DELETE FROM observations WHERE id = $id");

echo "Post deleted successfully.";
?>