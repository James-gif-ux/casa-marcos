<?php
require_once 'server.php';
class RoomModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllRooms() {
        $query = "SELECT * FROM rooms";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function get_Rooms() {
        $query = "SELECT * FROM rooms ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRoomById($room_id) {
        $query = "SELECT * FROM rooms WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $room_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRoom($room_name, $price, $image, $description, $capacity) {
        $query = "INSERT INTO rooms (room_name, price, image, description, capacity) 
                 VALUES (:name, :price, :image, :description, :capacity)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $room_name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':capacity', $capacity);

        return $stmt->execute();
    }

    public function updateRoom($room_id, $room_name, $price, $image, $description, $capacity) {
        $query = "UPDATE rooms 
                 SET room_name = :name, 
                     price = :price, 
                     image = :image, 
                     description = :description, 
                     capacity = :capacity 
                 WHERE room_id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $room_id);
        $stmt->bindParam(':name', $room_name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':capacity', $capacity);

        return $stmt->execute();
    }

    public function deleteRoom($room_id) {
        $query = "DELETE FROM rooms WHERE room_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $room_id);
        return $stmt->execute();
    }

    public function insertRooms($room_name, $description, $price, $image, $capacity, $status, $room_type) {
        $query = "INSERT INTO rooms (room_name, description, price, image, capacity, status, room_type, created_at, updated_at) 
                  VALUES (:name, :description, :price, :image, :capacity, :status, :room_type, NOW(), NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $room_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':room_type', $room_type);
    
        return $stmt->execute();
    }
    
    
}
?>
