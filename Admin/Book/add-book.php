<?php

session_start();

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}

$adminUsername = $_SESSION['username'];

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$statement = $connection->prepare('SELECT * FROM author WHERE deleted_at IS NULL');
$statement->execute();
$authors = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $connection->prepare('SELECT * FROM category WHERE deleted_at IS NULL');
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />
    <title>LibraryTok : Add Book</title>

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
        <div class="container-fluid">

            <h1 class="p-5 text-center">Add Book</h1>
            <?php

            $message = $_GET['errorMsg'] ?? '';

            echo $message;

            ?>

            <div class="container" style="width: 40%">
                <form action="./add-bookScript.php" method="POST" id="book-form">

                    <div class="formGroup">
                        <label for="book_title">Book title</label>
                        <input type="text" class="form-control" id="book_title" name="book_title" placeholder="Enter book title">
                    </div>

                    <div class="formGroup">
                        <label for="book_publish_year">Book publish year</label>
                        <input type="text" class="form-control" id="book_publish_year" name="book_publish_year" placeholder="Enter book's publish year">

                    </div>

                    <div class="formGroup">
                        <label for="book_pages">Book number of pages</label>
                        <input type="text" class="form-control" id="book_pages" name="book_pages" placeholder="Enter book's number of pages">
                    </div>

                    <div class="formGroup">
                        <label for="book_image">Book thumbnail</label>
                        <input type="text" class="form-control" id="book_image" name="book_image" placeholder="Enter book's thumbnail">
                    </div>

                    <div class="formGroup">
                        <label for="book_author">Book Author</label>
                        <select class="form-select form-select" id="book_author" name="book_author">
                            <option value="" hidden>Select an author</option>
                            <?php foreach ($authors as $author) : ?>

                                <option value="<?= $author['id'] ?>"><?= $author['first_name'] . " " . $author['last_name'] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="formGroup">
                        <label for="book_category">Book Category</label>
                        <select class="form-select form-select" id="book_category" name="book_category">
                            <option value="" hidden>Select a category</option>
                            <?php foreach ($categories as $category) : ?>

                                <option value="<?= $category['id'] ?>"><?= $category['category_type'] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="formGroup text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Add Book</button>
                    </div>

                </form>
            </div>
            <hr>
            <div class="group text-center mb-5">
                <a href="./book.php" class="btn btn-primary">Back to Books</a>
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

    <script src="./authorInputs.js"></script>
    <script src="../../fetchQuote.js"></script>
</body>

</html>