<?php

    //Vista para editar libro

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar Libro - Sistema de Biblioteca</title>
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
            <h2>Editar Libro.</h2>
            <hr><hr>
            <br>

            <?php if (isset($error)): ?>
                <?php echo htmlspecialchars($error); ?>
            <?php endif; ?>

            <form method="POST" action="index.php?action=books_update&id=<?php echo $book['id']; ?>">
                <label for="title">Título:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                
                <label for="author_id">Autor:</label>
                <select name="author_id" required>
                    <option value="">Seleccione un autor</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo $author['id']; ?>" 
                            <?php echo ($book['author_id'] == $author['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($author['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>
                
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>"><br><br>
                
                <label>
                    <input type="checkbox" name="available" value="1" 
                        <?php echo $book['available'] ? 'checked' : ''; ?>>
                    Disponible para préstamo
                </label><br><br>
                
                <button type="submit">Actualizar</button>
                <a href="index.php?action=books">Cancelar</a>
            </form>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>