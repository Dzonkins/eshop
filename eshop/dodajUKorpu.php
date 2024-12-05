<?php
session_start();
include '../povezivanje.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "SELECT id, naziv, cena, slika FROM proizvodi WHERE id = $id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();

    if ($product) {
        $item = [
            'id' => $product['id'],
            'naziv' => $product['naziv'],
            'cena' => $product['cena'],
            'slika' => $product['slika'],
            'quantity' => 1
        ];

        $cart = $_SESSION['cart'] ?? [];

        foreach ($cart as &$existing_item) {
            if ($existing_item['id'] == $item['id']) {
                if ($existing_item['quantity'] < 10) {
                    $existing_item['quantity']++;
                }
                $item_found = true;
                break;

            }
        }



        if(!$item_found){
            $cart[] = $item;
            $brojStvari++;
        }
        $_SESSION['cart'] = $cart;

        header("Location: ../index.php");
        exit();
    }
}

header("Location: ../index.php");
exit();
