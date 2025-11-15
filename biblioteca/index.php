<?php

    //Archivo principal - Enrutador de la aplicación

    // Incluir autoloader

    require_once 'autoload.php';

    // Iniciar sesión si no está iniciada

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Obtener acción desde URL

    $action = $_GET['action'] ?? 'login';

    // Enrutamiento básico
    
    switch ($action) {
        case 'register':
            $controller = new controllers\AuthController();
            $controller->showRegisterForm();
            break;
            
        case 'register_process':
            $controller = new controllers\AuthController();
            $controller->register();
            break;
            
        case 'login':
            $controller = new controllers\AuthController();
            $controller->showLoginForm();
            break;
            
        case 'login_process':
            $controller = new controllers\AuthController();
            $controller->login();
            break;
            
        case 'logout':
            $controller = new controllers\AuthController();
            $controller->logout();
            break;
            
        case 'dashboard':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            require_once 'views/dashboard.php';
            break;
            
        case 'books':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\BookController();
            $controller->index();
            break;
            
        case 'books_create':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\BookController();
            $controller->create();
            break;
            
        case 'books_store':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\BookController();
            $controller->store();
            break;
            
        case 'books_edit':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\BookController();
            $controller->edit($id);
            break;
            
        case 'books_update':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\BookController();
            $controller->update($id);
            break;
            
        case 'books_delete':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\BookController();
            $controller->destroy($id);
            break;
            
        case 'books_show':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\BookController();
            $controller->show($id);
            break;
            
        case 'authors':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\AuthorController();
            $controller->index();
            break;
            
        case 'authors_create':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\AuthorController();
            $controller->create();
            break;
            
        case 'authors_store':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\AuthorController();
            $controller->store();
            break;
            
        case 'authors_edit':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\AuthorController();
            $controller->edit($id);
            break;
            
        case 'authors_update':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\AuthorController();
            $controller->update($id);
            break;
            
        case 'authors_delete':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\AuthorController();
            $controller->destroy($id);
            break;
            
        case 'authors_show':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\AuthorController();
            $controller->show($id);
            break;
            
        case 'loans':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\LoanController();
            $controller->index();
            break;
            
        case 'loans_create':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\LoanController();
            $controller->create();
            break;
            
        case 'loans_store':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $controller = new controllers\LoanController();
            $controller->store();
            break;
            
        case 'loans_return':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\LoanController();
            $controller->returnBook($id);
            break;
            
        case 'loans_show':
            if (!isset($_SESSION['user_id'])) {
                header('Location: index.php?action=login');
                exit;
            }
            $id = intval($_GET['id'] ?? 0);
            $controller = new controllers\LoanController();
            $controller->show($id);
            break;
            
        default:
            header('Location: index.php?action=login');
            exit;
    }
?>