<?php
session_start();
include 'povezivanje.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$sql = "SELECT * FROM proizvodi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="shop.css">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gigatron</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="form-inline">
                <input id="search" class="form-control mr-sm-2" type="search" placeholder="Pretraga" aria-label="Search"
                    style="width: 150px; ">
            </form>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="eshop/korpa.php">
                            <img src="slike/korpa.png" width="25px" style="margin-top: 20%;" alt="Korpa"
                                class="nav-icon">
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if ($username): ?>
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                style="margin-top: 4.1%;" data-bs-toggle="dropdown" aria-expanded="false">
                                Zdravo, <?php echo htmlspecialchars($username); ?>!
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item text-danger" href="login/logoutShop.php">Logout</a></li>
                            </ul>
                        <?php else: ?>
                            <a class="nav-link" href="./login/login.php">
                                <i class="bi bi-person-circle nav-icon"></i> Login
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row" id="product-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4'>
                        <div class='card mb-4'>
                            <img src='./proizvodi/" . htmlspecialchars($row['slika']) . "' class='card-img-top' alt='Proizvod'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($row['naziv']) . "</h5>
                                <p class='card-text'>" . htmlspecialchars($row['opis']) . "</p>
                                <p class='card-text'><strong>Cena:</strong> " . htmlspecialchars($row['cena']) . " RSD</p>
                                <div class='btn_container'>
                                    <a href='./eshop/dodajUKorpu.php?id=" . htmlspecialchars($row['id']) . "' class='btn'>Dodaj u korpu</a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>Nema proizvoda dostupnih.</p>";
            }
            ?>
        </div>
    </div>
    <script>
        function searchProducts() {
            const query = document.getElementById('search').value.trim();

            if (query === "") {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "eshop/search.php?query=", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('product-list').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            } else {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "eshop/search.php?query=" + encodeURIComponent(query), true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('product-list').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        }

        document.getElementById('search').addEventListener('input', searchProducts);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>