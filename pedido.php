<?php

session_start();

if ($_SESSION['keyAdm'] == "" || $_SESSION['keyAdm'] == null) {
	header("Location:../../");
} else {
	include '../../models/rutas.php';
	include '../../models/connect.php';
	$fechAct = date("Y-m-d H:i:s");
	$dbConexion = new Connect();
	$dbConexion = $dbConexion -> getDB();
	$keyAdm = $_SESSION['keyAdm'];
	switch ($_GET['oper']) {

		case 'confirm':

			$cod = isset($_POST['cod']) ? trim($_POST['cod']) : "";
			$confirm = 0;
			try {
				$selectp = $dbConexion -> prepare("SELECT * FROM det_pedido WHERE cod_conf = :cod");
				$selectp -> bindParam("cod", $cod, PDO::PARAM_STR);
				$selectp -> execute();
				while ($dp = $selectp -> fetch(PDO::FETCH_OBJ)) {
					$update = $dbConexion -> prepare("UPDATE det_pedido SET confirm_ped = :confirm, fecha_confirm_ped = :fechAct WHERE cod_conf = :cod");
					$update -> bindParam("confirm", $confirm, PDO::PARAM_INT);
					$update -> bindParam("fechAct", $fechAct, PDO::PARAM_STR);
					$update -> bindParam("cod", $cod, PDO::PARAM_STR);
					$update -> execute();	
				}
				if ($update) {
					echo 1;
				} else {
					echo "Fallo la confirmación";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;
		default:
			$dbConexion = null;
			break;
	}

}
