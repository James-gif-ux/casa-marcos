<?php
require_once('../model/connector.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Connector();
    
    $messageId = $_POST['message_id'];
    $recipientEmail = $_POST['recipient_email'];
    $replyContent = $_POST['reply_content'];
    
    $sql = "INSERT INTO message_replies (message_id, reply_content) VALUES (?, ?)";
    $params = [$messageId, $replyContent];
    
    if ($db->executeUpdate($sql, $params)) {
        // Update message read status
        $updateSql = "UPDATE messages SET read_status = 1 WHERE id = ?";
        $db->executeUpdate($updateSql, [$messageId]);
        
        // Send email notification to recipient
        mail($recipientEmail, "Reply to your message", $replyContent);
        
        header('Location: ../pages/messages.php?success=1');
        exit();
    }
}
?>