<?php

    //Vista para mostrar detalles de libro

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalles Libro - Sistema de Biblioteca</title>
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
            <h2>Detalles del Libro.</h2>
            <hr><hr>
            <br>

            <?php if ($book): ?>
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><strong>ID:</strong> <?php echo $book['id']; ?></p>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['author_name']); ?></p>
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                <p><strong>Disponible:</strong> <?php echo $book['available'] ? 'Sí' : 'No'; ?></p>
                <p><strong>Fecha de creación:</strong> <?php echo $book['created_at']; ?></p>
                <a href="index.php?action=books_edit&id=<?php echo $book['id']; ?>">Editar</a> |
                <a href="index.php?action=books">Volver a la lista</a>
            <?php else: ?>
                <p>Libro no encontrado.</p>
                <a href="index.php?action=books">Volver a la lista</a>
            <?php endif; ?>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>