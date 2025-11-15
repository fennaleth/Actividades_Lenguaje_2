<?php

    namespace config;

    //Clase para gestión de conexión a base de datos

    class Database {

        //Atributos para la configuración de la base de datos

        private $connection;
        private $host = 'localhost';
        private $dbName = 'library_db';
        private $username = 'phpmyadmin';
        private $password = '2605140807pc';
        
        // Constructor - establece conexión y crea estructura

        public function __construct() {
            $this->connect();
            $this->createDatabase();
            $this->createTables();
        }
        
        //Establecer conexión PDO con la base de datos
        
        private function Connect(): void {
            try {
                $this->connection = new \PDO(
                    "mysql:host={$this->host}", 
                    $this->username, 
                    $this->password
                );
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        
        //Crea la base de datos si no existe
        
        private function CreateDatabase(): void {
            $sql = "CREATE DATABASE IF NOT EXISTS {$this->dbName}";
            $this->connection->exec($sql);
            $this->connection->exec("USE {$this->dbName}");
        }
        
        //Crea las tablas necesarias del sistema

        private function CreateTables(): void {
            // Tabla de usuarios
            $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            // Tabla de autores
            $sqlAuthors = "CREATE TABLE IF NOT EXISTS authors (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            // Tabla de libros
            $sqlBooks = "CREATE TABLE IF NOT EXISTS books (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                author_id INT NOT NULL,
                isbn VARCHAR(20),
                available BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
            )";
            
            // Tabla de préstamos
            $sqlLoans = "CREATE TABLE IF NOT EXISTS loans (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                book_id INT NOT NULL,
                loan_date DATE NOT NULL,
                return_date DATE,
                status ENUM('active', 'returned') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
            )";
            
            $this->connection->exec($sqlUsers);
            $this->connection->exec($sqlAuthors);
            $this->connection->exec($sqlBooks);
            $this->connection->exec($sqlLoans);
        }
        
        //Obtiene la instancia de conexión PDO
        
        public function getConnection(): \PDO {
            return $this->connection;
        }
    }
?>