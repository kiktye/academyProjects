<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />

    <title>LibraryTok : Login</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS STYLE SHEET -->
    <link rel="stylesheet" href="../CSS/style.css">
    <!-- FONT AWESOME -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-dark">


    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-secondary" href="../index.php">LibraryTok</a>
            <button class="navbar-toggler bg-secondary
            " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-secondary" href="../index.php">Home</a>
                    <a class="nav-link text-secondary" href="./login-user.php" hidden>Login</a>
                    <a class="nav-link text-secondary" href="./register-user.php">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- LOGIN SECTION -->

    <main class="login-section" style="background-color: #ccc; height: 90vh;">
        <div class="container-fluid">
            <div class="container opacity-container mb-5" style="width: 40%">

                <form action="./loginScript.php" method="POST">
                    <h2 class="text-center">Login</h2>

                    <?php

                    $errorMsg = $_GET['errorMsg'] ?? '';

                    ?>

                    <span class="text-danger text-center">
                        <?= $errorMsg ?>
                    </span>

                    <div class="formGroup">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                        <div class="error-message" id="username-error"></div>
                    </div>

                    <!-- <div class="formGroup">
                        <label for="email">Your Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
                        <div class="error-message" id="email-error"></div>
                    </div> -->

                    <div class="formGroup">
                        <label for="password">Your password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        <div class="error-message" id="password-error"></div>
                    </div>

                    <div class="formGroup text-center">
                        <button id="login-btn" type="submit" class="btn btn-success">Log in!</button>

                    </div>

                </form>
                <div class="formGroup text-center mt-5">
                    <h6>Not a user?</h6>
                    <a href="./register-user.php" class="btn btn-primary">Register now!</a>

                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->

        <div class="quote text-center p-2 h6 text-secondary">
            <small class="text-end"><cite id="quote" class="mb-3"></cite></small>
            <p style="margin-top: 15px; margin-bottom: 0px;">© 2024 Kiko Stojanov</p>
        </div>
    

    <script src="../fetchQuote.js"></script>
</body>

</html>