<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Cek apakah ID gudang ada
if (isset($_GET['id'])) {
    $gudang->id = $_GET['id'];
    $gudang->readOne();
} else {
    header("Location: index.php");
    exit;
}

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];
    $gudang->opening_hour = $_POST['opening_hour'];
    $gudang->closing_hour = $_POST['closing_hour'];

    // Cek apakah update berhasil
    if ($gudang->update()) {
        // Redirect ke index.php dengan pesan status
        header("Location: index.php?status=updated");
        exit;
    } else {
        echo "Gagal memperbarui gudang.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Gudang</h2>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Gudang</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($gudang->name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($gudang->location); ?>" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($gudang->capacity); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="aktif" <?= ($gudang->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                    <option value="tidak_aktif" <?= ($gudang->status == 'tidak_aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="opening_hour" class="form-label">Waktu Buka</label>
                <input type="time" class="form-control" id="opening_hour" name="opening_hour" value="<?= htmlspecialchars($gudang->opening_hour); ?>" required>
            </div>
            <div class="mb-3">
                <label for="closing_hour" class="form-label">Waktu Tutup</label>
                <input type="time" class="form-control" id="closing_hour" name="closing_hour" value="<?= htmlspecialchars($gudang->closing_hour); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
