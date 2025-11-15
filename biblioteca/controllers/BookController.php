<?php

    namespace controllers;

    use models\Book;
    use models\Author;

    //Controlador para gestión de libros
    
    class BookController {
        private $bookModel;
        private $authorModel;
        
        //Constructor - inicializa modelos

        public function __construct() {
            $this->bookModel = new Book();
            $this->authorModel = new Author();
        }
        
        /*Muestra la lista de libros
         * return void
         */

        public function Index(): void {
            $books = $this->bookModel->getAll();
            require_once 'views/books/index.php';
        }
        
        /*Muestra el formulario para crear libro
         * return void
         */

        public function Create(): void {
            $authors = $this->authorModel->getAll();
            require_once 'views/books/create.php';
        }
        
        //Almacena un nuevo libro
        
        public function Store(): void {
            if ($_POST) {
                $this->bookModel->title = trim($_POST['title'] ?? '');
                $this->bookModel->authorId = intval($_POST['author_id'] ?? 0);
                $this->bookModel->isbn = trim($_POST['isbn'] ?? '');
                $this->bookModel->available = isset($_POST['available']);
                
                if ($this->bookModel->create()) {
                    header('Location: index.php?action=books&message=created');
                    exit;
                } else {
                    $error = "Error al crear el libro.";
                    $authors = $this->authorModel->getAll();
                    require_once 'views/books/create.php';
                }
            }
        }
        
        /*Muestra el formulario para editar libro
         * param int $id ID del libro
         */

        public function Edit(int $id): void {
            $book = $this->bookModel->getById($id);
            $authors = $this->authorModel->getAll();
            
            if ($book) {
                require_once 'views/books/edit.php';
            } else {
                header('Location: index.php?action=books&error=not_found');
                exit;
            }
        }
        
        /*Actualiza un libro existente
         * param int $id ID del libro
         */

        public function Update(int $id): void {
            if ($_POST) {
                $this->bookModel->id = $id;
                $this->bookModel->title = trim($_POST['title'] ?? '');
                $this->bookModel->authorId = intval($_POST['author_id'] ?? 0);
                $this->bookModel->isbn = trim($_POST['isbn'] ?? '');
                $this->bookModel->available = isset($_POST['available']);
                
                if ($this->bookModel->update()) {
                    header('Location: index.php?action=books&message=updated');
                    exit;
                } else {
                    $error = "Error al actualizar el libro.";
                    $book = $this->bookModel->getById($id);
                    $authors = $this->authorModel->getAll();
                    require_once 'views/books/edit.php';
                }
            }
        }
        
        /*Elimina un libro
         * param int $id ID del libro
         */

        public function Destroy(int $id): void {
            if ($this->bookModel->delete($id)) {
                header('Location: index.php?action=books&message=deleted');
                exit;
            } else {
                header('Location: index.php?action=books&error=delete_failed');
                exit;
            }
        }
        
        /*Muestra los detalles de un libro
         * param int $id ID del libro
         */

        public function Show(int $id): void {
            $book = $this->bookModel->getById($id);
            
            if ($book) {
                require_once 'views/books/show.php';
            } else {
                header('Location: index.php?action=books&error=not_found');
                exit;
            }
        }
    }
?>