<?php 
include 'koneksi.php';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$data = ['nama_produk' => '', 'harga' => '', 'stok' => '', 'foto' => ''];

if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? 'Edit' : 'Tambah'; ?> Produk</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px; }
        .form-card { max-width: 500px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="file"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-save { background-color: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; width: 100%; border-radius: 4px; }
        .btn-back { display: block; text-align: center; margin-top: 10px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="form-card">
        <h3><?= $id ? 'Update' : 'Tambah'; ?> Data Produk</h3>
        <form action="proses.php" method="POST" enctype="multipart/form-data" id="produkForm">
            <input type="hidden" name="id" value="<?= $id; ?>">
            
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" value="<?= $data['nama_produk']; ?>">
            </div>
            
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" id="harga" value="<?= $data['harga']; ?>">
            </div>
            
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" id="stok" value="<?= $data['stok']; ?>">
            </div>
            
            <div class="form-group">
                <label>Foto Produk <?= $id ? '(Kosongkan jika tidak ingin ganti)' : ''; ?></label>
                <input type="file" name="foto" id="foto">
            </div>

            <button type="submit" name="simpan" class="btn-save">Simpan Data</button>
            <a href="index.php" class="btn-back">Kembali</a>
        </form>
    </div>

    <script>
        document.getElementById('produkForm').onsubmit = function(e) {
            const nama = document.getElementById('nama_produk').value;
            const harga = document.getElementById('harga').value;
            const stok = document.getElementById('stok').value;
            const foto = document.getElementById('foto');
            const isEdit = "<?= $id; ?>" !== "";

            if (!nama || !harga || !stok) {
                alert("Semua field teks wajib diisi!");
                e.preventDefault();
                return;
            }

            if (!isEdit && foto.files.length === 0) {
                alert("Foto wajib diunggah untuk data baru!");
                e.preventDefault();
                return;
            }

            if (foto.files.length > 0) {
                const file = foto.files[0];
                const type = file.type;
                const size = file.size;

                if (!['image/jpeg', 'image/jpg', 'image/png'].includes(type)) {
                    alert("Hanya file JPG, JPEG, dan PNG yang diperbolehkan!");
                    e.preventDefault();
                } else if (size > 2 * 1024 * 1024) {
                    alert("Ukuran file maksimal 2 MB!");
                    e.preventDefault();
                }
            }
        };
    </script>
</body>