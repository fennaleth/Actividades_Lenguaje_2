<?php

    //Vista para registro de usuarios

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro - Sistema de Biblioteca</title>
    </head>
    <body>
        <header>
            <h1>Sistema de Gestión de Biblioteca.</h1>
        </header>
        
        <main>
            <h2>Registro de Usuario.</h2>
            <hr><hr>
            <br>

            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="index.php?action=register_process">
                <label for="username">Nombre de Usuario:</label><br>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                <h4>Debe empezar con mayúscula y contener solo letras</h4>
                
                <label for="email">Email:</label><br>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                <h4>Dominios permitidos: gmail.com, hotmail.com, outlook.com, yahoo.com</h4>
                
                <label for="password">Contraseña:</label><br>
                <input type="password" name="password" required>
                <h4>Mínimo 6 caracteres</h4>
                
                <label for="confirm_password">Confirmar Contraseña:</label><br>
                <input type="password" name="confirm_password" required><br><br>
                
                <button type="submit">Registrarse</button>
            </form>

            <p>¿Ya tienes cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>