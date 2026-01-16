<?php
session_start();
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas_pembeli']);
    $wa = mysqli_real_escape_string($koneksi, $_POST['no_wa']);

    $query_pesanan = "INSERT INTO pesanan (nama_pembeli, kelas_pembeli, no_wa) VALUES ('$nama', '$kelas', '$wa')";
    
    if (mysqli_query($koneksi, $query_pesanan)) {
        $id_pesanan_baru = mysqli_insert_id($koneksi);

        foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
            $res_prod = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id = '$id_produk'");
            $data_prod = mysqli_fetch_assoc($res_prod);
            $harga = $data_prod['harga'];

            $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga) 
                            VALUES ('$id_pesanan_baru', '$id_produk', '$jumlah', '$harga')";
            mysqli_query($koneksi, $query_detail);
            
            mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jumlah WHERE id = '$id_produk'");
        }

        unset($_SESSION['cart']);

        echo "<script>
                alert('Pesanan Berhasil Dibuat!');
                window.location='index.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}