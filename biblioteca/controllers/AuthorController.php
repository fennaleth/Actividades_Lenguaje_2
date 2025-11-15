<?php

    namespace controllers;

    use models\Author;

    //Controlador para gestión de autores
    
    class AuthorController {
        private $authorModel;
        
        //Constructor - inicializa modelo
        
        public function __construct() {
            $this->authorModel = new Author();
        }
        
        //Muestra la lista de autores
        
        public function Index(): void {
            $authors = $this->authorModel->getAll();
            require_once 'views/authors/index.php';
        }
        
        //Muestra el formulario para crear autor
        
        public function Create(): void {
            require_once 'views/authors/create.php';
        }
        
        //Almacena un nuevo autor
        
        public function Store(): void {
            if ($_POST) {
                $this->authorModel->name = trim($_POST['name'] ?? '');
                
                if ($this->validateAuthorName($this->authorModel->name)) {
                    if ($this->authorModel->create()) {
                        header('Location: index.php?action=authors&message=created');
                        exit;
                    } else {
                        $error = "Error al crear el autor.";
                    }
                } else {
                    $error = "El nombre del autor debe empezar con mayúscula y contener solo letras y espacios.";
                }
                
                require_once 'views/authors/create.php';
            }
        }
        
        /*Muestra el formulario para editar autor
         * param int $id ID del autor
         */

        public function Edit(int $id): void {
            $author = $this->authorModel->getById($id);
            
            if ($author) {
                require_once 'views/authors/edit.php';
            } else {
                header('Location: index.php?action=authors&error=not_found');
                exit;
            }
        }
        
        /*Actualiza un autor existente
         * param int $id ID del autor
         */

        public function Update(int $id): void {
            if ($_POST) {
                $this->authorModel->id = $id;
                $this->authorModel->name = trim($_POST['name'] ?? '');
                
                if ($this->validateAuthorName($this->authorModel->name)) {
                    if ($this->authorModel->update()) {
                        header('Location: index.php?action=authors&message=updated');
                        exit;
                    } else {
                        $error = "Error al actualizar el autor.";
                    }
                } else {
                    $error = "El nombre del autor debe empezar con mayúscula y contener solo letras y espacios.";
                }
                
                $author = $this->authorModel->getById($id);
                require_once 'views/authors/edit.php';
            }
        }
        
        /*Elimina un autor
         * param int $id ID del autor
         */

        public function Destroy(int $id): void {
            if ($this->authorModel->delete($id)) {
                header('Location: index.php?action=authors&message=deleted');
                exit;
            } else {
                header('Location: index.php?action=authors&error=delete_failed');
                exit;
            }
        }
        
        /*Muestra los detalles de un autor
         * param int $id ID del autor
         */

        public function Show(int $id): void {
            $author = $this->authorModel->getById($id);
            
            if ($author) {
                require_once 'views/authors/show.php';
            } else {
                header('Location: index.php?action=authors&error=not_found');
                exit;
            }
        }
        
        /*Valida el nombre del autor
         * param string $name Nombre a validar
         * return bool True si el nombre es válido
         */

        private function ValidateAuthorName(string $name): bool {
            return preg_match('/^[A-Z][a-zA-Z\s]*$/', $name);
        }
    }
?>