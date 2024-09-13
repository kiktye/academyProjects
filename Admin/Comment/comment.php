<?php

require_once(__DIR__ . '../../../Database/Connection.php');

use Database\Connection as Connection;

session_start();
if (($_SESSION['user_type'] !== 'admin')) {
    header("Location: ../index.php");
    die();
}

$adminUsername = $_SESSION['username'];

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$statement = $connection->prepare("SELECT
      comments.id,
      comments.text,
      comments.user_id AS comment_user_id,
      comments.book_id AS comment_book_id,
      comments.admin_verified,
      comments.in_queue,
      registered_users.username,
      book.book_title
    FROM
      comments
    JOIN
      book ON comments.book_id = book.id
    JOIN
      registered_users ON comments.user_id = registered_users.id
    ORDER BY
      comments.id");
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />
    <title>LibraryTok : Comments </title>

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

    <main class="card-section bg-secondary">
        <div class="container-fluid background-main text-center">
            <h1 class="p-5">Book Comments</h1>
            <?php
            $message = $_GET['msg'] ?? '';
            ?>
            <span class="text-danger"><?= $message ?></span>

            <?php $counter = 1; ?>

            <h5>Queued Comments</h5>
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Text</th>
                            <th scope="col">User</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) : $status = $comment['admin_verified'];
                            $inQueue = $comment['in_queue']; ?>
                            <?php if (!$status && $inQueue) : ?>
                                <tr>
                                    <th scope="row"><?php echo $counter;
                                                    $counter++; ?></th>
                                    <td><?= $comment['text']; ?></td>
                                    <td><?= $comment['username']; ?></td>
                                    <td><?= $comment['book_title']; ?></td>
                                    <td class="text-warning"><?php if ($status) {
                                                                    echo 'Approved';
                                                                } else {
                                                                    echo 'In queue';
                                                                } ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <form action="./adminApproveComment.php" method="POST" class="mb-2 d-flex justify-content-center">
                                                <input type="hidden" value="<?= $comment['comment_user_id']; ?>" name="user_id">
                                                <input type="hidden" value="<?= $comment['comment_book_id']; ?>" name="book_id">
                                                <button class="btn btn-success w-75">Approve</button>
                                            </form>
                                            <form action="./adminRejectComment.php" method="POST" class="d-flex justify-content-center" onsubmit="return confirmDelete(event);">
                                                <input type="hidden" value="<?= $comment['comment_user_id']; ?>" name="user_id">
                                                <input type="hidden" value="<?= $comment['comment_book_id']; ?>" name="book_id">
                                                <button class="btn btn-danger w-75">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr>

            <h5>Approved Comments by Admin</h5>
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Text</th>
                            <th scope="col">User</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) : $status = $comment['admin_verified'];
                            $inQueue = $comment['in_queue']; ?>
                            <?php if ($status && !$inQueue) : ?>
                                <tr>
                                    <th scope="row"><?php echo $counter;
                                                    $counter++; ?></th>
                                    <td><?= $comment['text']; ?></td>
                                    <td><?= $comment['username']; ?></td>
                                    <td><?= $comment['book_title']; ?></td>
                                    <td class="text-success"><?php if ($status) {
                                                                    echo 'Approved';
                                                                } else {
                                                                    echo 'Not approved';
                                                                } ?></td>
                                    <td>
                                        <form action="./adminRejectComment.php" method="POST" class="d-flex justify-content-center" onsubmit="return confirmDelete(event);">
                                            <input type="hidden" value="<?= $comment['comment_user_id']; ?>" name="user_id">
                                            <input type="hidden" value="<?= $comment['comment_book_id']; ?>" name="book_id">
                                            <button class="btn btn-danger w-75">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr>
            <?php $counter = 1; ?>

            <h5>Rejected Comments by Admin</h5>
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Text</th>
                            <th scope="col">User</th>
                            <th scope="col">Book Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment) : $status = $comment['admin_verified'];
                            $inQueue = $comment['in_queue']; ?>
                            <?php if (!$status && !$inQueue) : ?>
                                <tr>
                                    <th scope="row"><?php echo $counter;
                                                    $counter++; ?></th>
                                    <td><?= $comment['text']; ?></td>
                                    <td><?= $comment['username']; ?></td>
                                    <td><?= $comment['book_title']; ?></td>
                                    <td class="text-danger"><?php if ($status) {
                                                                echo 'Approved';
                                                            } else {
                                                                echo 'Not approved';
                                                            } ?></td>
                                    <td>
                                        <form action="./adminApproveComment.php" method="POST" class="d-flex justify-content-center">
                                            <input type="hidden" value="<?= $comment['comment_user_id']; ?>" name="user_id">
                                            <input type="hidden" value="<?= $comment['comment_book_id']; ?>" name="book_id">
                                            <button class="btn btn-success w-75">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="../adminDashboard.php" class="btn btn-warning" style="margin-bottom: 250px">Back to Dashboard</a>
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