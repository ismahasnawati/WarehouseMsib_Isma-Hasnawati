<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if (isset($_GET['id']) && isset($_GET['status'])) {
    $gudang->id = $_GET['id'];
    $gudang->status = ($_GET['status'] == 'aktif') ? 'tidak_aktif' : 'aktif';

    if ($gudang->updateStatus()) {
        header("Location: index.php?status=updated");
        exit(); // Menghentikan eksekusi skrip setelah pengalihan
    } else {
        echo "Gagal memperbarui status gudang.";
    }
} else {
    header("Location: index.php");
}
?>
