<?php

    //Vista para crear préstamo

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Crear Préstamo - Sistema de Biblioteca</title>
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
            <h2>Registrar Nuevo Préstamo.</h2>
            <hr><hr>
            <br>

            <?php if (isset($error)): ?>
                <div>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=loans_store">
                <label for="book_id">Libro:</label>
                <select name="book_id" required>
                    <option value="">Seleccione un libro</option>
                    <?php foreach ($availableBooks as $book): ?>
                        <option value="<?php echo $book['id']; ?>">
                            <?php echo htmlspecialchars($book['title']); ?> - <?php echo htmlspecialchars($book['author_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br><br>

                <?php if (empty($availableBooks)): ?>
                        <p>No hay libros disponibles para préstamo.</p>
                <?php endif; ?>
                
                <label for="loan_date">Fecha de Préstamo:</label>
                <input type="date" name="loan_date" value="<?php echo date('Y-m-d'); ?>" required><br><br>
                
                <button type="submit" <?php echo empty($availableBooks) ? 'disabled' : ''; ?>>Registrar Préstamo</button>
                <a href="index.php?action=loans">Cancelar</a>
            </form>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>