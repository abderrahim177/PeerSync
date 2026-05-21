<?php
// app/repositories/HelpRequestRepository.php

class HelpRequestRepository {
    private PDO $db;

    public function __construct(PDO $databaseConnection) {
        $this->db = $databaseConnection;
    }
    public function createRequest(string $title, int $skillId, string $description, int $userId): bool {
        try {
            $query = "INSERT INTO help_requests (title, description, status, skill_id, user_id) 
                      VALUES (:title, :description, 'PENDING', :skill_id, :user_id)";
            
            $stmt = $this->db->prepare($query);
            
            return $stmt->execute([
                ':title'       => $title,
                ':description' => $description,
                ':skill_id'    => $skillId,
                ':user_id'     => $userId
            ]);

        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            die();
        }
    }   
    public function getAllTechnologies(): array {
        try {
            $query = "SELECT id, name FROM skills ORDER BY name ASC";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; 
        }
    }
    public function getAllRequests(): array {
    try {
        
        $query = "SELECT hr.*, s.name as skill_name 
                  FROM help_requests hr
                  LEFT JOIN skills s ON hr.skill_id = s.id
                  ORDER BY hr.id DESC"; 
                  
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

    public function getRequestStats(): array {
    try {
        $query = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'PENDING' THEN 1 END) as pending,
                    COUNT(CASE WHEN status = 'ASSIGNED' THEN 1 END) as assigned,
                    COUNT(CASE WHEN status = 'RESOLVED' THEN 1 END) as resolved
                  FROM help_requests";
                  
        $stmt = $this->db->query($query);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return ['total' => 0, 'pending' => 0, 'assigned' => 0, 'resolved' => 0];
    }
}
    public function assignRequest(int $requestId): bool {
    try {
        $query = "UPDATE help_requests SET status = 'ASSIGNED' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':id' => $requestId
        ]);
    } catch (PDOException $e) {
        return false;
    }
}
}