<?php

    /*Autoloader personalizado para cargar clases automáticamente
     * param string $className Nombre de la clase a cargar
     */

    spl_autoload_register(function ($className) {

        // Convertir namespace a ruta de archivo
        
        $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    });
?>