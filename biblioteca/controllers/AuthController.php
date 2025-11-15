<?php

    namespace controllers;

    use models\User;

    //Controlador para autenticación de usuarios
    
    class AuthController {
        private $userModel;
        
        //Constructor - inicializa modelo de usuario
        
        public function __construct() {
            $this->userModel = new User();
        }
        
        //Muestra el formulario de registro
        
        public function ShowRegisterForm(): void {
            require_once 'views/auth/register.php';
        }
        
        //Procesa el registro de un nuevo usuario
        
        public function Register(): void {
            if ($_POST) {
                $userName = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';
                
                $errors = $this->validateRegistration($userName, $email, $password, $confirmPassword);
                
                if (empty($errors)) {
                    $this->userModel->userName = $userName;
                    $this->userModel->email = $email;
                    $this->userModel->password = $password;
                    
                    if ($this->userModel->create()) {
                        header('Location: index.php?action=login&message=registered');
                        exit;
                    } else {
                        $errors[] = "Error al crear el usuario. Intente nuevamente.";
                    }
                }
                
                require_once 'views/auth/register.php';
            }
        }
        
        //Muestra el formulario de login
        
        public function ShowLoginForm(): void {
            require_once 'views/auth/login.php';
        }
        
        //Procesa el inicio de sesión
        
        public function Login(): void {
            if ($_POST) {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                
                if ($this->userModel->validateCredentials($email, $password)) {
                    session_start();
                    $_SESSION['user_id'] = $this->userModel->id;
                    $_SESSION['username'] = $this->userModel->userName;
                    $_SESSION['email'] = $this->userModel->email;
                    
                    header('Location: index.php?action=dashboard');
                    exit;
                } else {
                    $error = "Credenciales inválidas. Intente nuevamente.";
                    require_once 'views/auth/login.php';
                }
            }
        }
        
        //Cierra la sesión del usuario
        
        public function Logout(): void {
            session_start();
            session_destroy();
            header('Location: index.php?action=login');
            exit;
        }
        
        /*Valida los datos de registro
         * param string $userName Nombre de usuario
         * param string $email Email
         * param string $password Contraseña
         * param string $confirmPassword Confirmación de contraseña
         * return array Lista de errores
         */
        private function ValidateRegistration(string $userName, string $email, string $password, string $confirmPassword): array {
            $errors = [];
            
            // Validar userName

            if (empty($userName)) {
                $errors[] = "El nombre de usuario es requerido.";
            } elseif (!preg_match('/^[A-Z][a-zA-Z]*$/', $userName)) {
                $errors[] = "El nombre debe empezar con mayúscula y contener solo letras.";
            } elseif ($this->userModel->userNameExists($userName)) {
                $errors[] = "El nombre de usuario ya está en uso.";
            }
            
            // Validar email

            if (empty($email)) {
                $errors[] = "El email es requerido.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El formato del email no es válido.";
            } elseif (!$this->isValidEmailDomain($email)) {
                $errors[] = "El dominio del email no está permitido. Use gmail.com, hotmail.com, outlook.com o yahoo.com.";
            } elseif ($this->userModel->emailExists($email)) {
                $errors[] = "El email ya está registrado.";
            }
            
            // Validar contraseña

            if (empty($password)) {
                $errors[] = "La contraseña es requerida.";
            } elseif (strlen($password) < 6) {
                $errors[] = "La contraseña debe tener al menos 6 caracteres.";
            } elseif ($password !== $confirmPassword) {
                $errors[] = "Las contraseñas no coinciden.";
            }
            return $errors;
        }
        
        /*Valida el dominio del email
         * param string $email Email a validar
         * return bool True si el dominio es válido
         */
        
        private function IsValidEmailDomain(string $email): bool {
            $allowedDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
            $domain = strtolower(substr(strrchr($email, "@"), 1));
            
            return in_array($domain, $allowedDomains);
        }
    }
?>