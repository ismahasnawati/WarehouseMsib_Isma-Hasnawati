<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];
    
    // Proses penghapusan
    $gudang->delete();
    header("Location: index.php?status=deleted");
} else {
    header("Location: index.php");
}
?>
