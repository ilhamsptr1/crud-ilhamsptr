<?php
include 'database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$pesan = '';
$tipe_pesan = '';

// Ambil data produk yang akan diedit
$query = "SELECT * FROM produk WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php?pesan=Produk tidak ditemukan&tipe=danger");
    exit();
}

$produk = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    
    // Validasi input
    if (empty($nama) || empty($harga) || empty($stok)) {
        $pesan = "Nama, harga, dan stok harus diisi!";
        $tipe_pesan = "danger";
    } else {
        $query = "UPDATE produk SET 
                  nama = '$nama',
                  deskripsi = '$deskripsi',
                  harga = '$harga',
                  stok = '$stok'
                  WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?pesan=Produk berhasil diperbarui&tipe=success");
            exit();
        } else {
            $pesan = "Error: " . mysqli_error($conn);
            $tipe_pesan = "danger";
        }
    }
}

mysqli_free_result($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Sistem CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-warning">
                        <i class="fas fa-edit me-2"></i>Edit Produk
                    </h2>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                
                <?php if($pesan): ?>
                    <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show" role="alert">
                        <?php echo $pesan; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Form Edit Produk</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?php echo htmlspecialchars($produk['nama']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga" name="harga" 
                                               value="<?php echo $produk['harga']; ?>" min="0" step="100" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stok" name="stok" 
                                           value="<?php echo $produk['stok']; ?>" min="0" required>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times me-1"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Perbarui Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Produk</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>ID Produk:</strong> <?php echo $produk['id']; ?></p>
                                <p class="mb-1"><strong>Tanggal Ditambahkan:</strong> <?php echo date('d-m-Y H:i', strtotime($produk['tanggal_ditambahkan'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong> 
                                    <span class="badge bg-<?php echo $produk['stok'] > 10 ? 'success' : ($produk['stok'] > 0 ? 'warning' : 'danger'); ?>">
                                        <?php echo $produk['stok'] > 0 ? 'Tersedia' : 'Habis'; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>