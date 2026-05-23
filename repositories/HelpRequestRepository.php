<?php
// app/repositories/HelpRequestRepository.php

class HelpRequestRepository
{
    private PDO $db;

    public function __construct(PDO $databaseConnection)
    {
        $this->db = $databaseConnection;
    }
   public function createRequest(string $title, int $skillId, string $description, int $userId): bool
{
    try {
        // 1. 9addna smiyat les colonnes (skill_id, userId) o les placeholders (:skill_id, :user_id)
        $query = "INSERT INTO help_requests (title, description, status, skill_id, userId, created_at) 
                  VALUES (:title, :description, 'PENDING', :skill_id, :user_id, NOW())";

        $stmt = $this->db->prepare($query);

        // 2. Koulchi matché daba exact m3a la requête l'fo9aniya
        return $stmt->execute([
            ':title'       => $title,
            ':description' => $description,
            ':skill_id'    => $skillId,
            ':user_id'     => $userId // <--- daba matché 100% m3a :user_id li f SQL
        ]);
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        die();
    }
}
    public function getAllTechnologies(): array
    {
        try {
            $query = "SELECT id, name FROM skills ORDER BY name ASC";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    public function getAllRequests(): array
    {
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

    public function getRequestStats(): array
    {
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
public function assignRequest(int $requestId, string $tutorName): bool
{
    try {
        $query = "UPDATE help_requests 
                  SET status = 'ASSIGNED', tutor_name = :tutor_name 
                  WHERE id = :id AND status = 'PENDING'"; 
        
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':id'         => $requestId,
            ':tutor_name' => $tutorName 
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

public function getResolvedRequests() {
    try {
        // La-query l-asasia bach tjbed ga3 l-columns nishan mn help_request
        $query = "SELECT * FROM help_requests WHERE status = 'RESOLVED'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        return false;
    }
}
}
