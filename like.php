<?php
include 'connect.php';
$conn = conOpen();
$headers = getallheaders();

function updateLikes($id, $conn) {
    $stmt = $conn->prepare('UPDATE images SET likes = likes + 1 WHERE ID = ?');
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function getLikes($id, $conn) {
    $stmt = $conn->prepare('SELECT likes FROM images WHERE ID = ?');
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['likes'];
}

    if ($headers["Content-type"] == "application/json") {
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST['id'];

        if (intval($_POST['liked']) == 1) {
            updateLikes($id, $conn);
            getLikes($id, $conn);
        } else {
            getLikes($id, $conn);
        }
    }