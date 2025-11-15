<?php

    //Vista para inicio de sesión

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar Sesión - Sistema de Biblioteca</title>
    </head>
    <body>
        <header>
            <h1>Sistema de Gestión de Biblioteca.</h1>
        </header>
        
        <main>
            <h2>Iniciar Sesión.</h2>
            <hr><hr>
            <br>

            <?php if (isset($_GET['message'])): ?>
                <?php
                    $messages = [
                        'registered' => 'Usuario registrado exitosamente. Ahora puede iniciar sesión.'
                    ];
                    echo $messages[$_GET['message']] ?? 'Operación completada exitosamente.';
                ?>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <?php echo htmlspecialchars($error); ?>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login_process">
                <label for="email">Email:</label><br>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required><br><br>

                <label for="password">Contraseña:</label><br>
                <input type="password" name="password" required><br><br>
                
                <button type="submit">Iniciar Sesión</button>
            </form>

            <p>¿No tienes cuenta? <a href="index.php?action=register">Regístrate aquí</a></p>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>