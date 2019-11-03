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

		case 'regplat':
			
			$selCat = isset($_POST['selCat']) ? trim($_POST['selCat']) : "";
			$descPla = isset($_POST['descPla']) ? trim($_POST['descPla']) : "";
			$timePla = isset($_POST['timePla']) ? trim($_POST['timePla']) : "";
			$namePla = isset($_POST['namePla']) ? trim($_POST['namePla']) : "";
			$prePla = isset($_POST['prePla']) ? trim($_POST['prePla']) : "";

			$imgPla = $_FILES['imgPla']['name'];
			$tipoImg = $_FILES['imgPla']['type'];
			if (($imgPla == !NULL)) {
				if ($tipoImg == "image/jpeg" || $tipoImg == "image/jpg" || $tipoImg == "image/png") {
					$directorioG = "../../files/platillos/";
					move_uploaded_file($_FILES['imgPla']['tmp_name'], $directorioG.$imgPla);
				} else {
					die();
				}
			}

			try {
				$validPlat = $dbConexion -> prepare("SELECT * FROM plat_menu WHERE nombre_plat = :namePla");
				$validPlat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
				$validPlat -> execute();
				$rowValidPlat = $validPlat -> rowCount();
				if ($rowValidPlat > 0) {
					echo "El platillo que intenta registrar ya se encuentra registrado";
				} else {
					$insertDat = $dbConexion -> prepare("INSERT INTO plat_menu (id_categoria, nombre_plat, descripcion_plat, precio_plat, tiempo_prepare, imagen_plat1, estado_plat) VALUES (:selCat, :namePla, :descPla, :prePla, :timePla, :imgPla, :valid)");
					$insertDat -> bindParam("selCat", $selCat, PDO::PARAM_INT);
					$insertDat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
					$insertDat -> bindParam("descPla", $descPla, PDO::PARAM_STR);
					$insertDat -> bindParam("prePla", $prePla, PDO::PARAM_STR);
					$insertDat -> bindParam("timePla", $timePla, PDO::PARAM_STR);
					$insertDat -> bindParam("imgPla", $imgPla, PDO::PARAM_STR);
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

		case 'editplatnone':

			$selCat = isset($_POST['selCat']) ? trim($_POST['selCat']) : "";
			$descPla = isset($_POST['descPla']) ? trim($_POST['descPla']) : "";
			$timePla = isset($_POST['timePla']) ? trim($_POST['timePla']) : "";
			$namePla = isset($_POST['namePla']) ? trim($_POST['namePla']) : "";
			$prePla = isset($_POST['prePla']) ? trim($_POST['prePla']) : "";
			$estCat = isset($_POST['estCat']) ? trim($_POST['estCat']) : "";
			$id_platillo = isset($_POST['id_platillo']) ? trim($_POST['id_platillo']) : "";

			try {
				$validPlat = $dbConexion -> prepare("SELECT * FROM plat_menu WHERE nombre_plat = :namePla && id_platillo != :id_platillo");
				$validPlat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
				$validPlat -> bindParam("id_platillo", $id_platillo, PDO::PARAM_INT);
				$validPlat -> execute();
				$rowValidPlat = $validPlat -> rowCount();
				if ($rowValidPlat > 0) {
					echo "El platillo que intenta registrar ya se encuentra registrado";
				} else {
					$updateDat = $dbConexion -> prepare("UPDATE plat_menu SET id_categoria = :selCat, nombre_plat = :namePla, descripcion_plat = :descPla, precio_plat = :prePla, tiempo_prepare = :timePla, estado_plat = :estCat WHERE id_platillo = :id_platillo");
					$updateDat -> bindParam("selCat", $selCat, PDO::PARAM_INT);
					$updateDat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
					$updateDat -> bindParam("descPla", $descPla, PDO::PARAM_STR);
					$updateDat -> bindParam("prePla", $prePla, PDO::PARAM_STR);
					$updateDat -> bindParam("timePla", $timePla, PDO::PARAM_STR);
					$updateDat -> bindParam("estCat", $estCat, PDO::PARAM_INT);
					$updateDat -> bindParam("id_platillo", $id_platillo, PDO::PARAM_INT);
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

		case 'editplat':

			$selCat = isset($_POST['selCat']) ? trim($_POST['selCat']) : "";
			$descPla = isset($_POST['descPla']) ? trim($_POST['descPla']) : "";
			$timePla = isset($_POST['timePla']) ? trim($_POST['timePla']) : "";
			$namePla = isset($_POST['namePla']) ? trim($_POST['namePla']) : "";
			$prePla = isset($_POST['prePla']) ? trim($_POST['prePla']) : "";
			$estCat = isset($_POST['estCat']) ? trim($_POST['estCat']) : "";
			$id_platillo = isset($_POST['id_platillo']) ? trim($_POST['id_platillo']) : "";

			$imgPla = $_FILES['imgPla']['name'];
			$tipoImg = $_FILES['imgPla']['type'];
			if (($imgPla == !NULL)) {
				if ($tipoImg == "image/jpeg" || $tipoImg == "image/jpg" || $tipoImg == "image/png") {
					$directorioG = "../../files/platillos/";
					move_uploaded_file($_FILES['imgPla']['tmp_name'], $directorioG.$imgPla);
				} else {
					die();
				}
			}

			try {
				$validPlat = $dbConexion -> prepare("SELECT * FROM plat_menu WHERE nombre_plat = :namePla && id_platillo != :id_platillo");
				$validPlat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
				$validPlat -> bindParam("id_platillo", $id_platillo, PDO::PARAM_INT);
				$validPlat -> execute();
				$rowValidPlat = $validPlat -> rowCount();
				if ($rowValidPlat > 0) {
					echo "El platillo que intenta registrar ya se encuentra registrado";
				} else {
					$updateDat = $dbConexion -> prepare("UPDATE plat_menu SET id_categoria = :selCat, nombre_plat = :namePla, descripcion_plat = :descPla, precio_plat = :prePla, tiempo_prepare = :timePla, imagen_plat1 = :imgPla, estado_plat = :estCat WHERE id_platillo = :id_platillo");
					$updateDat -> bindParam("selCat", $selCat, PDO::PARAM_INT);
					$updateDat -> bindParam("namePla", $namePla, PDO::PARAM_STR);
					$updateDat -> bindParam("descPla", $descPla, PDO::PARAM_STR);
					$updateDat -> bindParam("prePla", $prePla, PDO::PARAM_STR);
					$updateDat -> bindParam("timePla", $timePla, PDO::PARAM_STR);
					$updateDat -> bindParam("imgPla", $imgPla, PDO::PARAM_STR);
					$updateDat -> bindParam("estCat", $estCat, PDO::PARAM_INT);
					$updateDat -> bindParam("id_platillo", $id_platillo, PDO::PARAM_INT);
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

		default:
			$dbConexion = null;
			break;
	}

}
