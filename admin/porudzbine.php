<?php
include '../povezivanje.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/loginAdmin.php");
    exit;
}

$sql = "SELECT * FROM porudzbine ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Porudžbine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css"> 
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gigatron Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin.php">Proizvodi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Porudžbine</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Kupca</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Email</th>
                    <th>Broj Telefona</th>
                    <th>Država</th>
                    <th>Grad</th>
                    <th>Poštanski Broj</th>
                    <th>Adresa</th>
                    <th>Plaćanje</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['id_kupca'] . "</td>
                                <td>" . $row['ime'] . "</td>
                                <td>" . $row['prezime'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>" . $row['broj_telefona'] . "</td>
                                <td>" . $row['drzava'] . "</td>
                                <td>" . $row['grad'] . "</td>
                                <td>" . $row['postanski_broj'] . "</td>
                                <td>" . $row['adresa'] . "</td>
                                <td>" . $row['placanje'] . "</td>
                                <td> <a href='detalji.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Detalji o porudzbini</a> </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>Nema porudžbina.</td></tr>";
                }
                ?>
            </tbody>    
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
