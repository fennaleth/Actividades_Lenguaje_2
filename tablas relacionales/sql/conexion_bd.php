<?php

    //Base de datos para el sistema de una plataforma de gestión de contenidos//

    $host = 'localhost';
    $userName = 'phpmyadmin';
    $password = '2605140807pc';

    $connection = mysqli_connect($host, $userName, $password);

    if (!$connection) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $sql = "CREATE DATABASE IF NOT EXISTS Gestion_Contenidos";

    if (mysqli_query($connection, $sql)) {
        echo "Base de datos creada correctamente.";
    } else {
        echo "Error al crear la base de datos: " . mysqli_error($connection);
    }

    mysqli_select_db($connection, 'Gestion_Contenidos');

    $tables = [
        "CREATE TABLE IF NOT EXISTS Users (
            ID_user INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE)",

        "CREATE TABLE IF NOT EXISTS Profiles (
            ID_profile INT AUTO_INCREMENT PRIMARY KEY,
            FK_user INT UNIQUE,
            bio TEXT,
            avatar_url VARCHAR(255),
            FOREIGN KEY (FK_user) REFERENCES Users(ID_user) ON DELETE CASCADE)",

        "CREATE TABLE IF NOT EXISTS Posts (
            ID_post INT AUTO_INCREMENT PRIMARY KEY,
            FK_user INT,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (FK_user) REFERENCES Users(ID_user) ON DELETE CASCADE)",

        "CREATE TABLE IF NOT EXISTS Comments (
            ID_comment INT AUTO_INCREMENT PRIMARY KEY,
            FK_post INT,
            FK_user INT,
            content TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (FK_post) REFERENCES Posts(ID_post) ON DELETE CASCADE,
            FOREIGN KEY (FK_user) REFERENCES Users(ID_user) ON DELETE CASCADE)",

        "CREATE TABLE IF NOT EXISTS Tags (
            ID_tag INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE)",

        "CREATE TABLE IF NOT EXISTS Post_Tags (
            FK_post INT,
            FK_tag INT,
            PRIMARY KEY (FK_post, FK_tag),
            FOREIGN KEY (FK_post) REFERENCES Posts(ID_post) ON DELETE CASCADE,
            FOREIGN KEY (FK_tag) REFERENCES Tags(ID_tag) ON DELETE CASCADE)",

        "CREATE TABLE IF NOT EXISTS Media (
            ID_media INT AUTO_INCREMENT PRIMARY KEY,
            file_url VARCHAR(255) NOT NULL,
            media_able INT NOT NULL,
            media_type ENUM('post', 'comment') NOT NULL)"
    ];

    foreach ($tables as $tableSql) {
        if (mysqli_query($connection, $tableSql)) {
            echo "Tabla creada correctamente.<br>";
        } else {
            echo "Error al crear las tablas en la base de datos: " . mysqli_error($connection);
        }
    }

    mysqli_close($connection);

?>
