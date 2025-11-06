<?php

    // Configuración de la base de datos de la manera mas simplificada

    class Database {
        private $host;
        private $dbName;
        private $userName;
        private $password;
        public $pdo;

        public function __construct($host = 'localhost', $dbName = 'database', $userName = 'root', $password = '') {
            $this->host = $host;
            $this->dbName = $dbName;
            $this->userName = $userName;
            $this->password = $password;
            $this->connect();
        }
        
        private function connect() {
            try {
                $pdoTEMP = new PDO("mysql:host={$this->host}", $this->userName, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);

                $pdoTEMP -> exec("CREATE DATABASE IF NOT EXISTS `{$this->dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo "<p>Base de datos '{$this->dbName}' creada.</p>";

                $this -> pdo = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->userName, $this->password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                echo "<p>Conexión a la base de datos '{$this->dbName}' exitosa.</p>";
            }catch (PDOException $error) {
                die("Error de conexión: ".$error->getMessage());
            }
        }
    }

    $db = new Database();

?>