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
	$valid = 1;
	switch ($_GET['oper']) {

		case 'regcateg':
			
			$nameCat = isset($_POST['nameCat']) ? trim($_POST['nameCat']) : "";
			$descCat = isset($_POST['descCat']) ? trim($_POST['descCat']) : "";

			try {
				$validCateg = $dbConexion -> prepare("SELECT * FROM categoria WHERE nombre_cat = :nameCat");
				$validCateg -> bindParam("nameCat", $nameCat, PDO::PARAM_STR);
				$validCateg -> execute();
				$rowValidCateg = $validCateg -> rowCount();
				if ($rowValidCateg > 0) {
					echo "La categoria que intenta registrar ya se encuentra registrada";
				} else {
					$insertDat = $dbConexion -> prepare("INSERT INTO categoria (nombre_cat, descripcion_cat, estado_cat) VALUES (:nameCat, :descCat, :valid)");
					$insertDat -> bindParam("nameCat", $nameCat, PDO::PARAM_STR);
					$insertDat -> bindParam("descCat", $descCat, PDO::PARAM_STR);
					$insertDat -> bindParam("valid", $valid, PDO::PARAM_INT);
					$insertDat -> execute();
					if ($insertDat) {
						echo 1;
					} else {
						echo "Fallo la inserción";
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'editcat':

			$nameCat = isset($_POST['nameCat']) ? trim($_POST['nameCat']) : "";
			$descCat = isset($_POST['descCat']) ? trim($_POST['descCat']) : "";
			$estCat = isset($_POST['estCat']) ? trim($_POST['estCat']) : "";
			$id_categoria = isset($_POST['id_categoria']) ? trim($_POST['id_categoria']) : "";

			try {
				$validCateg = $dbConexion -> prepare("SELECT * FROM categoria WHERE nombre_cat = :nameCat && id_categoria != :id_categoria");
				$validCateg -> bindParam("nameCat", $nameCat, PDO::PARAM_STR);
				$validCateg -> bindParam("id_categoria", $id_categoria, PDO::PARAM_INT);
				$validCateg -> execute();
				$rowValidCateg = $validCateg -> rowCount();
				if ($rowValidCateg > 0) {
					echo "La categoria que intenta registrar ya se encuentra registrada";
				} else {
					$updateDat = $dbConexion -> prepare("UPDATE categoria SET nombre_cat = :nameCat, descripcion_cat = :descCat, estado_cat = :estCat WHERE id_categoria = :id_categoria");
					$updateDat -> bindParam("nameCat", $nameCat, PDO::PARAM_STR);
					$updateDat -> bindParam("descCat", $descCat, PDO::PARAM_STR);
					$updateDat -> bindParam("estCat", $estCat, PDO::PARAM_STR);
					$updateDat -> bindParam("id_categoria", $id_categoria, PDO::PARAM_INT);
					$updateDat -> execute();
					if ($updateDat) {
						echo 1;
					} else {
						echo "Fallo la actualización";
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'regoffer':

			$selmenu = isset($_POST['selmenu']) ? trim($_POST['selmenu']) : "";
			$descof = isset($_POST['descof']) ? trim($_POST['descof']) : "";
			$dateini = isset($_POST['dateini']) ? trim($_POST['dateini']) : "";
			$datefin = isset($_POST['datefin']) ? trim($_POST['datefin']) : "";
			$nameofer = isset($_POST['nameofer']) ? trim($_POST['nameofer']) : "";
			
			try {
				$insert = $dbConexion -> prepare("INSERT INTO ofertas (id_platillo, nombre_ofer, descripcion_ofer, fecha_ini_ofer, fecha_fin_ofer) VALUES (:selmenu, :nameofer, :descof, :dateini, :datefin)");
				$insert -> bindParam("selmenu", $selmenu, PDO::PARAM_INT);
				$insert -> bindParam("nameofer", $nameofer, PDO::PARAM_STR);
				$insert -> bindParam("descof", $descof, PDO::PARAM_STR);
				$insert -> bindParam("dateini", $dateini, PDO::PARAM_STR);
				$insert -> bindParam("datefin", $datefin, PDO::PARAM_STR);
				$insert -> execute();
				if ($insert) {
					echo 1;
				} else {
					echo "Fallo la inserción";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}
			break;
		
		case 'editofer':	
			$selmenu = isset($_POST['selmenu']) ? trim($_POST['selmenu']) : "";
			$descof = isset($_POST['descof']) ? trim($_POST['descof']) : "";
			$dateini = isset($_POST['dateini']) ? trim($_POST['dateini']) : "";
			$datefin = isset($_POST['datefin']) ? trim($_POST['datefin']) : "";
			$nameofer = isset($_POST['nameofer']) ? trim($_POST['nameofer']) : "";
			$id_oferta = isset($_POST['id_oferta']) ? trim($_POST['id_oferta']) : "";
			try {
				$update = $dbConexion -> prepare("UPDATE ofertas SET id_platillo = :selmenu, nombre_ofer = :nameofer, descripcion_ofer = :descof, fecha_ini_ofer = :dateini, fecha_fin_ofer = :datefin WHERE id_oferta = :id_oferta");
				$update -> bindParam("selmenu", $selmenu, PDO::PARAM_INT);
				$update -> bindParam("nameofer", $nameofer, PDO::PARAM_STR);
				$update -> bindParam("descof", $descof, PDO::PARAM_STR);
				$update -> bindParam("dateini", $dateini, PDO::PARAM_STR);
				$update -> bindParam("datefin", $datefin, PDO::PARAM_STR);
				$update -> bindParam("id_oferta", $id_oferta, PDO::PARAM_INT);
				$update -> execute();
				if ($update) {
					echo 1;
				} else {
					echo "Fallo la actualización";
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
