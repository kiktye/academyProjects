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

$statement = $connection->prepare('SELECT * FROM author');
$statement->execute();
$authors = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />
    <title>LibraryTok : Authors </title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
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

    <main class="card-section" style="background-color: #ccc;  ">
        <div class="container-fluid text-center">
            <h1 class="p-5">Authors</h1>
            <?php
            $message = $_GET['msg'] ?? '';
            ?>
            <span class="text-danger"><?= $message ?></span>

            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Short Biography</th>
                            <th scope="col">Deleted at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author) : ?>
                            <tr>
                                <th scope="row"><?= $author['id'] ?></th>
                                <td><?= htmlspecialchars($author['first_name']) ?></td>
                                <td><?= htmlspecialchars($author['last_name']) ?></td>
                                <td><?= htmlspecialchars($author['short_bio']) ?></td>
                                <td><?= htmlspecialchars($author['deleted_at']) ?></td>
                                <td class="d-flex justify-content-center">
                                    <form action="./adminDeleteAuthor.php" method="POST" class="p-2 delete-form" data-author-id="<?= $author['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="author_id" value="<?= $author['id'] ?>">
                                        <button type="submit" class="btn btn-danger mx-1 delete-button">Delete</button>
                                    </form>
                                    <a href="./adminEditAuthor.php?id=<?= $author['id'] ?>" class="btn btn-warning mx-1">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="./add-author.php" class="btn btn-primary mb-5">Add author</a>
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