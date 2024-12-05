<?php
session_start();

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = (int)$_POST['quantity'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $id) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$key]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$key]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']);
                }
                
                header("Location: korpa.php?success=updated");
                exit();
            }
        }
    }
}

header("Location: cart.php?error=notfound");
exit();