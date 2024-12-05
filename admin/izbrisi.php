<?php
include '../povezivanje.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM proizvodi WHERE id = $id";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath =  "../proizvodi/". $row['slika'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    
            
    }
    $sql = "DELETE FROM proizvodi WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }


    $conn->close();
} else {
    header("Location: admin.php");
    exit();
}
