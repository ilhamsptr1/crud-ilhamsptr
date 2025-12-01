<?php
include 'database.php';

$pesan = '';
$tipe_pesan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    
   
    if (empty($nama) || empty($harga) || empty($stok)) {
        $pesan = "Nama, harga, dan stok harus diisi!";
        $tipe_pesan = "danger";
    } else {
        $query = "INSERT INTO produk (nama, deskripsi, harga, stok) 
                  VALUES ('$nama', '$deskripsi', '$harga', '$stok')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?pesan=Produk berhasil ditambahkan&tipe=success");
            exit();
        } else {
            $pesan = "Error: " . mysqli_error($conn);
            $tipe_pesan = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Sistem CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
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
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Form Tambah Produk</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required 
                                       placeholder="Masukkan nama produk">
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                                          placeholder="Masukkan deskripsi produk (opsional)"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga" name="harga" 
                                               min="0" step="100" required placeholder="Contoh: 1000000">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stok" name="stok" 
                                           min="0" required placeholder="Jumlah stok">
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-redo me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>