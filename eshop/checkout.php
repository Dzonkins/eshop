<?php
include '../povezivanje.php';

session_start();

if (!isset($_SESSION['ulogovan']) || $_SESSION['ulogovan'] !== true) {
    header("Location: ../login/loginKorpa.php");
    exit;
}

$idKorisnika = $_SESSION['idKorisnik'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $broj = $_POST['broj_telefona'];
    $drzava = $_POST['drzava'];
    $grad = $_POST['grad'];
    $postanski_broj = $_POST['postanski_broj'];
    $adresa = $_POST['adresa'];
    $placanje = $_POST['placanje'];
    $korpa = $_SESSION['cart'];

    $dodavanje = "INSERT INTO `porudzbine` (`id_kupca`, `ime`, `prezime`, `email`, `broj_telefona`, `drzava`, `grad`, `postanski_broj`, `adresa`, `placanje`) 
                  VALUES ('$idKorisnika', '$ime', '$prezime', '$email', '$broj', '$drzava', '$grad', '$postanski_broj', '$adresa', '$placanje')";

    if ($conn->query($dodavanje) === TRUE) {
        $porudzbina_id = $conn->insert_id;

        foreach ($korpa as $item) {
            $proizvod_id = $item['id'];
            $kolicina = $item['quantity'];
    
            $dodavanjeProizvoda = "INSERT INTO proizvodi_iz_porudzbina (porudzbina_id, proizvod_id, kolicina) 
                                   VALUES ('$porudzbina_id', '$proizvod_id', '$kolicina')";
    
            if (!$conn->query($dodavanjeProizvoda)) {
                echo "Error: " . $dodavanjeProizvoda . "<br>" . $conn->error;
            }

            unset($_SESSION['cart']);
        }
        echo '<div class="alert alert-success" role="alert">Uspešno ste poručili proizvode</div>';
        echo '<script>
        setTimeout(function() {
            window.location.href = "../index.php";
        }, 3000); // 3000 milliseconds = 3 seconds
        </script>';
    } else {
        echo "Error: " . $dodavanje . "<br>" . $conn->error;
    }
}

$sql = "SELECT email, ime, prezime, broj_telefona FROM korisnik WHERE id='$idKorisnika'";
$result = $conn->query($sql);
$userData = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kupovina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>

<body>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
        integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <div class="container">
        <form method="post" action="">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Podaci o primaocu</h5>
                                            <div class="mb-3">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-name">Ime</label>
                                                                    <input type="text" name="ime" class="form-control"
                                                                        placeholder="Unesite ime"
                                                                        value="<?php echo htmlspecialchars($userData['ime']); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="billing-name">Prezime</label>
                                                                    <input type="text" name="prezime" class="form-control"
                                                                        placeholder="Unesite prezime"
                                                                        value="<?php echo htmlspecialchars($userData['prezime']); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="billing-email-address">Email adresa</label>
                                                                    <input type="email" name="email" class="form-control"
                                                                        placeholder="Unesite email"
                                                                        value="<?php echo htmlspecialchars($userData['email']); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-phone">Broj
                                                                        telefona</label>
                                                                    <input type="number" name="broj_telefona"
                                                                        class="form-control"
                                                                        placeholder="Unesite broj telefona"
                                                                        value="<?php echo htmlspecialchars($userData['broj_telefona']); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="billing-address">Adresa</label>
                                                            <input style="background-color: white;" name="adresa" class="form-control"
                                                                placeholder="Unesite adresu">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label">Država</label>
                                                                    <select name="drzava" class="form-control form-select" title="Država">
                                                                        <option value="0">Izaberite državu</option>
                                                                        <option value="Srbija">Srbija</option>
                                                                        <option value="Bosna i Hercegovina">Bosna i Hercegovina</option>
                                                                        <option value="Bugarska">Bugarska</option>
                                                                        <option value="Rumunija">Rumunija</option>
                                                                        <option value="Hrvatska">Hrvatska</option>
                                                                        <option value="Crna Gora">Crna Gora</option>
                                                                        <option value="Mađarska">Mađarska</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label"
                                                                        for="billing-city">Grad</label>
                                                                    <input type="text" name="grad" class="form-control"
                                                                        placeholder="Unesite ime grada">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-0">
                                                                    <label class="form-label" for="zip-code">Poštanski
                                                                        broj</label>
                                                                    <input type="number" name="postanski_broj"
                                                                        class="form-control"
                                                                        placeholder="Unesite poštanski broj">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Plaćanje</h5>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="placanje" value="kartica" id="pay-methodoption1"
                                                                class="card-radio-input" disabled>
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bx-credit-card d-block h2 mb-3"></i>
                                                                Kartica
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="placanje" value="pouzece" id="pay-methodoption3"
                                                                class="card-radio-input" checked>
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bx-money d-block h2 mb-3"></i>
                                                                <span>Pouzećem</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col">
                            <a href="korpa.php" class="btn btn-link text-muted">
                                <i class="mdi mdi-arrow-left me-1"></i> Nastavi kupovinu </a>
                        </div>
                    
                        <div class="col">
                            <div class="text-end mt-2 mt-sm-0">
                                <button type="submit" class="btn btn-success">Nastavi dalje</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="mt-5 mt-lg-0">
                        <div class="card border shadow-none">
                            <div class="card-header bg-transparent border-bottom py-3 px-4">
                                <h5 class="font-size-16 mb-0">Narudžbina</h5>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                        <tr>
                                                <td>Cena proizvoda: </td>
                                                <td class="text-end"><?php echo htmlspecialchars($_SESSION['cena']); ?> RSD</td>
                                            </tr>
                                            <tr>
                                                <td>Poštarina: </td>
                                                <td class="text-end">200 RSD</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Ukupno: </th>
                                                <td class="text-end">
                                                    <span class="fw-bold"><?php echo htmlspecialchars($_SESSION['ukupno']); ?> RSD</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>