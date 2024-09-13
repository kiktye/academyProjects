<?php
require_once '../Database/Connection.php';

use Database\Connection as Connection;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $noteId = $data->id ?? "";

    if (empty($noteId)) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Please fill out the form"]);
        exit;
    }

    try {
        $connectionObj = new Connection();
        $connection = $connectionObj->getConnection();

        $statement = $connection->prepare('DELETE FROM notes
        WHERE id = :id');
        $statement->bindParam(':id', $noteId, PDO::PARAM_INT);
        $statement->execute();

        http_response_code(200);
        echo json_encode(["message" => "Note edited successfully"]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
