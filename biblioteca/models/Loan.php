<?php

    namespace models;

    use config\Database;

    //Modelo para gestión de préstamos

    class Loan {
        private $db;
        
        //var int ID del préstamo

        public $id;
        
        //var int ID del usuario
        
        public $userId;
        
        //var int ID del libro
        
        public $bookId;
        
        //var string Fecha de préstamo
        
        public $loanDate;
        
        //var string|null Fecha de devolución
        
        public $returnDate;
        
        //var string Estado del préstamo
        
        public $status;
        
        //Constructor - inicializa conexión a BD
        
        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }
        
        /*Obtiene todos los préstamos con información relacionada
         * return array Lista de préstamos
         */

        public function GetAll(): array {
            $sql = "SELECT l.*, u.username, b.title, a.name as author_name 
                    FROM loans l
                    JOIN users u ON l.user_id = u.id
                    JOIN books b ON l.book_id = b.id
                    JOIN authors a ON b.author_id = a.id
                    ORDER BY l.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /*Obtiene un préstamo por su ID
         * param int $id ID del préstamo
         * return array|null Datos del préstamo o null
         */

        public function GetById(int $id): ?array {
            $sql = "SELECT l.*, u.username, b.title, a.name as author_name 
                    FROM loans l
                    JOIN users u ON l.user_id = u.id
                    JOIN books b ON l.book_id = b.id
                    JOIN authors a ON b.author_id = a.id
                    WHERE l.id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        }
        
        /*Crea un nuevo préstamo
         * return bool True si se creó correctamente
         */

        public function Create(): bool {
            $sql = "INSERT INTO loans (user_id, book_id, loan_date, return_date, status) 
                    VALUES (:user_id, :book_id, :loan_date, :return_date, :status)";
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(":user_id", $this->userId);
            $stmt->bindParam(":book_id", $this->bookId);
            $stmt->bindParam(":loan_date", $this->loanDate);
            $stmt->bindParam(":return_date", $this->returnDate);
            $stmt->bindParam(":status", $this->status);
            
            return $stmt->execute();
        }
        
        /*Actualiza un préstamo existente
         * return bool True si se actualizó correctamente
         */

        public function Update(): bool {
            $sql = "UPDATE loans 
                    SET user_id = :user_id, book_id = :book_id, loan_date = :loan_date, 
                        return_date = :return_date, status = :status 
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(":user_id", $this->userId);
            $stmt->bindParam(":book_id", $this->bookId);
            $stmt->bindParam(":loan_date", $this->loanDate);
            $stmt->bindParam(":return_date", $this->returnDate);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":id", $this->id);
            
            return $stmt->execute();
        }
        
        /*Registra la devolución de un libro
         * param int $loanId ID del préstamo
         * return bool True si se registró correctamente
         */

        public function ReturnBook(int $loanId): bool {
            $sql = "UPDATE loans SET return_date = CURDATE(), status = 'returned' WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $loanId);
            
            return $stmt->execute();
        }
        
        /*Obtiene los préstamos activos de un usuario
         * param int $userId ID del usuario
         * return array Lista de préstamos activos
         */

        public function GetActiveLoansByUser(int $userId): array {
            $sql = "SELECT l.*, b.title, a.name as author_name 
                    FROM loans l
                    JOIN books b ON l.book_id = b.id
                    JOIN authors a ON b.author_id = a.id
                    WHERE l.user_id = :user_id AND l.status = 'active'";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":user_id", $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
?>