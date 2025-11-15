<?php

    //Vista para mostrar detalles de préstamo

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalles Préstamo - Sistema de Biblioteca</title>
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
            <h2>Detalles del Préstamo.</h2>
            <hr><hr>
            <br>

            <?php if ($loan): ?>
                <h3>Información del Préstamo #<?php echo $loan['id']; ?></h3>
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($loan['username']); ?></p>
                <p><strong>Libro:</strong> <?php echo htmlspecialchars($loan['title']); ?></p>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($loan['author_name']); ?></p>
                <p><strong>Fecha de Préstamo:</strong> <?php echo $loan['loan_date']; ?></p>
                <p><strong>Fecha de Devolución:</strong> <?php echo $loan['return_date'] ?: 'No devuelto'; ?></p>
                <p><strong>Estado:</strong> <?php echo $loan['status'] === 'active' ? 'Activo' : 'Devuelto'; ?></p>
                <p><strong>Fecha de Registro:</strong> <?php echo $loan['created_at']; ?></p>
                
                <?php if ($loan['status'] === 'active'): ?>
                    <a href="index.php?action=loans_return&id=<?php echo $loan['id']; ?>" onclick="return confirm('¿Registrar devolución de este libro?')">Registrar Devolución</a> |
                <?php endif; ?>
                <a href="index.php?action=loans">Volver a la lista</a>
            <?php else: ?>
                <p>Préstamo no encontrado.</p>
                <a href="index.php?action=loans">Volver a la lista</a>
            <?php endif; ?>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>