<?php
session_start();
include '../config/koneksi.php';

$target_dir = "../assets/img/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// ////////////////////////////////////////////////////////////////////////////////////////////////////
// Tambah Produk //////////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['simpan'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga       = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok        = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $id_penjual  = $_SESSION['id'];

    $filename    = $_FILES['gambar']['name'];
    $tmp_name    = $_FILES['gambar']['tmp_name'];
    
    $ekstensi    = pathinfo($filename, PATHINFO_EXTENSION);
    $nama_baru   = time() . "_" . uniqid() . "." . $ekstensi;

    if (move_uploaded_file($tmp_name, $target_dir . $nama_baru)) {
        $query = "INSERT INTO produk (nama_produk, harga, stok, deskripsi, gambar, id_penjual) 
                  VALUES ('$nama_produk', '$harga', '$stok', '$deskripsi', '$nama_baru', '$id_penjual')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar!'); window.location='tambah_produk.php';</script>";
    }
}

// ////////////////////////////////////////////////////////////////////////////////////////////////////
// Update Produk //////////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['update'])) {
    $id          = $_POST['id'];
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga       = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok        = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $id_penjual  = $_SESSION['id'];

    $filename    = $_FILES['gambar']['name'];
    $tmp_name    = $_FILES['gambar']['tmp_name'];

    if ($filename != "") {
        $ambil = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id = '$id'");
        $data  = mysqli_fetch_assoc($ambil);
        if (file_exists($target_dir . $data['gambar'])) {
            unlink($target_dir . $data['gambar']);
        }

        $ekstensi  = pathinfo($filename, PATHINFO_EXTENSION);
        $nama_baru = time() . "_" . uniqid() . "." . $ekstensi;
        move_uploaded_file($tmp_name, $target_dir . $nama_baru);

        $query = "UPDATE produk SET 
                  nama_produk = '$nama_produk', 
                  harga = '$harga', 
                  stok = '$stok', 
                  deskripsi = '$deskripsi', 
                  gambar = '$nama_baru' 
                  WHERE id = '$id' AND id_penjual = '$id_penjual'";
    } else {
        $query = "UPDATE produk SET 
                  nama_produk = '$nama_produk', 
                  harga = '$harga', 
                  stok = '$stok', 
                  deskripsi = '$deskripsi' 
                  WHERE id = '$id' AND id_penjual = '$id_penjual'";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location='produk.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>