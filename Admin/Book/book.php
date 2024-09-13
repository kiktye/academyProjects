<?php

session_start();
if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}

$adminUsername = $_SESSION['username'];

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$statement = $connection->prepare('SELECT
      book.id,
      book.book_title,
      book.book_publish_year,
      book.book_pages,
      book.book_image,
      author.first_name AS author_first_name,
      author.last_name AS author_last_name,
      category.category_type
    FROM
      book
    JOIN
      author ON book.author_id = author.id
    JOIN
      category ON book.category_id = category.id');
$statement->execute();
$books = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />
    <title>LibraryTok : Books</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
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
        <div class="container-fluid text-center">

            <h1 class="p-5">Books</h1>
            <?php $message = $_GET['msg'] ?? ''; ?>
            <span class="text-danger"><?= $message ?></span>

            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Book Publish Year</th>
                            <th scope="col">Book Pages</th>
                            <th scope="col">Book Thumbnail</th>
                            <th scope="col">Book Author</th>
                            <th scope="col">Book Category</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book) : ?>
                            <tr>
                                <th scope="row"><?= $book['id'] ?></th>
                                <td><?= htmlspecialchars($book['book_title']) ?></td>
                                <td><?= htmlspecialchars($book['book_publish_year']) ?></td>
                                <td><?= htmlspecialchars($book['book_pages']) ?></td>
                                <td><?= htmlspecialchars($book['book_image']) ?></td>
                                <td><?= htmlspecialchars($book['author_first_name'] . ' ' . $book['author_last_name']) ?></td>
                                <td><?= htmlspecialchars($book['category_type']) ?></td>
                                <td class="d-flex justify-content-center">
                                    <form action="./adminDeleteBook.php" method="POST" class="p-2 delete-form" data-book-id="<?= $book['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                        <input type="hidden" value="<?= $book['book_title']; ?>" name="book_title">
                                        <button type="submit" class="btn btn-danger mx-1 delete-button">Delete</button>
                                    </form>
                                    <a href="./adminEditBook.php?id=<?= $book['id'] ?>" class="btn btn-warning mx-1">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="./add-book.php" class="btn btn-primary mb-5">Add book</a>
            <a href="../adminDashboard.php" class="btn btn-warning mb-5">Back to Dashboard</a>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="quote text-center p-2 h6 text-secondary bg-dark">
            <small class="text-end"><cite id="quote" class="mb-3"></cite></small>
            <p style="margin-top: 15px; margin-bottom: 0px;">© 2024 Kiko Stojanov</p>

        </div>
    </footer>

    <script src="../../confirmDelete.js"></script>
    <script src="../../fetchQuote.js"></script>

</body>

</html>