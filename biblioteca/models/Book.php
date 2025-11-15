<?php

    namespace models;

    use config\Database;

    //Modelo para gestión de libros
    
    class Book {
        private $db;
        
        //var int ID del libro

        public $id;
        
        //var string Título del libro

        public $title;
        
        //var int ID del autor

        public $authorId;
        
        //var string ISBN del libro
        
        public $isbn;
        
        //var bool Disponibilidad del libro

        public $available;
        
        //var string Fecha de creación

        public $createdAt;
        
        //Constructor - inicializa conexión a BD

        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }
        
        /*Obtiene todos los libros con información del autor
         * return array Lista de libros
         */

        public function GetAll(): array {
            $sql = "SELECT b.*, a.name as author_name 
                    FROM books b 
                    LEFT JOIN authors a ON b.author_id = a.id 
                    ORDER BY b.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /*Obtiene un libro por su ID
         * param int $id ID del libro
         * return array|null Datos del libro o null
         */

        public function GetById(int $id): ?array {
            $sql = "SELECT b.*, a.name as author_name 
                    FROM books b 
                    LEFT JOIN authors a ON b.author_id = a.id 
                    WHERE b.id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        }
        
        /*Crea un nuevo libro
         * return bool True si se creó correctamente
         */

        public function Create(): bool {
            $sql = "INSERT INTO books (title, author_id, isbn, available) 
                    VALUES (:title, :author_id, :isbn, :available)";
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":author_id", $this->authorId);
            $stmt->bindParam(":isbn", $this->isbn);
            $stmt->bindParam(":available", $this->available, \PDO::PARAM_BOOL);
            
            return $stmt->execute();
        }
        
        /*Actualiza un libro existente
         * return bool True si se actualizó correctamente
         */

        public function Update(): bool {
            $sql = "UPDATE books 
                    SET title = :title, author_id = :author_id, isbn = :isbn, available = :available 
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":author_id", $this->authorId);
            $stmt->bindParam(":isbn", $this->isbn);
            $stmt->bindParam(":available", $this->available, \PDO::PARAM_BOOL);
            $stmt->bindParam(":id", $this->id);
            
            return $stmt->execute();
        }
        
        /*Elimina un libro por su ID
         * param int $id ID del libro a eliminar
         * return bool True si se eliminó correctamente
         */

        public function Delete(int $id): bool {
            $sql = "DELETE FROM books WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        }
        
        /*Obtiene libros disponibles para préstamo
         * return array Lista de libros disponibles
         */

        public function GetAvailableBooks(): array {
            $sql = "SELECT b.*, a.name as author_name 
                    FROM books b 
                    LEFT JOIN authors a ON b.author_id = a.id 
                    WHERE b.available = TRUE 
                    ORDER BY b.title";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /*Actualiza la disponibilidad de un libro
         * param int $bookId ID del libro
         * param bool $available Nuevo estado de disponibilidad
         * return bool True si se actualizó correctamente
         */

        public function UpdateAvailability(int $bookId, bool $available): bool {
            $sql = "UPDATE books SET available = :available WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":available", $available, \PDO::PARAM_BOOL);
            $stmt->bindParam(":id", $bookId);
            
            return $stmt->execute();
        }
    }
?>