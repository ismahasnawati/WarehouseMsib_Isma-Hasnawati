<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Pencarian
$keyword = "";
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
}

$stmt = $gudang->read($keyword);
$num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse MSIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Gudang</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="create.php" class="btn btn-primary">Tambah Gudang</a>
            <form method="GET" class="d-flex">
                <input type="text" name="search" value="<?= htmlspecialchars($keyword); ?>" class="form-control" placeholder="Cari nama gudang">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>

        <!-- Menampilkan pesan sukses jika status=created -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'created'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                Gudang berhasil ditambahkan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


              <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Gudang berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

           <!--  -->
        <?php if ($num > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Gudang</th>
                        <th>Lokasi</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Waktu Buka</th>
                        <th>Waktu Tutup</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['location']; ?></td>
                            <td><?= $row['capacity']; ?></td>
                            <td><?= ucfirst($row['status']); ?></td>
                            <td><?= $row['opening_hour']; ?></td>
                            <td><?= $row['closing_hour']; ?></td>
                            <td>
                                <a href="update.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                                <a href="change_status.php?id=<?= $row['id']; ?>&status=<?= $row['status'] == 'aktif' ? 'tidak_aktif' : 'aktif'; ?>" class="btn btn-info btn-sm"><?= $row['status'] == 'aktif' ? 'Nonaktifkan' : 'Aktifkan'; ?></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">Tidak ada gudang yang terdaftar.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
