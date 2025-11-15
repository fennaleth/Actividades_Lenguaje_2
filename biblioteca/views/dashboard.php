<?php

    //Vista del dashboard principal

    // Inicializar modelos para obtener estadísticas
    
    use models\Book;
    use models\Author;
    use models\Loan;

    $bookModel = new Book();
    $authorModel = new Author();
    $loanModel = new Loan();

    $totalBooks = count($bookModel->getAll());
    $totalAuthors = count($authorModel->getAll());
    $totalLoans = count($loanModel->getAll());
    $availableBooks = count($bookModel->getAvailableBooks());

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard - Sistema de Biblioteca</title>
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
            <h2>Dashboard</h2>
            <hr><hr>

            <h3>Estadísticas</h3>
            <p>Total Libros: <?php echo $totalBooks; ?></p>
            <p>Total Autores: <?php echo $totalAuthors; ?></p>
            <p>Total Préstamos: <?php echo $totalLoans; ?></p>
            <p>Libros Disponibles: <?php echo $availableBooks; ?></p>

            <h3>Acciones Rápidas.</h3>
            <ul>
                <li><a href="index.php?action=books_create">Agregar Nuevo Libro</a></li>
                <li><a href="index.php?action=authors_create">Agregar Nuevo Autor</a></li>
                <li><a href="index.php?action=loans_create">Registrar Nuevo Préstamo</a></li>
                <li><a href="index.php?action=books">Gestionar Libros</a></li>
                <li><a href="index.php?action=authors">Gestionar Autores</a></li>
                <li><a href="index.php?action=loans">Gestionar Préstamos</a></li>
            </ul>
        </main>
        <br>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gestión de Biblioteca</p>
        </footer>
    </body>
</html>