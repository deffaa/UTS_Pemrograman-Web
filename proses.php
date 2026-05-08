<?php
include 'koneksi.php';

// Fitur Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Ambil info foto untuk dihapus dari folder
    $query_foto = mysqli_query($conn, "SELECT foto FROM produk WHERE id = $id");
    $data_foto = mysqli_fetch_assoc($query_foto);
    if (file_exists("uploads/" . $data_foto['foto'])) {
        unlink("uploads/" . $data_foto['foto']);
    }

    $delete = mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
    if ($delete) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    }
}

// Fitur Simpan & Update
if (isset($_POST['simpan'])) {
    $id          = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    
    $foto_name = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];

    if ($id == "") {
        // Logika Tambah Baru
        $ext = pathinfo($foto_name, PATHINFO_EXTENSION);
        $new_name = time() . "_" . uniqid() . "." . $ext;
        
        move_uploaded_file($tmp_name, "uploads/" . $new_name);
        
        $query = "INSERT INTO produk (nama_produk, harga, stok, foto) VALUES ('$nama_produk', '$harga', '$stok', '$new_name')";
        $msg = "Data berhasil ditambahkan!";
    } else {
        // Logika Update
        if ($foto_name != "") {
            // Jika ganti foto
            $ext = pathinfo($foto_name, PATHINFO_EXTENSION);
            $new_name = time() . "_" . uniqid() . "." . $ext;
            
            // Hapus foto lama
            $old = mysqli_query($conn, "SELECT foto FROM produk WHERE id = $id");
            $old_data = mysqli_fetch_assoc($old);
            if (file_exists("uploads/" . $old_data['foto'])) unlink("uploads/" . $old_data['foto']);
            
            move_uploaded_file($tmp_name, "uploads/" . $new_name);
            $query = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', foto='$new_name' WHERE id=$id";
        } else {
            // Jika tidak ganti foto
            $query = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok' WHERE id=$id";
        }
        $msg = "Data berhasil diperbarui!";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('$msg'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>