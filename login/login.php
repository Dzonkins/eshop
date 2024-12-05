<?php
include '../povezivanje.php';

session_start();
$error_message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_username = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM korisnik WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email_or_username, $email_or_username);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if ($user['password'] === $password) {
            $_SESSION['username'] = $user['username']; 
            $_SESSION['idKorisnik'] = $user['id']; 
            $_SESSION['ulogovan'] = true;
            header("Location: ../index.php");
            exit();
        } else {
            $error_message = "Pogrešno ime ili šifra!";
        }
    } else {
        $error_message = "Pogrešno ime ili šifra!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="slike/ikona.ico">
    <title>Prijava</title>
</head>
<body>
    <section class="vh-100 bg-image">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-4">Prijavite se</h2>

                            <?php if ($error_message): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="">
                                <div class="form-outline mb-4">
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Korisničko ime" required/>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Lozinka" required/>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="btn_container">
                                        <button type="submit" class="btn btn-primary">Prijavi se</button>
                                    </div>
                                </div>

                                <p class="text-center text-muted mt-5 mb-0">
                                    Nemate nalog? <a href="register.php" class="fw-bold text-body"><u>Registrujte se ovde</u></a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
