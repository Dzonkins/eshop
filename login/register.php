<?php
include '../povezivanje.php';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $conn->real_escape_string($_POST['ime']);
    $prezime = $conn->real_escape_string($_POST['prezime']);
    $broj_telefona = $conn->real_escape_string($_POST['broj_telefona']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $checkQuery = "SELECT * FROM korisnik WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "Email or Username already exists!";
    } else {
        $sql = "INSERT INTO korisnik (email, ime, prezime, broj_telefona, username, password) 
                VALUES ('$email', '$ime', '$prezime', '$broj_telefona', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Uspješna registracija! Bićete preusmereni na stranicu za prijavu.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
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
    <title>Registracija</title>
    <script>
        function redirectAfterDelay() {
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000); 
        }
    </script>
</head>
<body>
    <section class="vh-100 bg-image">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-4">Registrujte se</h2>

                            <?php if ($successMessage): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $successMessage; ?>
                                </div>
                                <script>redirectAfterDelay();</script>
                            <?php endif; ?>

                            <form method="POST" action="register.php">
                                <div class="form-outline mb-4">
                                    <input type="text" name="ime" class="form-control form-control-lg" placeholder="Ime" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="text" name="prezime" class="form-control form-control-lg" placeholder="Prezime" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="number" name="broj_telefona" class="form-control form-control-lg" placeholder="Broj-Telefona" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="E-mail" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Korisničko ime" required/>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Lozinka" required/>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Registruj se</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
