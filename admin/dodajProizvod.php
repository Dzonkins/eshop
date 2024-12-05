<?php
include '../povezivanje.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv = $_POST['naziv'];
    $kategorija = $_POST['kategorija'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];
    $filename = $_FILES["filename"]["name"];
    $tempname = $_FILES["filename"]["tmp_name"];
    $folder = "../proizvodi/" . $filename;

    $sql = "INSERT INTO proizvodi (naziv, slika , kategorija, opis, cena) VALUES ('$naziv', '$filename' , '$kategorija', '$opis', '$cena')";

    if ($conn->query($sql) === TRUE) {
        echo "Proizvod uspešno dodat!";
        header("Location: ../admin.php");
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }

    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>&nbsp; Image uploaded successfully!</h3>";
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Proizvod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Dodaj Proizvod</h2>
        <form action="dodajProizvod.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="naziv" class="form-label">Naziv</label>
                <input type="text" class="form-control" id="naziv" name="naziv" required>
            </div>
            <div class="mb-3">
                <label for="slika" class="form-label">Slika</label>
                <input class="form-control" type="file" id="myFile" name="filename" accept=".jpg,.png">
            </div>
            <div class="mb-3">
                <label for="kategorija" class="form-label">Kategorija</label>
                <input type="text" class="form-control" id="kategorija" name="kategorija" required>
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Opis</label>
                <textarea class="form-control" id="opis" name="opis" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="cena" class="form-label">Cena</label>
                <input type="number" class="form-control" id="cena" name="cena" required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Proizvod</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
