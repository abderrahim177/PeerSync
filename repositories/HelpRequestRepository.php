<?php
// app/repositories/HelpRequestRepository.php

class HelpRequestRepository {
    private PDO $db;

    public function __construct(PDO $databaseConnection) {
        $this->db = $databaseConnection;
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
}