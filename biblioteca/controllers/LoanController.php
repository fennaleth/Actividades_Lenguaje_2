<?php
    namespace controllers;

    use models\Loan;
    use models\Book;
    use models\User;

    //Controlador para gestión de préstamos
    
    class LoanController {
        private $loanModel;
        private $bookModel;
        private $userModel;
        
        //Constructor - inicializa modelos
        
        public function __construct() {
            $this->loanModel = new Loan();
            $this->bookModel = new Book();
            $this->userModel = new User();
        }
        
        //Muestra la lista de préstamos
        
        public function Index(): void {
            $loans = $this->loanModel->getAll();
            require_once 'views/loans/index.php';
        }
        
        //Muestra el formulario para crear préstamo

        public function Create(): void {
            $availableBooks = $this->bookModel->getAvailableBooks();
            require_once 'views/loans/create.php';
        }
        
        //Almacena un nuevo préstamo

        public function Store(): void {
            if ($_POST) {
                session_start();
                $userId = $_SESSION['user_id'] ?? 0;
                $bookId = intval($_POST['book_id'] ?? 0);
                $loanDate = $_POST['loan_date'] ?? date('Y-m-d');
                
                if ($userId && $bookId) {
                    $this->loanModel->userId = $userId;
                    $this->loanModel->bookId = $bookId;
                    $this->loanModel->loanDate = $loanDate;
                    $this->loanModel->returnDate = null;
                    $this->loanModel->status = 'active';
                    
                    if ($this->loanModel->create()) {

                        // Actualizar disponibilidad del libro

                        $this->bookModel->updateAvailability($bookId, false);
                        header('Location: index.php?action=loans&message=created');
                        exit;
                    }
                }
                
                $error = "Error al crear el préstamo.";
                $availableBooks = $this->bookModel->getAvailableBooks();
                require_once 'views/loans/create.php';
            }
        }
        
        /*Registra la devolución de un libro
         * param int $id ID del préstamo
         */

        public function ReturnBook(int $id): void {
            if ($this->loanModel->returnBook($id)) {

                // Obtener el book_id del préstamo

                $loan = $this->loanModel->getById($id);
                if ($loan) {

                    // Actualizar disponibilidad del libro

                    $this->bookModel->updateAvailability($loan['book_id'], true);
                }
                
                header('Location: index.php?action=loans&message=returned');
                exit;
            } else {
                header('Location: index.php?action=loans&error=return_failed');
                exit;
            }
        }
        
        /*Muestra los detalles de un préstamo
         * param int $id ID del préstamo
         */

        public function Show(int $id): void {
            $loan = $this->loanModel->getById($id);
            
            if ($loan) {
                require_once 'views/loans/show.php';
            } else {
                header('Location: index.php?action=loans&error=not_found');
                exit;
            }
        }
    }
?>