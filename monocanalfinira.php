<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <title>Cola Multicanal Poblacion Infinita</title>
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

    <form action="monocanalfinita.php" method="POST">

        <label for="llegada">Ingrese la tasa de llegada: </label>
        <input type="number" id="llegada" name="tasallegada" step="any"><br><br>
        <label for="servicio">Ingrese la tasa de servicio: </label>
        <input type="number" id="servicio" name="tasadeservicio" step="any"><br><br>
        <label for="clientes">Numero de Clientes: </label>
        <input type="number" id="clientes" name="nclientes" step="any">
        <p><input type="submit" class="boton"></p>


    </form>
    <?php
    if ($_POST) {
        $tasallegada = $_POST["tasallegada"];
        $tasaservicio = $_POST["tasadeservicio"];
        $mclientes = $_POST["nclientes"];

        //FUNCION QUE CALCULA FACTOR DE UTILIZACION
        function probabilidad($tllegada, $tservicio, $m)
        {
            $mn = $m;
            $factorialm = 1;
            for ($j = 1; $j <= $m; $j++) {
                $factorialm *= $j;
            }

            $probabilidad = 0;
            for ($i = 0; $i <= $m; $i++) {
                $factorialmn = 1;
                for ($j = 1; $j <= $mn; $j++) {
                    $factorialmn *= $j;
                }
                //hallamos el 1/(probabilidad) solo el probabilidad luego se dividira con el 1
                $probabilidad = $probabilidad + (($factorialm / $factorialmn) * (($tllegada / $tservicio) ** $i));
                $mn--;
            }
            //completamos la formula con 1/probabilidad
            $probabilidad = 1 / $probabilidad;

            return $probabilidad;
        }
        $ro = round(probabilidad($tasallegada, $tasaservicio, $mclientes), 5);

        echo "La probabilidad de enconctrar el sistema vacio es = $ro<br>";

        //FUNCION DE NUMERO ESPERADO DE CLIENTES EN LA COLA
        function Lq($tllegada, $tservicio, $probabilidad, $m)
        {
            $lq = $m - ((($tllegada + $tservicio) / $tllegada) * (1 - $probabilidad));
            return $lq;
        }
        $lq = round(Lq($tasallegada, $tasaservicio, $ro, $mclientes), 5);
        echo "numero de clientes esperado en la cola = $lq<br>";

        //FUNCION DE NUMERO DE CLIENTES ESPERADO EN EL SISTEMA
    
        function L($lq, $probabilidad)
        {
            $L = $lq + (1 - $probabilidad);
            return $L;
        }
        $L = round(L($lq, $ro), 5);
        echo "Numero esperado de clientes en el Sistema = $L<br>";

        //FUNCTION TIEMPO ESPERADO DE CLIENTES EN LA COLA
        function Wq($l, $tservicio, $probabilidad)
        {
            $Wq = $l / $tservicio * (1 - $probabilidad);
            return $Wq;
        }
        $Wq = round(Wq($L, $tasaservicio, $ro), 5);
        echo "Tiempo esperado de clientes en la cola = $Wq<br>";

        //FUNCION TIEMPO ESPERADO DE CLIENTES EN EL SISTEMA
    
        function W($wq, $tservicio)
        {
            $W = $wq + (1 / $tservicio);
            return $W;
        }
        $W = round(W($Wq, $tasaservicio), 5);
        echo "Tiempo esperado de clientes en el sistema = $W";
    }
    ?>
</body>

</html>