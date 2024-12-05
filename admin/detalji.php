<?php
include '../povezivanje.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login/loginAdmin.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT pz.id, pz.porudzbina_id, pz.kolicina, pr.naziv 
        FROM proizvodi_iz_porudzbina AS pz
        JOIN proizvodi AS pr ON pz.proizvod_id = pr.id
        WHERE pz.porudzbina_id = $id";

    $upit2 = "SELECT * FROM porudzbine WHERE id = $id";
    $result = $conn->query($sql);
    $rezultat = $conn->query($upit2);

    if ($result->num_rows === 0) {
        echo "Order products not found.";
        exit();
    }

} else {
    echo "No order product ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji porudžbine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalji porudžbine</h2>
        <form method="POST">
        <label for="porudzbina_id" class="form-label">ID Porudžbine</label>
        <input type="text" class="form-control" id="porudzbina_id" name="porudzbina_id" value="<?php echo htmlspecialchars($id); ?>" required disabled>
        <?php while ($red = $rezultat->fetch_assoc()): ?>
                <label for="porudzbina_id" class="form-label">Ime</label>
                <input type="text" class="form-control" id="ime" name="ime" value="<?php echo htmlspecialchars($red['ime']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Prezime</label>
                <input type="text" class="form-control" id="prezime" name="prezime" value="<?php echo htmlspecialchars($red['prezime']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($red['email']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Broj telefona</label>
                <input type="text" class="form-control" id="broj_telefona" name="broj_telefona" value="<?php echo htmlspecialchars($red['broj_telefona']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Država</label>
                <input type="text" class="form-control" id="drzava" name="drzava" value="<?php echo htmlspecialchars($red['drzava']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Grad</label>
                <input type="text" class="form-control" id="grad" name="grad" value="<?php echo htmlspecialchars($red['grad']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Poštanski broj</label>
                <input type="text" class="form-control" id="postanski_broj" name="postanski_broj" value="<?php echo htmlspecialchars($red['postanski_broj']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Adresa</label>
                <input type="text" class="form-control" id="adresa" name="adresa" value="<?php echo htmlspecialchars($red['adresa']); ?>" required disabled>
                <label for="porudzbina_id" class="form-label">Plaćanje</label>
                <input type="text" class="form-control" id="placanje" name="placanje" value="<?php echo htmlspecialchars($red['placanje']); ?>" required disabled>
        <?php endwhile; ?>
        
        <br>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="mb-4 border rounded p-3">
                    <h5>Proizvod: <?php echo htmlspecialchars($row['naziv']); ?></h5>
                    <p><strong>Količina:</strong> <?php echo htmlspecialchars($row['kolicina']); ?></p>
                </div>
            <?php endwhile; ?>
            <a href="porudzbine.php" class="btn btn-primary mb-3">Nazad</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
