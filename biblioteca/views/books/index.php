<?php

    //Vista para lista de libros

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Libros - Sistema de Biblioteca</title>
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
            <h2>Gestión de Libros.</h2>
            <hr><hr>
            <br>

            <?php if (isset($_GET['message'])): ?>
                <?php
                    $messages = [
                        'created' => 'Libro creado exitosamente.',
                        'updated' => 'Libro actualizado exitosamente.',
                        'deleted' => 'Libro eliminado exitosamente.'
                    ];
                    echo $messages[$_GET['message']] ?? 'Operación completada exitosamente.';
                ?>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <?php
                    $errors = [
                        'not_found' => 'Libro no encontrado.',
                        'delete_failed' => 'Error al eliminar el libro.'
                    ];
                    echo $errors[$_GET['error']] ?? 'Ha ocurrido un error.';
                ?>
            <?php endif; ?>

                <a href="index.php?action=books_create">Agregar Nuevo Libro</a>
                <br><br>

            <?php if (empty($books)): ?>
                <p>No hay libros registrados en el sistema.</p>
            <?php else: ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>ISBN</th>
                            <th>Disponible</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo $book['id']; ?></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author_name']); ?></td>
                            <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                            <td><?php echo $book['available'] ? 'Sí' : 'No'; ?></td>
                            <td>
                                <a href="index.php?action=books_show&id=<?php echo $book['id']; ?>">Ver</a> |
                                <a href="index.php?action=books_edit&id=<?php echo $book['id']; ?>">Editar</a> |
                                <a href="index.php?action=books_delete&id=<?php echo $book['id']; ?>" onclick="return confirm('¿Está seguro de eliminar este libro?')">Eliminar.</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>