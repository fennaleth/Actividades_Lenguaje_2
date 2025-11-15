<?php

    //Vista para mostrar detalles de autor

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalles Autor - Sistema de Biblioteca</title>
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
            <h2>Detalles del Autor.</h2>
            <hr><hr>
            <br>

            <?php if ($author): ?>
                <h3><?php echo htmlspecialchars($author['name']); ?></h3>
                <p><strong>ID:</strong> <?php echo $author['id']; ?></p>
                <p><strong>Fecha de creación:</strong> <?php echo $author['created_at']; ?></p>
                <a href="index.php?action=authors_edit&id=<?php echo $author['id']; ?>">Editar</a> |
                <a href="index.php?action=authors">Volver a la lista</a>
            <?php else: ?>
                <p>Autor no encontrado.</p>
                <a href="index.php?action=authors">Volver a la lista</a>
            <?php endif; ?>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>