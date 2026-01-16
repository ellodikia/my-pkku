<?php
session_start();

if (isset($_GET['id']) && isset($_GET['act'])) {
    $id = $_GET['id'];
    $act = $_GET['act'];

    if ($act == "plus") {
        $_SESSION['cart'][$id] += 1;
    } elseif ($act == "min") {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id] -= 1;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    } elseif ($act == "del") {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit;
}