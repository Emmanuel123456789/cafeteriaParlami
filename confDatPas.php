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

		case 'regemp':
			
			$nameUs = isset($_POST['nameUs']) ? trim($_POST['nameUs']) : "";
			$corUs = isset($_POST['corUs']) ? trim($_POST['corUs']) : "";
			$userUs = isset($_POST['userUs']) ? trim($_POST['userUs']) : "";
			$pasUs = isset($_POST['pasUs']) ? trim($_POST['pasUs']) : "";
			$pasUs = md5($pasUs);

			try {
				$validCurp = $dbConexion -> prepare("SELECT * FROM admin WHERE correo_adm = :corUs && id_admin != :keyAdm");
				$validCurp -> bindParam("corUs", $corUs, PDO::PARAM_STR);
				$validCurp -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
				$validCurp -> execute();
				$rowValidCurp = $validCurp -> rowCount();
				if ($rowValidCurp == 1) {
					echo "El correo ya se encuentra registrado";
				} else {
					$validPhone = $dbConexion -> prepare("SELECT * FROM admin WHERE usuario_adm = :userUs && id_admin != :keyAdm");
					$validPhone -> bindParam("userUs", $userUs, PDO::PARAM_STR);
					$validPhone -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
					$validPhone -> execute();
					$rowValidPhone = $validPhone -> rowCount();
					if ($rowValidPhone == 1) {
						echo "El usuario ya se encuentra registrado";
					} else {
						$privileg = "LIM";
						$insertData = $dbConexion -> prepare("INSERT INTO admin (nombre_adm, correo_adm, usuario_adm, password, privilegio_adm, fecha_reg) VALUES (:nameUs, :corUs, :userUs, :pasUs, :privileg, :fechAct)");
						$insertData -> bindParam("nameUs", $nameUs, PDO::PARAM_STR);
						$insertData -> bindParam("corUs", $corUs, PDO::PARAM_STR);
						$insertData -> bindParam("userUs", $userUs, PDO::PARAM_STR);
						$insertData -> bindParam("pasUs", $pasUs, PDO::PARAM_STR);
						$insertData -> bindParam("privileg", $privileg, PDO::PARAM_STR);
						$insertData -> bindParam("fechAct", $fechAct, PDO::PARAM_STR);
						$insertData -> execute();
						if ($insertData) {
							echo 1;
						} else {
							echo "Fallo la actualización";
						}
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'changepass':

			$passAct = isset($_POST['passAct']) ? trim($_POST['passAct']) : "";
			$newPass = isset($_POST['newPass']) ? trim($_POST['newPass']) : "";
			$passAct = md5($passAct); 
			$newPass = md5($newPass);
			try {
				$validPass = $dbConexion -> prepare("SELECT * FROM admin WHERE password = :passAct AND id_admin = :keyAdm");
				$validPass -> bindParam("passAct", $passAct, PDO::PARAM_STR);
				$validPass -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
				$validPass -> execute();
				$rowValidPass = $validPass -> rowCount();
				if ($rowValidPass == 1) {
					$updPass = $dbConexion -> prepare("UPDATE admin SET password = :newPass WHERE id_admin = :keyAdm");
					$updPass -> bindParam("newPass", $newPass, PDO::PARAM_STR);
					$updPass -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
					$updPass -> execute();
					if ($updPass) {
						echo 1;
					} else {
						echo "Fallo la actualización";
					}
				} else {
					echo "La contraseña actual es incorrecta";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'changepassemp':

			$id_empleado = isset($_POST['id_empleado']) ? trim($_POST['id_empleado']) : "";
			$passAct = isset($_POST['passAct']) ? trim($_POST['passAct']) : "";
			$newPass = isset($_POST['newPass']) ? trim($_POST['newPass']) : "";
			$passAct = md5($passAct); 
			$newPass = md5($newPass);
			try {
				$validPass = $dbConexion -> prepare("SELECT * FROM admin WHERE password = :passAct AND id_admin = :keyAdm");
				$validPass -> bindParam("passAct", $passAct, PDO::PARAM_STR);
				$validPass -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
				$validPass -> execute();
				$rowValidPass = $validPass -> rowCount();
				if ($rowValidPass == 1) {
					$updPass = $dbConexion -> prepare("UPDATE admin SET password = :newPass WHERE id_admin = :id_empleado");
					$updPass -> bindParam("newPass", $newPass, PDO::PARAM_STR);
					$updPass -> bindParam("id_empleado", $id_empleado, PDO::PARAM_INT);
					$updPass -> execute();
					if ($updPass) {
						echo 1;
					} else {
						echo "Fallo la actualización";
					}
				} else {
					echo "La contraseña actual es incorrecta";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}
			break;

		case 'changedata':
			
			$nameUs = isset($_POST['nameUs']) ? trim($_POST['nameUs']) : "";
			$corUs = isset($_POST['corUs']) ? trim($_POST['corUs']) : "";
			$userUs = isset($_POST['userUs']) ? trim($_POST['userUs']) : "";
			$pasUs = isset($_POST['pasUs']) ? trim($_POST['pasUs']) : "";
			$pasUs = md5($pasUs);

			try {
				$validCurp = $dbConexion -> prepare("SELECT * FROM admin WHERE correo_adm = :corUs && id_admin != :keyAdm");
				$validCurp -> bindParam("corUs", $corUs, PDO::PARAM_STR);
				$validCurp -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
				$validCurp -> execute();
				$rowValidCurp = $validCurp -> rowCount();
				if ($rowValidCurp == 1) {
					echo "El correo ya se encuentra registrado";
				} else {
					$validPhone = $dbConexion -> prepare("SELECT * FROM admin WHERE usuario_adm = :userUs && id_admin != :keyAdm");
					$validPhone -> bindParam("userUs", $userUs, PDO::PARAM_STR);
					$validPhone -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
					$validPhone -> execute();
					$rowValidPhone = $validPhone -> rowCount();
					if ($rowValidPhone == 1) {
						echo "El usuario ya se encuentra registrado";
					} else {
						$validPass = $dbConexion -> prepare("SELECT * FROM admin WHERE password = :pasUs && id_Admin = :keyAdm");
						$validPass -> bindParam("pasUs", $pasUs, PDO::PARAM_STR);
						$validPass -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
						$validPass -> execute();
						$rowValidPass = $validPass -> rowCount();
						if ($rowValidPass == 1) {
							$updData = $dbConexion -> prepare("UPDATE admin SET nombre_adm = :nameUs, correo_adm = :corUs, usuario_adm = :userUs WHERE id_admin = :keyAdm");
							$updData -> bindParam("nameUs", $nameUs, PDO::PARAM_STR);
							$updData -> bindParam("corUs", $corUs, PDO::PARAM_STR);
							$updData -> bindParam("userUs", $userUs, PDO::PARAM_STR);
							$updData -> bindParam("keyAdm", $keyAdm, PDO::PARAM_STR);
							$updData -> execute();
							if ($updData) {
								echo 1;
							} else {
								echo "Fallo la actualización";
							}
						} else {
							echo "La contraseña ingresada es incorrecta";
						}
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;
		
		case 'desEmp':

			$clvEmp = isset($_POST['clvEmp']) ? trim($_POST['clvEmp']) : "";
			$desact = 0;
			try {
				$update = $dbConexion -> prepare("UPDATE admin SET est_cuenta_adm = :desact WHERE id_admin = :clvEmp");
				$update -> bindParam("desact", $desact, PDO::PARAM_INT);
				$update -> bindParam("clvEmp", $clvEmp, PDO::PARAM_INT);
				$update -> execute();
				if ($update) {
					echo 1;
				} else {
					echo "Fallo la desactivación";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'actEmp':

			$clvEmp = isset($_POST['clvEmp']) ? trim($_POST['clvEmp']) : "";
			$active = 1;
			try {
				$update = $dbConexion -> prepare("UPDATE admin SET est_cuenta_adm = :active WHERE id_admin = :clvEmp");
				$update -> bindParam("active", $active, PDO::PARAM_INT);
				$update -> bindParam("clvEmp", $clvEmp, PDO::PARAM_INT);
				$update -> execute();
				if ($update) {
					echo 1;
				} else {
					echo "Fallo la activación";
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			} finally {
				$dbConexion = null;
			}

			break;

		case 'changepassuser':
			$clvUser = isset($_POST['clvUser']) ? trim($_POST['clvUser']) : "";
			$passAct = isset($_POST['passAct']) ? trim($_POST['passAct']) : "";
			$newPass = isset($_POST['newPass']) ? trim($_POST['newPass']) : "";
			$passAct = md5($passAct); 
			$newPass = md5($newPass);
			try {
				$validPass = $dbConexion -> prepare("SELECT * FROM usuarios WHERE pass = :passAct AND id_usuario = :keyAdm");
				$validPass -> bindParam("passAct", $passAct, PDO::PARAM_STR);
				$validPass -> bindParam("keyAdm", $keyAdm, PDO::PARAM_INT);
				$validPass -> execute();
				$rowValidPass = $validPass -> rowCount();
				if ($rowValidPass == 1) {
					$updPass = $dbConexion -> prepare("UPDATE usuarios SET pass = :newPass WHERE id_usuario = :clvUser");
					$updPass -> bindParam("newPass", $newPass, PDO::PARAM_STR);
					$updPass -> bindParam("clvUser", $clvUser, PDO::PARAM_INT);
					$updPass -> execute();
					if ($updPass) {
						echo 1;
					} else {
						echo "Fallo la actualización";
					}
				} else {
					echo "La contraseña actual es incorrecta";
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
