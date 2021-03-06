<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Mailer;
use \Hcode\Model;

class User extends Model {

	const SESSION = "User";
	const SECRET = "HcodePhp7_Secret";
	const SECRET_IV = "HcodePhp7_Secret_IV";
	const ERROR = "UserError";
	const ERROR_REGISTER = "UserErrorRegister";
	const SUCCESS = "UserSucesss";

	public static function getFromSession() {

		$user = new User();
		if (isset($_SESSION[User::SESSION]) && (int) $_SESSION[User::SESSION]['iduser'] > 0) {
			$user->setData($_SESSION[User::SESSION]);
		}
		return $user;

	}

	public static function checkLogin($inadmin = true) {

		if (
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int) $_SESSION[User::SESSION]["iduser"] > 0
		) {
			//Nenhum usuário logado
			return false;
		} else {
			if ($inadmin === true && (bool) $_SESSION[User::SESSION]["inadmin"] === true) {
				//Logado como administrador
				return true;
			} else if ($inadmin === false) {
				//Logado como cliente
				return true;
			} else {
				//Nenhum usuário logado
				return false;
			}
		}

	}

	public static function login($login, $password) {

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN" => $login,
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível fazer login.");
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"]) === true) {
			$user = new User();
			$data['desperson'] = utf8_encode($data['desperson']);
			$user->setData($data);
			$_SESSION[User::SESSION] = $user->getValues();
			return $user;
		} else {
			throw new \Exception("Não foi possível fazer login.");
		}

	}

	public static function verifyLogin($inadmin = true) {

		if (!User::checkLogin($inadmin)) {
			if ($inadmin) {
				header("Location: /admin/login");
				exit;
			} else {
				header("Location: /login");
				exit;
			}
			exit;
		}

	}

	public static function logout() {

		$_SESSION[User::SESSION] = NULL;

	}

	public static function listAll() {

		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_users ORDER BY desperson");

	}

	public function save() {

		$sql = new Sql();
		$results = $sql->select("CALL sp_users_save(:desperson, :desemail, :deslogin, :despassword, :inadmin, :nrphone)", array(
			":desperson" => utf8_decode($this->getdesperson()),
			":desemail" => $this->getdesemail(),
			":deslogin" => $this->getdeslogin(),
			":despassword" => User::getPasswordHash($this->getdespassword()),
			":inadmin" => $this->getinadmin(),
			":nrphone" => $this->getnrphone(),
		));

		$this->setData($results[0]);

	}

	public function get($iduser) {

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users WHERE iduser = :iduser", array(
			":iduser" => $iduser,
		));

		$data = $results[0];
		$data['desperson'] = utf8_encode($data['desperson']);
		$this->setData($data);

	}

	public function update() {

		$sql = new Sql();
		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :desemail, :deslogin, :despassword, :inadmin, :nrphone)", array(
			":iduser" => $this->getiduser(),
			":desperson" => utf8_decode($this->getdesperson()),
			":desemail" => $this->getdesemail(),
			":deslogin" => $this->getdeslogin(),
			":despassword" => $this->getdespassword(),
			":inadmin" => $this->getinadmin(),
			":nrphone" => $this->getnrphone(),
		));
		$this->setData($results[0]);
		//$_SESSION[User::SESSION] = $this->getValues();
		
	}

	public function delete() {

		$sql = new Sql();
		$sql->query("CALL sp_users_delete(:iduser)", array(
			":iduser" => $this->getiduser(),
		));

	}

	public static function getForgot($email, $inadmin = true) {

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users WHERE desemail = :email;", array(
			":email" => $email,
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível recuperar a senha!");
		} else {
			$data = $results[0];
			$resultRecovery = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
				":iduser" => $data["iduser"],
				":desip" => $_SERVER["REMOTE_ADDR"],
			));

			if (count($resultRecovery) === 0) {
				throw new \Exception("Não foi possível recuperar a senha!");
			} else {
				$dataRecovery = $resultRecovery[0];
				$code = openssl_encrypt($dataRecovery['idrecovery'], 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

				$code = base64_encode($code);

				if ($inadmin === true) {
					$link = "http://www.narsi.com.br/admin/forgot/reset?code=$code";
				} else {
					$link = "http://www.narsi.com.br/forgot/reset?code=$code";
				}

				$mailer = new Mailer($data['desemail'], $data['desperson'], "Redefinir senha da N@rsi Store", "forgot", array(
					"name" => $data['desperson'],
					"link" => $link,
				));

				$mailer->send();
				return $link;

			}
		}
	}

	public static function validForgotDecrypt($code) {

		$code = base64_decode($code);
		$idrecovery = openssl_decrypt($code, 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));
		$sql = new Sql();
		$results = $sql->select("
			SELECT * FROM tb_userspasswordsrecoveries a 
			INNER JOIN tb_users b USING(iduser) 
			WHERE a.idrecovery = :idrecovery 
			AND a.dtrecovery IS NULL 
			AND DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();", array(
			":idrecovery" => $idrecovery,
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível recuperar a senha.");
		} else {
			return $results[0];
		}

	}

	public static function setForgotUsed($idrecovery) {

		$sql = new Sql();
		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(
			":idrecovery" => $idrecovery,
		));

	}

	public function setPassword($password) {

		$sql = new Sql();
		$sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
			":password" => $password,
			":iduser" => $this->getiduser(),
		));

	}

	public static function setError($msg) {

		$_SESSION[User::ERROR] = $msg;

	}

	public static function getError() {

		$msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';
		User::clearError();

		return $msg;

	}

	public static function clearError() {

		$_SESSION[User::ERROR] = NULL;

	}

	public static function setSuccess($msg) {

		$_SESSION[User::SUCCESS] = $msg;

	}

	public static function getSuccess() {

		$msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : '';
		User::clearSuccess();

		return $msg;

	}

	public static function clearSuccess() {

		$_SESSION[User::SUCCESS] = NULL;

	}

	public static function setErrorRegister($msg) {

		$_SESSION[User::ERROR_REGISTER] = $msg;

	}

	public static function getErrorRegister() {

		$msg = (isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER]) ? $_SESSION[User::ERROR_REGISTER] : '';
		User::clearErrorRegister();

		return $msg;

	}

	public static function clearErrorRegister() {

		$_SESSION[User::ERROR_REGISTER] = NULL;

	}

	public static function checkLoginExist($login) {

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :deslogin", [
			':deslogin' => $login,
		]);

		return (count($results) > 0);

	}

	public static function getPasswordHash($password) {

		return password_hash($password, PASSWORD_DEFAULT, [
			'cost' => 12,
		]);

	}

	public function getOrders() {

		$sql = new Sql();
		$results = $sql->select("
			SELECT * FROM tb_orders a 
			INNER JOIN tb_ordersstatus b USING(idstatus) 
			INNER JOIN tb_carts c USING(idcart)
			INNER JOIN tb_users d ON d.iduser = a.iduser
			INNER JOIN tb_addresses e USING(idaddress)
			WHERE a.iduser = :iduser
		", [
			':iduser'=>$this->getiduser()
		]);

		return $results;

	}

	public function getAddress() {

		$sql = new Sql();
		$results = $sql->select("
			SELECT * FROM tb_addresses a 
			INNER JOIN tb_users b ON b.iduser = a.iduser
			WHERE a.iduser = :iduser
		", [
			':iduser'=>$this->getiduser()
		]);

		return $results;

	}

	public function checkPhoto() {

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
			"res" . DIRECTORY_SEPARATOR .
			"admin" . DIRECTORY_SEPARATOR .
			"img" . DIRECTORY_SEPARATOR .
			"users" . DIRECTORY_SEPARATOR .
			"user_" . $this->getiduser() . ".jpg"
			)) {

			$url = "/res/admin/img/users/user_" . $this->getiduser() . ".jpg";

		} else {

			$url = "/res/admin/img/users/user.jpg";

		}

		$this->setdesphoto($url);
	
	}

	public function getValues() {

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}

	public function setPhoto($file) {

		$extension = explode('.', $file['name']);
		$extension = end($extension);

		switch ($extension) {
		case "jpg":
		case "jpeg":
			$image = imagecreatefromjpeg($file['tmp_name']);
			break;
		case "gif":
			$image = imagecreatefromgif($file['tmp_name']);
			break;
		case "png":
			$image = imagecreatefrompng($file['tmp_name']);
			break;

		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
		"res" . DIRECTORY_SEPARATOR .
		"admin" . DIRECTORY_SEPARATOR .
		"img" . DIRECTORY_SEPARATOR .
		"users" . DIRECTORY_SEPARATOR .
		"user_" . $this->getiduser() . ".jpg";

		imagejpeg($image, $dist);
		imagedestroy($image);

		$this->checkPhoto();

	}

	public static function getPage($page = 1, $itemsPerPage = 10) {

		$start = ($page - 1) * $itemsPerPage;
		$sql = new Sql();
		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_users 
			ORDER BY desperson
			LIMIT $start, $itemsPerPage;
		");
		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}

	public static function getPageSearch($search, $page = 1, $itemsPerPage = 10) {

		$start = ($page - 1) * $itemsPerPage;
		$sql = new Sql();
		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_users 
			WHERE desperson LIKE :search OR desemail LIKE :search OR deslogin LIKE :search
			ORDER BY desperson
			LIMIT $start, $itemsPerPage;
		", [
			':search'=>'%'.$search.'%'
		]);
		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	} 

}

?>