<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['cart'][$key]);
                
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                
                header("Location: korpa.php?success=removed");
                exit();
            }
        }
    }
}

header("Location: cart.php?error=notfound");
exit();
