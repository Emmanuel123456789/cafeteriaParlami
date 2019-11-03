<?php

session_start();

if ($_SESSION['keyAdm'] == "" || $_SESSION['keyAdm'] == null) {
	header("Location:../../");
} else {
	include '../../models/rutas.php';
	include '../../models/connect.php';
	$fechAct = date("Y-m-d");
	$dbConexion = new Connect();
	$dbConexion = $dbConexion -> getDB();
	$keyAdm = $_SESSION['keyAdm'];
	switch ($_GET['oper']) {

		case 'regvideo':
			
			$selPla = isset($_POST['selVid']) ? trim($_POST['selVid']) : "";
			$descVid = isset($_POST['descVid']) ? trim($_POST['descVid']) : "";

			$nameVideo = 4;
//			$tipoVideo = $_FILES['video']['type']; 
                        echo "INSERT INTO videos (id_platillo, url, descripcion) VALUES (".$selPla.", ".$nameVideo.", ".$descVid.")";
//			if (($nameVideo == !NULL)) {
//				$directorio = "../../files/video/";
//				move_uploaded_file($_FILES['video']['tmp_name'], $directorio.$nameVideo);
//			}
//
//			try {
//				$insertDat = $dbConexion -> prepare("INSERT INTO videos (id_platillo, url, descripcion) VALUES (:selPla, :url, :descVid)");
//                                $insertDat -> bindParam("selPla", $selPla, PDO::PARAM_INT);
//                                $insertDat -> bindParam("url", $nameVideo, PDO::PARAM_STR);
//                                $insertDat -> bindParam("descVid", $descVid, PDO::PARAM_STR);
//                                $insertDat -> execute();
//                                if ($insertDat) {
//                                        echo 1;
//                                } else {
//                                        echo "Fallo la inserción";
//                                }
//			} catch (PDOException $e) {
//				echo $e->getMessage();
//			} finally {
//				$dbConexion = null;
//			}

			break;

		default:
			$dbConexion = null;
			break;
	}

}



