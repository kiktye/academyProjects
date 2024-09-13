<?php

session_start();
require_once('./Database/Connection.php');

use Database\Connection as Connection;

if (isset($_SESSION['username'])) {
    $loggedInUser = $_SESSION['username'];
} else {
    $loggedInUser = "";
}

if (empty($loggedInUser)) {
    $loggedIn = false;
    session_destroy();
} else {
    $loggedIn = true;
}

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$categoryFilter = $_GET['category'] ?? "";

if (empty($categoryFilter)) {
    $statement = $connection->prepare('SELECT
        book.id AS book_id,
        book.book_title,
        book.book_publish_year,
        book.book_pages,
        book.book_image,
        author.id AS author_id,
        author.first_name AS author_first_name,
        author.last_name AS author_last_name,
        author.deleted_at AS author_deleted_at,
        category.id AS category_id,
        category.category_type,
        category.deleted_at AS category_deleted_at
      FROM
        book
      JOIN
        author ON book.author_id = author.id
      JOIN
        category ON book.category_id = category.id');
    $statement->execute();

    $books = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $categoryFilter = explode(",", $categoryFilter);
    $categoryFilter = array_map('intval', $categoryFilter);
    $categoryFilter = implode(",", $categoryFilter);

    $statement = $connection->prepare("SELECT
        book.id AS book_id,
        book.book_title,
        book.book_publish_year,
        book.book_pages,
        book.book_image,
        author.id AS author_id,
        author.first_name AS author_first_name,
        author.last_name AS author_last_name,
        author.deleted_at AS author_deleted_at,
        category.id AS category_id,
        category.category_type,
        category.deleted_at AS category_deleted_at
      FROM
        book
      JOIN
        author ON book.author_id = author.id
      JOIN
        category ON book.category_id = category.id
      WHERE
        book.category_id IN ($categoryFilter)");

    try {
        $statement->execute();
    } catch (PDOException  $e) {
        echo "<h1>No such category!</h1>";
        echo '<button class="btn btn-primary w-25"><a href="./index.php">Back</a></button>';
        die();
    }

    $books = $statement->fetchAll(PDO::FETCH_ASSOC);
}

$statement = $connection->prepare('SELECT * FROM category WHERE deleted_at is NULL');
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

    <title>LibraryTok : Catalog</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS STYLE SHEET -->
    <link rel="stylesheet" href="./CSS/style.css">
    <!-- FONT AWESOME -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: calc(.25rem - 1px);
            border-top-right-radius: calc(.25rem - 1px);
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-dark">
    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-secondary" href="./index.php">LibraryTok</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <?php if ($loggedIn === FALSE) : ?>
                        <a class="nav-link text-secondary" href="./Register&Login/login-user.php">Login</a>
                        <a class="nav-link text-secondary" href="./Register&Login/register-user.php">Register</a>
                    <?php else : ?>
                        <span class="text-secondary nav-item mt-2">Welcome, <?= $loggedInUser ?> </span>
                        <?php if ($_SESSION['user_type'] === 'admin') : ?>
                            <a class="nav-link text-secondary" href="./Admin/adminDashboard.php">Admin Dashboard</a>
                        <?php endif; ?>
                        <a class="nav-link text-secondary" href="./Register&Login/logout-user.php">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- CARD SECTION -->
    <main class="card-section py-4" style="background-color: #ccc;">
        <div class="container" style="background-color: #ccc;">
            <div class="container opacity-container mb-5">
                <h3 class="text-center text-uppercase">Books </h3>

                <form action="" method="GET" class="mb-3 d-flex flex-wrap align-items-center" id="category-form">
                    <div class="d-flex flex-wrap flex-grow-1">
                        <?php foreach ($categories as $category) : ?>
                            <div class="form-check me-3 mb-2">
                                <input class="form-check-input" id="check_<?= $category['id'] ?>" type="checkbox" name="category[]" value="<?= $category['id'] ?>" />
                                <label class="form-check-label" for="check_<?= $category['id'] ?>"><?= $category['category_type'] ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="ms-auto">
                        <button type="submit" class="btn btn-outline-dark btn-sm">Filter</button>
                    </div>
                </form>

                <div class="row g-3">
                    <?php foreach ($books as $book) : ?>
                        <?php
                        $bookId = $book['book_id'];
                        $categoryId = $book['category_id'];
                        $bookImg = $book['book_image'];
                        $bookTitle = $book['book_title'];
                        $authorName = $book['author_first_name'] . " " . $book['author_last_name'];
                        $isCategoryDeleted = $book['category_deleted_at'];
                        $categoryType = $book['category_type'];
                        ?>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100" style="cursor: default;">
                                <img src="<?= $bookImg ?>" class="card-img-top" alt="Book Image">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $bookTitle ?></h5>
                                    <p class="card-text m-0">Author: <?= $authorName ?></p>
                                    <p class="card-text">Category: <?= $categoryType ?></p>
                                    <a href="./bookAbout.php?bookId=<?= $bookId; ?>" class="btn btn-primary mt-auto">About book</a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
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

    <script src="./fetchQuote.js"></script>
    <script>
        document.getElementById("category-form").addEventListener("submit", function(e) {
            e.preventDefault();

            var check = Array.from(this.querySelectorAll('input[name="category[]"]:checked'));
            var values = check.map(box => box.value).join(",");
            var baseUrl = window.location.href.split("?")[0];
            window.location.href = baseUrl + "?category=" + values;
        });
    </script>
</body>

</html>