<?php

    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    function emailDomains($email, $domains) {
        $parts = explode('@', $email);
        return count($parts) === 2 && in_array($parts[1], $domains);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userName = clean($_POST["userName"]);
        $lastName = clean($_POST["lastName"]);
        $birthdate = clean($_POST["birthdate"]);
        $id = clean($_POST["id"]);
        $phone = clean($_POST["phone"]);
        $domains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
        $email = trim($_POST["email"]);
        $userPass = $_POST["password"];
        $errors = [];

        $patternUser = "/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]*/";
        $patternID = "/^[VEJGOP][0-9]+$/";
        $patternPhone = "/^\+58[0-9]{10}$/";
        $patternPassword = "/^(?=(?:.*\d){3,})(?=(?:.*[!@#$%^&*()_\-+=]){2,}).{8,12}$/";

        if (!preg_match($patternUser, $userName)) {
            $errors[] = "El nombre debe comenzar con mayúscula y contener solo letras.";
        }

        if (!preg_match($patternUser, $lastName)) {
            $errors[] = "El apellido debe comenzar con mayúscula y contener solo letras.";
        }

        if (strtotime($birthdate) >= time()) {
            $errors[] = "La fecha de nacimiento no es válida.";
        } else {
            $age = (int) ((time() - strtotime($birthdate)) / (365.25 * 24 * 60 * 60));
            if ($age < 18) {
                $errors[] = "Debes ser mayor de edad para registrarte.";
            }
        }

        if (!preg_match($patternID, $id)) {
            $errors[] = "La cédula de identidad no es válida.";
        }

        if (!preg_match($patternPhone, $phone)) {
            $errors[] = "El número de teléfono no es válido.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El correo electrónico no es válido.";
        } elseif (!emailDomains($email, $domains)) {
            $errors[] = "El correo electrónico debe contener un dominio permitido: @gmail.com, @hotmail.com, @outlook.com ó @yahoo.com.";
        }

        if (!preg_match($patternPassword, $userPass)) {
            $errors[] = "La contraseña debe tener entre 8 a 12 caracteres, al menos 3 números y 2 símbolos.";
        } else {
            $hashedPassword = password_hash($userPass, PASSWORD_DEFAULT);
        }

    }

?>