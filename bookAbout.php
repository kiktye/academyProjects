<?php

session_start();
require_once('./Database/Connection.php');

use Database\Connection as Connection;

// User Type Logged In
if (isset($_SESSION['username'])) {
    $userUsername = $_SESSION['username'];
    $userId = $_SESSION['user_id'];
} else {
    $userUsername = "";
    $userId = "";
}

if (empty($userUsername) && empty($userId)) {
    $loggedIn = false;
    session_destroy();
} else {
    $loggedIn = true;
}

if ($loggedIn) {
    $print = "DO";
} else {
    $print = "DONT";
}

if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];

    if (empty($bookId)) {
        echo "<h1>No books found!</h1>";
        echo '<button class="btn btn-primary w-25"><a href="./index.php">Back</a></button>';
        die();
    }
}

$connectionObj = new Connection();
$connection = $connectionObj->getConnection();

$statement = $connection->prepare('SELECT
book.id AS book_id,
book.book_title,
book.book_publish_year,
book.book_pages,
book.book_image,
author.id AS author_id,
author.first_name AS author_first_name,
author.last_name AS author_last_name,
category.id AS category_id,
category.category_type

FROM book
JOIN author ON book.author_id = author.id
JOIN category ON book.category_id = category.id
WHERE book.id = :id');
$statement->bindParam(':id', $bookId, PDO::PARAM_INT);
$statement->execute();

$book = $statement->fetch(PDO::FETCH_ASSOC);

if (empty($book)) {
    echo "<h1>Book not registered!</h1>";
    echo '<a href="./index.php">Go Back</a>';
    die();
}


$statement = $connection->prepare("SELECT * FROM comments 
JOIN registered_users ON comments.user_id = registered_users.id 
WHERE book_id = :book_id 
AND (admin_verified = 1 OR user_id = :user_id)");
$statement->bindParam('book_id', $bookId, PDO::PARAM_INT);
$statement->bindParam('user_id', $userId, PDO::PARAM_INT);
$statement->execute();

$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

// var_dump($comments);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="LibraryTok is a platform(project) that should offer an online platform where users will be able to leave private and public comments about the books they are reading and to be able to return to them at any time. " />
    <meta name="author" content="Kiko Stojanov" />

    <title>LibraryTok | Book : <?= $book['book_title'] ?></title>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .card-img-top {
            width: 100%;
            height: 500px;
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
                        <span class="text-secondary nav-item mt-2">Welcome, <?= $userUsername ?> </span>
                        <?php if ($_SESSION['user_type'] === 'admin') : ?>
                            <a class="nav-link text-secondary" href="./Admin/adminDashboard.php">Admin Dashboard</a>
                        <?php endif; ?>
                        <a class="nav-link text-secondary" href="./Register&Login/logout-user.php">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- BOOK SECTION -->

    <main class="card-section">
        <div class="container-fluid" style="background-color: #ccc;">

            <div class="container opacity-container">

                <h3 class="text-center mb-5 text-uppercase">Book - <?= $book['book_title'] ?></h3>

                <div class="cards d-flex justify-content-center flex-wrap">
                    <div class="card mx-3 mb-3" style="width: 25rem; cursor: default;">
                        <img src="<?= $book['book_image'] ?>" class="card-img-top" alt="Book Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['book_title'] ?></h5>
                            <p class="card-text m-0">Author: <?= $book['author_first_name'] . $book['author_last_name'] ?></p>
                            <p class="card-text m-0">Book Publish Year: <?= $book['book_publish_year'] ?></p>
                            <p class="card-text m-0">Book Number of Pages: <?= $book['book_pages'] ?></p>
                            <p class="card-text">Book Category: <?= $book['category_type'] ?></p>
                        </div>
                    </div>
                </div>
                <a href="./index.php" class="btn btn-warning mb-5">Back to catalog</a>

                <?php if ($loggedIn) : ?>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <button id="add-note" class="btn w-100 font-color secondary-bg-color shadow border hover" data-bs-toggle="modal" data-bs-target="#addNote">Add personal note</button>
                        </div>
                        <div class="col-sm-12 col-md-6 mb-3">
                            <button id="see-notes" class="btn w-100 font-color secondary-bg-color shadow border hover" data-bs-toggle="modal" data-bs-target="#seeNotes">See personal notes</button>
                        </div>
                        <hr class="horizontal-line font-color rounded">
                    </div>

                    <!-- Add Note Bootstrap Modal -->
                    <div class="modal fade" id="addNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header primary-bg-color font-color">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add a personal note</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="mb-3">
                                        <label for="note_title_name" class="form-label h3">Note title</label>
                                        <input type="text" id="note_title_name" class="form-control border">
                                    </div>
                                    <label for="note_text_content" class="form-label">Add new note</label>
                                    <textarea class="form-control" id="note_text_content"></textarea>

                                    <div id="successMessage" class="text-green" style="display: none;">Note added successfully!</div>
                                    <div id="errorMessage" class="text-red" style="display: none;"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn primary-bg-color font-color" id="submitModal">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- See Notes Bootstrap Modal -->
                    <div class="modal fade" id="seeNotes" tabindex="-1" role="dialog" aria-labelledby="seeNotesLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header primary-bg-color font-color">
                                    <h5 class="modal-title" id="seeNotesLabel">All Personal Notes</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row" id="insertNotes"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Note Bootstrap Modal -->
                    <div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header primary-bg-color font-color">
                                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editNoteForm">
                                        <input type="hidden" id="editNoteId" name="editNoteId">
                                        <div class="mb-3">
                                            <label for="editNoteTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="editNoteTitle" name="editNoteTitle">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editNoteText" class="form-label">Text</label>
                                            <textarea class="form-control" id="editNoteText" name="editNoteText" rows="4"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveEditedNoteButton">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <h3 class="font-color text-start">Comments about this book:</h3>
                    <?php
                    if (empty($comments)) {
                        echo '<h4 class="font-color mb-2 text-start"><cite>No comments on this book yet!</h4>';
                    }
                    ?>
                    <?php
                    $userHasCommented = FALSE;
                    foreach ($comments as $comment) :
                        $user = $comment['username'];
                        $commentText = $comment['text'];
                        if (!$comment['admin_verified']) {
                            $printNotApproved = "- Not approved or in queue";
                        } else {
                            $printNotApproved = "";
                        }

                        if (($comment['user_id'] == $userId)) : $userHasCommented = true; ?>
                            <div class="col-12 font-color text-start">
                                <h4>By <?= $user; ?></h4>
                                <p><?= $commentText; ?><small class="text-danger"> <?= $printNotApproved ?></small></p>
                                <form action="./Admin/Comment/delete-comment.php" method="POST" id="deleteCommentForm">
                                    <input type="hidden" value="<?= $bookId; ?>" name="book_id">
                                    <input type="hidden" value="<?= $userId; ?>" name="user_id">
                                    <button class="btn btn-danger" id="deleteCommentButton">Delete comment</button>

                                </form>
                                <hr>
                            </div>

                        <?php else : ?>

                            <div class="col-12 font-color text-start">
                                <h4>By <?= $user; ?></h4>
                                <p><?= $commentText; ?></p>
                                <hr>
                            </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php
                    if ($loggedIn) {
                        if ($userHasCommented) {
                            $view = "d-none";
                        } else {
                            $view = "d-block";
                        }
                    } else {
                        $view = "d-none";
                        echo '<h6 class="font-color"><br><a href="./Register&Login/login-user.php">Log in</a> or <a href="./Register&Login/register-user.php">Register</a> to leave a comment!</h6>';
                    }

                    ?>
                    <div class="col-12 font-color text-center <?= $view; ?>">
                        <form action="./Admin/Comment/queue-comments.php" method="POST" onsubmit="return validateComment()">
                            <div class="form-outline">
                                <input type="hidden" name="user_id" value="<?= $userId; ?>">
                                <input type="hidden" name="book_id" value="<?= $bookId; ?>">
                                <textarea class="form-control mb-2" rows="4" name="comment" id="comment"></textarea>
                            </div>
                            <button class="btn btn-primary">Submit comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <footer>
        <div class="quote text-center p-2 h6 text-secondary bg-dark">
            <small class="text-end"><cite id="quote" class="mb-3"></cite></small>
            <p style="margin-top: 15px; margin-bottom: 0px;">© 2024 Kiko Stojanov</p>

        </div>
    </footer>


    <script src="./fetchQuote.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function loadNotes() {
                let userId = <?= empty($userId) ? "''" : $userId ?>;
                const bookId = <?= $bookId ?>;

                fetch('./Notes/see-notes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            userId: userId,
                            bookId: bookId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let htmlContent = '';
                        data.forEach(item => {
                            htmlContent += `
                        <div class="note-card">
                            <h5>Title: ${item.title}</h5>
                            <p>${item.text}</p>
                            <button onclick="editFunction(${item.id}, '${escapeString(item.title)}', '${escapeString(item.text)}')" class="btn btn-warning edit-note-button">Edit</button>

                            <button onclick='deleteFunction(${item.id})' class="btn btn-danger">Delete</button>
                        </div>
                    `;
                        });

                        Swal.fire({
                            title: 'All Personal Notes',
                            html: htmlContent,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: 'Close'
                        });
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }


            function addNote() {
                Swal.fire({
                    title: 'Add a personal note',
                    html: `
        <div class="mb-3">
            <label for="note_title_name" class="form-label h3">Note title</label>
            <input type="text" id="note_title_name" class="form-control border">
        </div>
        <label for="note_text_content" class="form-label">Add new note</label>
        <textarea class="form-control" id="note_text_content" rows="5"></textarea>`,
                    showCancelButton: true,
                    confirmButtonText: 'Add note',
                    preConfirm: () => {
                        const title = Swal.getPopup().querySelector('#note_title_name').value;
                        const text = Swal.getPopup().querySelector('#note_text_content').value;
                        const userId = <?= json_encode($userId ?? '') ?>;
                        const bookId = <?= json_encode($bookId) ?>;

                        // Debugging statements to verify input values
                        console.log('Title:', title);
                        console.log('Text:', text);

                        if (title === '' || text === '') {
                            Swal.showValidationMessage('Title and Text are required');
                            return;
                        }

                        const data = {
                            user_id: userId,
                            book_id: bookId,
                            title: title,
                            text: text
                        };

                        // Log data to console
                        console.log('Data to be sent:', data);

                        return fetch('./Notes/add-note.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response data:', data); // Log response
                                return data;
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Request failed: ${error}`);
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Saved!', 'Your note has been added.', 'success');
                    }
                });
            }

            function escapeString(str) {
                return str.replace(/'/g, "\\'").replace(/"/g, '\\"');
            }

            function editFunction(id, title, text) {
                console.log('Edit Function Called with:', id, title, text); // Debugging

                Swal.fire({
                    title: 'Edit Note',
                    html: `
            <input type="hidden" id="editNoteId" value="${id}">
            <input type="text" id="editNoteTitle" class="swal2-input" value="${title}">
            <textarea id="editNoteText" class="swal2-textarea">${text}</textarea>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    preConfirm: () => {
                        const id = Swal.getPopup().querySelector('#editNoteId').value;
                        const titleNew = Swal.getPopup().querySelector('#editNoteTitle').value;
                        const textNew = Swal.getPopup().querySelector('#editNoteText').value;

                        console.log('Retrieved id:', id); // Debugging

                        if (titleNew === "" || textNew === '') {
                            Swal.showValidationMessage('Please enter both title and text');
                            return false;
                        }

                        const data = {
                            id: id,
                            title: titleNew,
                            text: textNew
                        };

                        console.log('Sending data to server:', data);

                        return fetch('./Notes/update-note.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(err => {
                                        throw new Error(err.error);
                                    });
                                }
                                return response.json();
                            })
                            .then(responseData => {
                                console.log('Response from server:', responseData);
                                return responseData;
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Request failed: ${error}`);
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Saved!', 'Your note has been updated.', 'success');
                        loadNotes();
                    }
                });
            }



            function deleteFunction(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        const data = {
                            id: id
                        };
                        fetch('./Notes/delete-note.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire('Deleted!', 'Your note has been deleted.', 'success');
                                loadNotes();
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                            });
                    }
                });
            }

            document.addEventListener('click', function(event) {
                if (event.target && event.target.id === 'add-note') {
                    addNote();
                }

                if (event.target && event.target.id === 'see-notes') {
                    loadNotes();
                }
            });

            window.editFunction = editFunction;
            window.deleteFunction = deleteFunction;
        });
    </script>
    <script>
        function validateComment() {
            var comment = document.getElementById("comment").value;

            if (comment.length < 1 || comment.length > 999) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Comment must be between 1 and 1000 characters.',
                });
                return false;
            }
            return true;
        }
    </script>


</body>

</html>