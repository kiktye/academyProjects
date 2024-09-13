<?php
require_once '../Database/Connection.php';

use Database\Connection as Connection;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $data = json_decode($input);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }

    error_log("Received raw input: " . $input); // Debugging statement
    error_log("Decoded JSON data: " . print_r($data, true)); // Debugging statement

    if (!isset($data->id, $data->title, $data->text)) {
        http_response_code(400);
        echo json_encode(["error" => "Please provide id, title, and text"]);
        exit;
    }

    $noteId = $data->id;
    $noteTitle = $data->title;
    $noteText = $data->text;

    if (empty($noteId)) {
        http_response_code(400);
        echo json_encode(["error" => "Note ID is empty"]);
        exit;
    }

    try {
        $connectionObj = new Connection();
        $connection = $connectionObj->getConnection();

        $statement = $connection->prepare('UPDATE notes SET title = :noteTitle, text = :noteText WHERE id = :id');
        $statement->bindParam(':id', $noteId);
        $statement->bindParam(':noteTitle', $noteTitle);
        $statement->bindParam(':noteText', $noteText);

        if ($statement->execute()) {
            http_response_code(200);
            echo json_encode(["message" => "Note edited successfully."]);
        } else {
            $errorInfo = $statement->errorInfo();
            error_log("SQL error: " . print_r($errorInfo, true));
            http_response_code(500);
            echo json_encode(["error" => "Failed to update the note."]);
        }
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
