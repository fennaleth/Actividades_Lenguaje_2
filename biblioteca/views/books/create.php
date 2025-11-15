<?php

    //Vista para crear libro

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Libro - Sistema de Biblioteca</title>
    </head>
    <body>
        <header>
            <h1>Sistema de Gestión de Biblioteca</h1>
            <nav>
                <a href="index.php?action=dashboard">Dashboard</a> |
                <a href="index.php?action=books">Libros</a> |
                <a href="index.php?action=authors">Autores</a> |
                <a href="index.php?action=loans">Préstamos</a> |
                <a href="index.php?action=logout">Cerrar Sesión (<?php echo $_SESSION['username']; ?>)</a>
            </nav>
        </header>
        
        <main>
            <h2>Agregar Nuevo Libro.</h2>
            <hr><hr>
            <br>

            <?php if (isset($error)): ?>
                <?php echo htmlspecialchars($error); ?>
            <?php endif; ?>

            <form method="POST" action="index.php?action=books_store">
                <label for="title">Título:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required><br><br>
                
                <label for="author_id">Autor:</label>
                <select name="author_id" required>
                    <option value="">Seleccione un autor</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo $author['id']; ?>" 
                            <?php echo (isset($_POST['author_id']) && $_POST['author_id'] == $author['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($author['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" value="<?php echo htmlspecialchars($_POST['isbn'] ?? ''); ?>"><br><br>
                
                <label>
                    <input type="checkbox" name="available" value="1" 
                        <?php echo !isset($_POST['available']) || $_POST['available'] ? 'checked' : ''; ?>>
                    Disponible para préstamo
                </label><br><br>
                
                <button type="submit">Guardar</button>
                <a href="index.php?action=books">Cancelar</a>
            </form>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>