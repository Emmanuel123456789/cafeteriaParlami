<?php
function reporte($fecha_ini,$fecha_fin)
    {
    $dato_ini = "";
    if($fecha_ini != ""){
        $dato_ini = "&& c.fecha_dat BETWEEN '$fecha_ini' AND '$fecha_ini'";
        if($fecha_fin != ""){
            $dato_ini = "&& c.fecha_dat BETWEEN '$fecha_ini' AND '$fecha_fin'";
        }
    }
        $conexion= mysqli_connect("localhost", "root", "");
        mysqli_select_db($conexion, "cafeteriam") or die("No se encuentra la base de datos.");
        $consulta = "SELECT dp.id_detpedido,dp.cod_conf,cli.nombre_cli,d.direccion_cli,SUM(pl.precio_plat) total,c.fecha_dat FROM det_pedido dp INNER JOIN carrito c ON c.id_carrito=dp.id_carrito INNER JOIN direcciones d ON d.id_direccion=dp.id_direccion INNER JOIN clientes cli ON cli.id_cliente=c.id_cliente INNER JOIN plat_menu pl ON pl.id_platillo=c.id_platillo WHERE dp.confirm_ped=0 ".$dato_ini." GROUP BY dp.cod_conf";
        $resultados = mysqli_query($conexion, $consulta);
        $filas = array(); // Crea la variable $filas y se le asigna un array vacío
        // (Si la consulta no devuelve ningún resultado, la función por lo menos va a retornar un array vacío)
        while ($fila=mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
            $filas[] = $fila; // Añade el array $fila al final de $filas
        }
        mysqli_close($conexion);
        return $filas; // Devuelve el array $filas
    }
session_start();

if ($_SESSION['keyAdm'] == "" || $_SESSION['keyAdm'] == null) {
	header("Location:../../");
} else {
	switch ($_GET['oper']) {
		case 'report':
			try {
                            $fecha_ini = ""; $fecha_fin = "";
                            if(isset($_POST["fecha_ini"])){
                                $fecha_ini=$_POST["fecha_ini"];
                                if(isset($_POST["fecha_fin"])){
                                    $fecha_fin=$_POST["fecha_fin"];
                                }
                            } 
                            $consul = reporte($fecha_ini, $fecha_fin);
                            echo json_encode($consul);
			} catch (PDOException $e) {
				echo $e->getMessage();
			} 

			break;
		default:
			break;
	}
        

}
