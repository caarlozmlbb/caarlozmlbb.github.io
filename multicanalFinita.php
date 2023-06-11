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
        <input type="number" id="clientes" name="nclientes" step="any"><br><br>
        <label for="canalesServicio"> Numero de canales</label>
        <input type="number" id="canalesServicio" name="canal" step="any"> 
        <p><input type="submit" class="boton"></p>


    </form>
    <?php
    if ($_POST) {
        $tasallegada = $_POST["tasallegada"];
        $tasaservicio = $_POST["tasadeservicio"];
        $mclientes = $_POST["nclientes"];
        $canalesS =  $_POST["canal"];

        //FUNCION QUE CALCULA FACTOR DE UTILIZACION
        function probabilidad($tllegada, $tservicio, $m, $k)
        {
            $mn = $m;
            $factorialm = 1;
            for ($j = 1; $j <= $m; $j++) {
                $factorialm *= $j;
            }
            $sumatoria1=0;
            $probabilidad = 0;
            for ($i = 0; $i < $k; $i++) {
                //sacamos el factorial de mn
                $factorialmn = 1;
                for ($j = 1; $j <= $mn; $j++) {
                    $factorialmn *= $j;
                }
                $factoriali = 1;
                for ($j = 1; $j <= $i; $j++) {
                    $factoriali *= $j;
                }
                $sumatoria1=$sumatoria1+(($factorialm/($factorialmn*$factoriali))*($tllegada/$tservicio)**$i);
                $mn--;
            }

            $factorialk = 1;
            for ($j = 1; $j <= $k; $j++) {
                $factorialk *= $j;
            }
            $c=0;
            $n=$k;
            $n=$m-$n;
            $sumatoria2=0;
            for($i = $k; $i <= $m; $i++){
                //sacamos el factorial de mn
                $factorialmn = 1;
                for ($j = 1; $j <= $n; $j++) {
                    $factorialmn *= $j;
                }
                $sumatoria2 += (($factorialm/($factorialmn*$factorialk*($k**$c)))*($tllegada/$tservicio)**$i);
                $c++;
                $n--;
            }
            $probabilidad = $sumatoria1+$sumatoria2;
            $probabilidad=1/$probabilidad;

            return $probabilidad;
        }
        $ro = round(probabilidad($tasallegada, $tasaservicio, $mclientes,$canalesS), 5);
        echo "La probabilidad de enconctrar el sistema vacio es = $ro<br>";

        //PROBABILIDAD DE NECONTRAR N CLEINTES EN EL SISTEMA

        function pn($m,$k,$tllegada,$tservicio,$probabilidad){
            $c=0;
            $mm=0;
            for($x=$k;$x<=$m;$x++){

                $factorialm = 1;
                //$n viene de entrada como dato
                for ($j = 1; $j <= $m; $j++) {
                    $factorialm *= $j;
                }
                //factorial de m-n
                $mn=$m-$x;
                $factorialmn = 1;
                for ($j = 1; $j <= $mn; $j++) {
                    $factorialmn *= $j;
                }
                //factorial de k
                $factorialk = 1;
                for ($j = 1; $j <= $k; $j++) {
                    $factorialk *= $j;
                }
                $pn = ($factorialm/(($factorialmn*$factorialk*($k**($x-$k)))))*
                (($tllegada/$tservicio)**$x)*$probabilidad;
                //echo"probablidad $pn<br>";
                $mm=$mm+$c*$pn;
                $c++;

            }
            
            return $mm;
        }
        $Lq = round(pn($mclientes,$canalesS,$tasallegada,$tasaservicio,$ro),5);
        echo"Numero esperado de clientes en la cola= $Lq<br>";



        //NUMERO ESPERADO DE CLIENTES EN LA COLA
        function l($m,$k,$tllegada,$tservicio,$probabilidad){
            $c=1;
            $mm=0;
            for($x=$k-1;$x<=$m;$x++){

                $factorialm = 1;
                //$n viene de entrada como dato
                for ($j = 1; $j <= $m; $j++) {
                    $factorialm *= $j;
                }
                //factorial de m-n
                $mn=$m-$x;
                $factorialmn = 1;
                for ($j = 1; $j <= $mn; $j++) {
                    $factorialmn *= $j;
                }
                //factorial de k
                $factorialk = 1;
                for ($j = 1; $j <= $k; $j++) {
                    $factorialk *= $j;
                }
                $pn = ($factorialm/(($factorialmn*$factorialk*($k**($x-$k)))))*
                (($tllegada/$tservicio)**$x)*$probabilidad;
                //echo"probablidad $pn<br>";
                $mm=$mm+$c*$pn;
                $c++;

            }
            return $mm;
        }
        $l = round(l($mclientes,$canalesS,$tasallegada,$tasaservicio,$ro),5);
        echo"Numero esperado de clientes en el sistema= $l<br>";

        //TIEMPO ESPERADO DE CLIENTES EN LA COLA
        function Wq($l,$tservicio,$lq){

            $wq=$l/$tservicio*($l-$lq);
            return $wq;
        }   
        $wq = round(Wq($l,$tasaservicio,$Lq),5);
        echo"Tiempo esperado de clientes en la cola = $wq<br>";

        //TIEMPO ESPERADO DE CLIENTES EN EL SISTEMA
        function W($Wq,$tservicio){
            $W = $Wq+(1/$tservicio);
            return $W;
        }
        $W = round(W($wq,$tasaservicio),5);
        echo "Tiempo esperado de clientes en el sistema $W";

    }
    ?>
</body>

</html>