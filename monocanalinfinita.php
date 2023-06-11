<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cola Multicanal Poblacion Infinitas</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <header>
        <img src="foto/Combinar.jpg" alt="operativa" class="logo">
        <nav>
            <a href="monocanalinfinita.php">M/M/1</a>
            <a href="index.php">M/M/S</a>
            <a href="monocanalfinira.php">M/M/1 :FIFO/N/N/S</a>
            <a href="multicanalFinita.php">M/M/S:FIFO/N/N</a>
        </nav>
    </header>
    <h1>Cola Monocanal Infinita</h1>

    <form action="monocanalinfinita.php" method="POST">

        <label for="llegada">Ingrese la tasa de llegada: </label>
        <input type="number" id="llegada" name="tasallegada"><br><br>
        <label for="servicio">Ingrese la tasa de servicio: </label>
        <input type="number" id="servicio" name="tasadeservicio"><br>
        <p><input type="submit" class="boton"></p>

    </form>
    <div>
        <?php
        echo "<table border='1' cellspacing='0'>";
        echo "<caption>M/M/S</caption>";
        if ($_POST) {
            $tasallegada = $_POST["tasallegada"];
            $tasaservicio = $_POST["tasadeservicio"];

            //FUNCION QUE CALCULA FACTOR DE UTILIZACION
            function ro($tllegada, $tservicio)
            {
                $ro = $tllegada / $tservicio;
                return $ro;
            }
            $ro = round(ro($tasallegada, $tasaservicio), 5);
            echo "<tr>";
                echo"<td>";
                echo "Probabilidad de que este ocupado es de  :";
                echo"</td>";
                echo"<td>";
                echo "$ro";
                echo"</td>";
            echo "</tr>";

            //FUNCION QUE CALCULA LA PROBABILIDAD
            function probabilidad($tllegada, $tservicio)
            {
                $p = 1 - $tllegada / $tservicio;
                return $p;
            }
            $probabilidad = round(probabilidad($tasallegada, $tasaservicio), 5);
            echo "<tr>";
                echo"<td>";
                echo "Probabilidad de que el sistema este vacio:";
                echo"</td>";
                echo"<td>";
                echo "$probabilidad";
                echo"</td>";
            echo "</tr>";

            //FUNCION "NUMERO ESPERADO DE CLIENTES EN LA COLA"
            function Lq($tllegada, $tservicio)
            {
                $lq = $tllegada ** 2 / ($tservicio * ($tservicio - $tllegada));
                return $lq;
            }
            $lq = round(Lq($tasallegada, $tasaservicio), 2);
            echo "<tr>";
                echo"<td>";
                echo "Numero esperado de clientes en la cola:";
                echo"</td>";
                echo"<td>";
                echo "$lq";
                echo"</td>";
            echo "</tr>";

            //FUNCION "NUMERO ESPERADO DE CLIENTES EN EL SISTEMA"
            function L($tllegada, $tservicio)
            {
                $L = $tllegada / ($tservicio - $tllegada);
                return $L;
            }
            $L = round(L($tasallegada, $tasaservicio), 2);
            echo "<tr>";
                echo"<td>";
                echo "Numero esperado de clientes en la sistema:";
                echo"</td>";
                echo"<td>";
                echo "$L";
                echo"</td>";
            echo "</tr>";


            //FUNCION TIEMPO ESPERADO EN LA COLA
            function Wq($tllegada, $tservicio)
            {
                $wq = $tllegada / ($tservicio * ($tservicio - $tllegada));
                return $wq;
            }
            $wq = round(Wq($tasallegada, $tasaservicio), 5);
            echo "<tr>";
                echo"<td>";
                echo "Tiempo esperado en la cola:";
                echo"</td>";
                echo"<td>";
                echo "$wq";
                echo"</td>";
            echo "</tr>";

            //FUNCION TIEMPO ESPERADO EN EL SISTEMA
            function w($tllegada, $tservicio)
            {
                $w = 1 / ($tservicio - $tllegada);
                return $w;
            }
            $w = round(w($tasallegada, $tasaservicio), 5);
            echo "<tr>";
                echo"<td>";
                echo "Tiempo esperado en la sistema:";
                echo"</td>";
                echo"<td>";
                echo "$w";
                echo"</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
</body>

</html>