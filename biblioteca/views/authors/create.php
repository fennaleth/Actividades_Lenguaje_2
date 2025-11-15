<?php

    //Vista para crear autor

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Autor - Sistema de Biblioteca</title>
    </head>
    <body>
        <header>
            <h1>Sistema de Gestión de Biblioteca.</h1>
            <nav>
                <a href="index.php?action=dashboard">Dashboard</a> |
                <a href="index.php?action=books">Libros</a> |
                <a href="index.php?action=authors">Autores</a> |
                <a href="index.php?action=loans">Préstamos</a> |
                <a href="index.php?action=logout">Cerrar Sesión (<?php echo $_SESSION['username']; ?>)</a>
            </nav>
        </header>
        
        <main>
            <h2>Agregar Nuevo Autor.</h2>
            <hr><hr>
            <br>

            <?php if (isset($error)): ?>
                <?php echo htmlspecialchars($error); ?>
            <?php endif; ?>

            <form method="POST" action="index.php?action=authors_store">
                <label for="name">Nombre del Autor:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required><br><br>
                
                <button type="submit">Guardar</button>
                <a href="index.php?action=authors">Cancelar</a>
            </form>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>