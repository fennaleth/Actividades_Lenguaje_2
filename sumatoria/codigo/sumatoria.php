<?php

    $result = null;
    $error = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numberOne = $_POST['numberOne']?? null;
        $numberTwo = $_POST['numberTwo']?? null;
        $numberThree = $_POST['numberThree']?? null;

        if (is_numeric($numberOne) && is_numeric($numberTwo) && is_numeric($numberThree)) {
            $result = $numberOne + $numberTwo + $numberThree;
        } else {
            $error = "Por favor, ingrese solo valores numéricos para realizar la operación.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Sumatoria de Tres Números Diferentes.</title>
    </head>
    <body>
        <h1>Sumatoria de Tres Números Diferentes.</h1><hr><hr>
        
        <form method="POST">
            <label for="numberOne">Ingrese el primer número:</label>
            <input type="text" name="numberOne" required><br><br>
            <label for="numberTwo">Ingrese el segundo número:</label>
            <input type="text" name="numberTwo" required><br><br>
            <label for="numberThree">Ingrese el tercer número:</label>
            <input type="text" name="numberThree" required><br><br>
            <input type="submit" value="Calcular la sumatoria">
        </form><hr><hr>

        <?php

            if ($error) {
                echo "<strong>",$error,"</strong>";
            } elseif (isset($numberOne, $numberTwo, $numberThree)) {
                $showNumberTwo = ($numberTwo < 0)? "($numberTwo)": $numberTwo;
                $showNumberThree = ($numberThree < 0)? "($numberThree)": $numberThree;
                echo "La sumatoria de: <strong>",$numberOne," + ",$showNumberTwo," + ",$showNumberThree," = ",$result,"</strong>";
            }
        ?>
    </body>
</html>