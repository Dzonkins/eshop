<?php
include 'povezivanje.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login/loginAdmin.php");
    exit;
}

$sql = "SELECT * FROM proizvodi";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/admin.css">
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
                        <a class="nav-link" href="admin/porudzbine.php">
                            <i class="bi bi-person-circle nav-icon"></i> Porudzbine
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login/logout.php">
                            <i class="bi bi-person-circle nav-icon"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Upravljanje Proizvodima</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Slika</th>
                    <th>Naziv</th>
                    <th>Kategorija</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['slika'] ."</td>
                                <td>" . $row['naziv'] . "</td>
                                <td>" . $row['kategorija'] . "</td>
                                <td>" . $row['opis'] . "</td>
                                <td>" . $row['cena'] . " RSD</td>
                                <td>
                                    <a href='admin/izmeni.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Izmeni</a>
                                    <a href='admin/izbrisi.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Da li ste sigurni da želite da obrišete ovaj proizvod?\")'>Obriši</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nema proizvoda.</td></tr>";
                }
                ?>
            </tbody>    
        </table>
        <div class="text-end">
            <a href="admin/dodajProizvod.php" class="btn btn-success btn-lg">Dodaj Proizvod</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
