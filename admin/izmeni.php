<?php
include '../povezivanje.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login/loginAdmin.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM proizvodi WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "No product ID specified.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naziv = $_POST['naziv'];
    $kategorija = $_POST['kategorija'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];


    
    if (isset($_FILES['slika']) && $_FILES['slika']['error'] == 0) {
        $filename = $_FILES["slika"]["name"];
        $tempname = $_FILES["slika"]["tmp_name"];
        $folder = "../proizvodi/" . $filename;

        if (!empty($product['slika'])) {
            $oldImagePath = "../proizvodi/" . $product['slika'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        if (move_uploaded_file($tempname, $folder)) {
            $slika = $filename;
        } else {
            echo "<h3>&nbsp; Failed to upload image!</h3>";
            exit();
        }
    }

    if ($_FILES ['slika']['error'] == 4) {
        $update_sql = "UPDATE proizvodi SET naziv='$naziv', kategorija='$kategorija', opis='$opis', cena='$cena' WHERE id=$id";
    } else {
        $update_sql = "UPDATE proizvodi SET naziv='$naziv', slika='$slika', kategorija='$kategorija', opis='$opis', cena='$cena' WHERE id=$id";
    }

    if ($conn->query($update_sql) === TRUE) {
        header(header: "Location: ../admin.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni proizvod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>
<body>
    <div class="container mt-5">
        <h2>Izmeni Proizvod</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="naziv" class="form-label">Naziv</label>
                <input type="text" class="form-control" id="naziv" name="naziv" value="<?php echo htmlspecialchars($product['naziv']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="slika" class="form-label">Slika</label>
                <input class="form-control" type="file" id="slika" name="slika" accept=".jpg,.png">
                <small>Trenutna slika:</small><br>
                <img src='../proizvodi/<?php echo htmlspecialchars($product['slika']); ?>' alt="Current Image" style="width: 100px; height: auto;"/>
            </div>
            <div class="mb-3">
                <label for="kategorija" class="form-label">Kategorija</label>
                <input type="text" class="form-control" id="kategorija" name="kategorija" value="<?php echo htmlspecialchars($product['kategorija']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Opis</label>
                <textarea class="form-control" id="opis" name="opis" required><?php echo htmlspecialchars($product['opis']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="cena" class="form-label">Cena</label>
                <input type="text" class="form-control" id="cena" name="cena" value="<?php echo htmlspecialchars($product['cena']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Sačuvaj</button>
            <a href="../admin.php" class="btn btn-secondary">Odbaci</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>