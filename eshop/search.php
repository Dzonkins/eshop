<?php
include '../povezivanje.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query === '') {
    $sql = "SELECT * FROM proizvodi";
} else {
    $sql = "SELECT * FROM proizvodi WHERE naziv LIKE ? OR opis LIKE ?";
}

$stmt = $conn->prepare($sql);

if ($query !== '') {
    $likeQuery = '%' . $query . '%';
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();

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
    echo "<p>Nema rezultata za pretragu.</p>";
}

$stmt->close();
$conn->close();
