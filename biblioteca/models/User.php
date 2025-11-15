<?php

    namespace models;

    use config\Database;

    //Modelo para gestión de usuarios
    
    class User {

        //var \PDO Conexión a base de datos
        
        private $db;
        
        //var int ID del usuario

        public $id;
        
        //var string Nombre de usuario

        public $userName;
        
        //var string Email del usuario
        
        public $email;
        
        //var string Contraseña hasheada
        
        public $password;
        
        //Constructor - inicializa conexión a BD

        public function __construct() {
            $database = new Database();
            $this->db = $database->getConnection();
        }
        
        //Crea un nuevo usuario en el sistema

        public function Create(): bool {
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($sql);
            
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            
            $stmt->bindParam(":username", $this->userName);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            
            return $stmt->execute();
        }
        
        /*
         * Busca usuario por email
         * param string $email Email a buscar
        */

        public function FindByEmail(string $email): ?User {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($row) {
                $this->id = $row['id'];
                $this->userName = $row['username'];
                $this->email = $row['email'];
                $this->password = $row['password'];
                return $this;
            }
            return null;
        }
        
        /*Valida las credenciales de un usuario
         * param string $email Email del usuario
         * param string $password Contraseña sin hashear
         * return bool True si las credenciales son válidas
         */

        public function validateCredentials(string $email, string $password): bool {
            $user = $this->findByEmail($email);
            
            if ($user && password_verify($password, $user->password)) {
                $this->id = $user->id;
                $this->userName = $user->userName;
                $this->email = $user->email;
                return true;
            }
            return false;
        }
        
        /*Verifica si un email ya está registrado
         * param string $email Email a verificar
         * return bool True si el email existe
         */

        public function EmailExists(string $email): bool {
            $sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        }
        
        //Verifica si un userName ya está registrado
        
        public function UserNameExists(string $userName): bool {
            $sql = "SELECT id FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $userName);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        }
    }
?>