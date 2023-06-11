<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cola Multicanal Poblacion Infinita</title>
    <link rel="stylesheet"  href="styles.css">
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
    <h1>Cola Multicanal Poblacion infinita</h1>
    
    <form action="index.php" method="POST">

        <label for="llegada">Ingrese la tasa de llegada: </label>
        <input type="number" id="llegada" name="tasallegada"><br>
        <label for="servicio">Ingrese la tasa de servicio: </label>
        <input type="number" id="servicio" name="tasadeservicio"><br>
        <label for="cabinas">Canales de servicio</label>
        <input type="number" id="cabinas" name="numerocabinas"><br>
        <label for="nclientes">Numero de clientes</label>
        <input type="number" id="nclientes" name="clientes"><br>
        <p><input type="submit" class="boton"></p>
    </form>
    <div>
        <?php
        echo "<table border='1' cellspacing='0'>";
        echo "<caption>M/M/S</caption>";  
        if ($_POST) {
            $n1 = $_POST["tasallegada"];
            $n2 = $_POST["tasadeservicio"];
            $n3 = $_POST["numerocabinas"];
            $n4 = $_POST["clientes"];
            

            function probabilidad($tasallegada, $serviciou, $k)
            {

                $n = 0;
                $probabilidad = 0;
                for ($i = 0; $i <= $k - 1; $i++) {
                    $factorial = 1;
                    for ($j = 1; $j <= $i; $j++) {
                        $factorial *= $j;
                    }
                    $probabilidad = $probabilidad + (((1 / ($factorial)) * ($tasallegada / $serviciou) ** $i));
                }
                $factorial = 1;

                for ($j = 1; $j <= $k; $j++) {
                    $factorial *= $j;
                }
                $pw = 1 / $factorial * ($tasallegada / $serviciou) ** $k * ($k * $serviciou / ($k * $serviciou - $tasallegada));

                $pwt = 1 / ($probabilidad + $pw);
                return $pwt;
            }
            $probabilidad = round(probabilidad($n1, $n2, $n3), 5);
            echo "<tr>";
                echo"<td>";
                echo "la probabilidad es :";
                echo"</td>";
                echo"<td>";
                echo "$probabilidad";
                echo"</td>";
            echo "</tr>";
            function probabilidad_vacio($tasallegada, $serviciou, $k, $probabilidad, $numeroclientes)
            {

                $factorial = 1;
                for ($j = 1; $j <= $numeroclientes; $j++) {
                    $factorial *= $j;
                }
                $pv = (1 / $factorial) * ($tasallegada / $serviciou) ** $numeroclientes * ($k * $serviciou / ($k * $serviciou - $tasallegada)) * $probabilidad;
                return $pv;
            }
            $proclientes = round(probabilidad_vacio($n1, $n2, $n3, $probabilidad, $n4), 4);
            echo "<tr>";
                echo"<td>";
                echo "n clientes en el sistema:";
                echo"</td>";
                echo"<td>";
                echo "$proclientes";
                echo"</td>";
            echo "</tr>";

            function lq($tasallegada, $serviciou, $k, $probabilidad)
            {
                $factorial = 1;

                for ($j = 1; $j <= $k - 1; $j++) {
                    $factorial *= $j;
                }
                $lq = ((($tasallegada * $serviciou) * ($tasallegada / $serviciou) ** $k)
                    / (($factorial * ($k * $serviciou - $tasallegada) ** 2))) * $probabilidad;
                return $lq;
            }
            $lq = round(lq($n1, $n2, $n3, $probabilidad), 5);
            echo "<tr>";
                echo"<td>";
                echo "Numero esperado en la cola:";
                echo"</td>";
                echo"<td>";
                echo "$lq";
                echo"</td>";
            echo "</tr>";

            function lu($lq, $tasallegada, $serviciou)
            {
                $l = $lq + ($tasallegada / $serviciou);
                return $l;
            }
            $l = round(lu($lq, $n1, $n2),5);
            echo "<tr>";
                echo"<td>";
                    echo "Numero esperado en Sistema:";
                echo"</td>";
                echo"<td>";
                    echo "$l";
                echo"</td>";
            echo "</tr>";
 


            function wq($serviciou, $tasallegada, $k, $probabilidad)
            {
                $factorial = 1;

                for ($j = 1; $j <= $k - 1; $j++) {
                    $factorial *= $j;
                }
                $wq = (($serviciou * (($tasallegada / $serviciou) ** $k)) / ($factorial * (($k * $serviciou - $tasallegada) ** 2))) * $probabilidad;
                return $wq;
            }

            $wq = round(wq($n2, $n1, $n3, $probabilidad), 7);
            echo "<tr>";
                echo"<td>";
                    echo "Tiempo esperado en la cola:";
                echo"</td>";
                echo"<td>";
                    echo "$wq";
                echo"</td>";
            echo "</tr>";


            function W($wq, $serviciou)
            {
                $w = $wq + (1 / $serviciou);
                return $w;
            }
            $w = round(W($wq, $n2), 7);
            echo "<tr>";
                echo"<td>";
                    echo "Tiempo esperado en el sistema:";
                echo"</td>";
                echo"<td>";
                    echo "$w";
                echo"</td>";
            echo "</tr>";

            
        }
        echo "</table>";
        ?>
    </div>
    <select>
        <option >Monocanal Infinita<a></option>
        <option>Multicanal Infinita</option>
        <option>Monocanal Finita</option>
        <option>Multicanal Finita</option>
    </select>
</body>

</html>