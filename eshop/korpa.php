<?php
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total = 0;
foreach ($cart as $item) {
    $total += $item['cena'] * $item['quantity'];
}

$shipping_cost = 200; 
$grand_total = $total + $shipping_cost;
$_SESSION['cena'] = $total;
$_SESSION['ukupno'] = $grand_total;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Korpa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="korpa.css">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
</head>

<body>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
        integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <?php if (count($cart) > 0): ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="card border shadow-none mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start border-bottom pb-3">
                                    <div class="me-4">
                                        <img src="../proizvodi/<?php echo htmlspecialchars($item['slika']); ?>" alt="Proizvod"
                                            class="avatar-lg rounded">
                                    </div>
                                    <div class="flex-grow-1 align-self-center overflow-hidden">
                                        <div>
                                            <h5 class="text-truncate font-size-18"><a href="#"
                                                    class="text-dark"><?php echo htmlspecialchars($item['naziv']); ?></a></h5>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <ul class="list-inline mb-0 font-size-16">
                                            <li class="list-inline-item">
                                                <a href="izbaciIzKorpe.php?id=<?php echo $item['id']; ?>"
                                                    class="text-muted px-1">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Cena</p>
                                                <h5 class="mb-0 mt-2"><?php echo htmlspecialchars($item['cena']); ?> RSD</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mt-3">
                                                <p class="text-muted mb-2">Količina</p>
                                                <div class="d-inline-flex">
                                                    <form action="azurirajKolicinu.php" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                        <select name="quantity" class="form-select form-select-sm w-xl"
                                                            onchange="this.form.submit()">
                                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                                <option value="<?php echo $i; ?>" <?php if ($item['quantity'] == $i)
                                                                       echo 'selected'; ?>>
                                                                    <?php echo $i; ?>
                                                                </option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Vaša korpa je prazna.</p>
                <?php endif; ?>

                <div class="row my-4">
                    <div class="col-sm-6">
                        <a href="../index.php" class="btn btn-link text-muted">
                            <i class="mdi mdi-arrow-left me-1"></i> Nastavite kupovinu </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <a href="checkout.php" class="btn btn-success <?php echo ($total <= 0) ? 'disabled' : ''; ?>" <?php echo ($total <= 0) ? 'aria-disabled="true"' : ''; ?>>
                                <i class="mdi mdi-cart-outline me-1"></i> Idi na plaćanje </a>
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
                                            <td class="text-end"><?php echo $total; ?> RSD</td>
                                        </tr>
                                        <tr>
                                            <td>Poštarina: </td>
                                            <td class="text-end"><?php echo $shipping_cost; ?> RSD</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th>Ukupno: </th>
                                            <td class="text-end">
                                                <span class="fw-bold"><?php echo $grand_total; ?> RSD</span>
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
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>