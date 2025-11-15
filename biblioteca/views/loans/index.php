<?php

    //Vista para lista de préstamos

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Préstamos - Sistema de Biblioteca</title>
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
            <h2>Gestión de Préstamos.</h2>
            <hr><hr>
            <br>

            <?php if (isset($_GET['message'])): ?>
                <?php
                    $messages = [
                        'created' => 'Préstamo creado exitosamente.',
                        'returned' => 'Libro devuelto exitosamente.'
                    ];
                    echo $messages[$_GET['message']] ?? 'Operación completada exitosamente.';
                ?>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <?php
                    $errors = [
                        'not_found' => 'Préstamo no encontrado.',
                        'return_failed' => 'Error al registrar la devolución.'
                    ];
                    echo $errors[$_GET['error']] ?? 'Ha ocurrido un error.';
                ?>
            <?php endif; ?>
            
            <a href="index.php?action=loans_create">Registrar Nuevo Préstamo</a>
            <br><br>

            <?php if (empty($loans)): ?>
                <p>No hay préstamos registrados en el sistema.</p>
            <?php else: ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Libro</th>
                            <th>Autor</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?php echo $loan['id']; ?></td>
                            <td><?php echo htmlspecialchars($loan['username']); ?></td>
                            <td><?php echo htmlspecialchars($loan['title']); ?></td>
                            <td><?php echo htmlspecialchars($loan['author_name']); ?></td>
                            <td><?php echo $loan['loan_date']; ?></td>
                            <td><?php echo $loan['return_date'] ?: 'No devuelto'; ?></td>
                            <td><?php echo $loan['status'] === 'active' ? 'Activo' : 'Devuelto'; ?></td>
                            <td>
                                <a href="index.php?action=loans_show&id=<?php echo $loan['id']; ?>">Ver</a>
                                <?php if ($loan['status'] === 'active'): ?>
                                    | <a href="index.php?action=loans_return&id=<?php echo $loan['id']; ?>" onclick="return confirm('¿Registrar devolución de este libro?')">Devolver</a>
                                <?php endif; ?>
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