<?php

session_start();

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}

$adminUsername = $_SESSION['username'];

$id = $_GET['id'];

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$statement = $connection->prepare('SELECT * FROM category WHERE id = :id');
$statement->execute(['id' => $id]);
$categoryEdit = $statement->fetch(PDO::FETCH_ASSOC);


$deletedDate = $categoryEdit['deleted_at'];

if ($deletedDate === '0000-00-00 00:00:00') {
    $isDeleted = false;
} else {
    $isDeleted = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />
    <title>LibraryTok : Edit Category </title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS STYLE SHEET -->
    <link rel="stylesheet" href="../../CSS/style.css">
    <!-- FONT AWESOME -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-dark">


    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-secondary" href="../../index.php">LibraryTok</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link text-secondary" href="../../index.php">Home</a>
                    <span class="text-secondary nav-item mt-2">Welcome, <?= $adminUsername ?> </span>
                    <a class="nav-link text-secondary" href="../../Register&Login/logout-user.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="card-section" style="background-color: #ccc; height: 90vh;">
        <div class="container-fluid ">

            <h1 class="p-5 text-center">Edit Category</h1>
            <?php

            $message = $_GET['errorMsg'] ?? '';

            echo $message;

            ?>

            <div class="container" style="width: 40%">
                <form action="./editCategoryScript.php" method="POST" id="category-form">
                    <input type="hidden" hidden name="category_id" value="<?= $categoryEdit['id'] ?>">

                    <div class="formGroup">
                        <label for="category_input">Desired category</label>
                        <input type="text" class="form-control" id="category_input" name="category_input" placeholder="Enter desired category" value=" <?= $categoryEdit['category_type'] ?>">
                    </div>

                    <div class="formGroup text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Edit Category</button>
                    </div>

                    <?php if ($isDeleted) : ?>
                        <p class="text-danger text-center m-0">This category is deleted!</p>
                        <div class=" justify-content-center text-center mb-3 align-items-center d-flex flex-row">
                            <label class="form-check-label text-danger mx-2" for="delete-check">To undelete <i class="fa fa-arrow-right"></i></label>
                            <input class="form-check-input text-center me-2" type="checkbox" id="undelete-check" name="undelete-category" value="becomeUndeleted">

                        </div>
                    <?php endif; ?>

                </form>
            </div>
            <hr>
            <div class="group text-center ">
                <a href="./category.php" class="btn btn-primary">Back to Categories</a>
                <a href="../adminDashboard.php" class="btn btn-warning">Back to Dashboard</a>
            </div>


        </div>
    </main>

    <!-- FOOTER -->
    <footer>

        <div class="quote text-center p-2 h6 text-secondary bg-dark">
            <small class="text-end"><cite id="quote" class="mb-3"></cite></small>
            <p style="margin-top: 15px; margin-bottom: 0px;">© 2024 Kiko Stojanov</p>

        </div>


    </footer>

    <script src="./categoryInputs.js"></script>
    <script src="../../fetchQuote.js"></script>

</body>

</html>