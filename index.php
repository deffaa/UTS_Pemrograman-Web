<?php 
include 'koneksi.php';
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 4px; color: white; font-size: 14px; }
        .btn-add { background-color: #28a745; margin-bottom: 15px; display: inline-block; }
        .btn-edit { background-color: #ffc107; color: #000; }
        .btn-delete { background-color: #dc3545; }
        img { border-radius: 4px; object-fit: cover; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen Data Produk</h2>
        <a href="form.php" class="btn btn-add">Tambah Produk Baru</a>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><img src="uploads/<?= $row['foto']; ?>" width="60" height="60" alt="Produk"></td>
                    <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>
                        <a href="form.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="proses.php?hapus=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>