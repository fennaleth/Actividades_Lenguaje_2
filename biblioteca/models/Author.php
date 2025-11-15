<?php

    namespace models;

    use config\Database;

    //Modelo para gestión de autores
    
    class Author {
        private $db;
        
        //var int ID del autor
        
        public $id;
        
        //var string Nombre del autor
        
        public $name;
        
        //var string Fecha de creación
        
        public $createdAt;
        
        //Constructor - inicializa conexión a BD
        
        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }
        
        /*Obtiene todos los autores
         * return array Lista de autores
         */

        public function GetAll(): array {
            $sql = "SELECT * FROM authors ORDER BY name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /*Obtiene un autor por su ID
         * param int $id ID del autor
         * return array|null Datos del autor o null
         */

        public function GetById(int $id): ?array {
            $sql = "SELECT * FROM authors WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        }
        
        /*Crea un nuevo autor
         * return bool True si se creó correctamente
         */

        public function Create(): bool {
            $sql = "INSERT INTO authors (name) VALUES (:name)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $this->name);
            
            return $stmt->execute();
        }
        
        /*Actualiza un autor existente
         * return bool True si se actualizó correctamente
         */

        public function Update(): bool {
            $sql = "UPDATE authors SET name = :name WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":id", $this->id);
            
            return $stmt->execute();
        }
        
        /*Elimina un autor por su ID
         * param int $id ID del autor a eliminar
         * return bool True si se eliminó correctamente
         */

        public function Delete(int $id): bool {
            $sql = "DELETE FROM authors WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":id", $id);
            
            return $stmt->execute();
        }
    }
?>