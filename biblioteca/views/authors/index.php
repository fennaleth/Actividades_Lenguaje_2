<?php

    //Vista para lista de autores

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Autores - Sistema de Biblioteca</title>
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
            <h2>Gestión de Autores.</h2>
            <hr><hr>
            <br>

            <?php if (isset($_GET['message'])): ?>

                <?php
                    $messages = [
                        'created' => 'Autor creado exitosamente.',
                        'updated' => 'Autor actualizado exitosamente.',
                        'deleted' => 'Autor eliminado exitosamente.'
                    ];
                    echo $messages[$_GET['message']] ?? 'Operación completada exitosamente.';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <?php
                    $errors = [
                        'not_found' => 'Autor no encontrado.',
                        'delete_failed' => 'Error al eliminar el autor.'
                    ];
                    echo $errors[$_GET['error']] ?? 'Ha ocurrido un error.';
                    ?>
            <?php endif; ?>

            <a href="index.php?action=authors_create">Agregar Nuevo Autor</a>
            <br><br>

            <?php if (empty($authors)): ?>
                <p>No hay autores registrados en el sistema.</p>
            <?php else: ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                        <tr>
                            <td><?php echo $author['id']; ?></td>
                            <td><?php echo htmlspecialchars($author['name']); ?></td>
                            <td><?php echo $author['created_at']; ?></td>
                            <td>
                                <a href="index.php?action=authors_show&id=<?php echo $author['id']; ?>">Ver</a> |
                                <a href="index.php?action=authors_edit&id=<?php echo $author['id']; ?>">Editar</a> |
                                <a href="index.php?action=authors_delete&id=<?php echo $author['id']; ?>" onclick="return confirm('¿Está seguro de eliminar este autor?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <br><br>

            <a href="index.php?action=dashboard">Volver al Dashboard</a>

        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>