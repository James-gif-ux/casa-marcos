<?php
require_once 'server.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $connector = new Connector();
        $messageId = $_POST['message_id'];
        
        $sql = "UPDATE messages SET status = 'read' WHERE message_id = ?";
        $stmt = $connector->executeQuery($sql, [$messageId]);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>