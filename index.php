<?php
include 'database.php';

$query = "SELECT * FROM produk ORDER BY tanggal_ditambahkan DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem CRUD Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">
                <i class="fas fa-boxes me-2"></i>Sistem Manajemen Produk
            </h1>
            <a href="create.php" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Tambah Produk
            </a>
        </div>
        
        <?php if(isset($_GET['pesan'])): ?>
            <div class="alert alert-<?php echo $_GET['tipe'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['pesan']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Produk</h5>
            </div>
            <div class="card-body">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Tanggal Ditambahkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                                        <td class="fw-bold text-success">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $row['stok'] > 10 ? 'success' : ($row['stok'] > 0 ? 'warning' : 'danger'); ?>">
                                                <?php echo $row['stok']; ?> unit
                                            </span>
                                        </td>
                                        <td><?php echo date('d-m-Y H:i', strtotime($row['tanggal_ditambahkan'])); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">Belum ada data produk</h4>
                        <p class="text-muted">Mulai dengan menambahkan produk baru</p>
                        <a href="create.php" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Produk Pertama
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-muted">
                Total: <?php echo mysqli_num_rows($result); ?> produk
            </div>
        </div>
    </div>
    
    <footer class="mt-5 py-3 text-center text-muted">
        <small>Sistem CRUD Produk &copy; <?php echo date('Y'); ?> - Dibuat oleh Ilham Saputra</small>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_free_result($result); ?>