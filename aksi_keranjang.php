<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_produk'];
    $jumlah = (int)$_POST['jumlah'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $jumlah;
    } else {
        $_SESSION['cart'][$id] = $jumlah;
    }

    $response = [
        'status' => 'success',
        'total_item' => array_sum($_SESSION['cart'])
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}