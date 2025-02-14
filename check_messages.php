<?php
require_once 'server.php';

$connector = new Connector();
$sql = "SELECT COUNT(*) as count FROM messages WHERE status = 'unread'";
$result = $connector->executeQuery($sql)->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode(['count' => $result['count']]);
?>