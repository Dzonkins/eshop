<?php
include '../povezivanje.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE user='$user' AND pass='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["user"] = $user;
        $_SESSION['loggedin'] = true;
        header("Location: ../admin.php");
    } else {
        echo "Neispravno korisničko ime ili lozinka!";
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
    <title>Prijava</title>
</head>
<body>
    <section class="vh-100 bg-image">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-4">Admin login</h2>

                                <form method="post" action="loginAdmin.php">
                                    <div class="form-outline mb-4">
                                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Korisničko ime" required/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Lozinka" required/>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div class="btn_container">
                                            <button type="submit" class="btn">Prijavi se</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
