<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class Address extends Model {

	const SESSION_SUCCESS = "AddressSuccess";
	const SESSION_ERROR = "AddressError";

	public static function getCEP($nrcep) {

		$nrcep = str_replace("-", "", $nrcep);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://viacep.com.br/ws/$nrcep/json/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = json_decode(curl_exec($ch), true);
		curl_close($ch);

		return $data;

	}

	public function loadFromCEP($nrcep) {

		$data = Address::getCEP($nrcep);
		if (isset($data['logradouro']) && $data['logradouro']) {
			$this->setdesaddress($data['logradouro']);
			$this->setdescomplement($data['complemento']);
			$this->setdesdistrict($data['bairro']);
			$this->setdescity($data['localidade']);
			$this->setdesstate($data['uf']);
			$this->setdescountry('Brasil');
			$this->setdeszipcode($nrcep);
		}

	}

	public function get(int $idaddress) {

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_addresses WHERE idaddress = :idaddress", [
			":idaddress" => $idaddress,
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public static function listAll() {

		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_addresses ORDER BY desidentifier");

	}

	public function save() {

		$sql = new Sql();
		$results = $sql->select("CALL sp_addresses_save(:iduser, :desidentifier, :desaddress, :desnumber, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)", array(
			':iduser' => $this->getiduser(),
			':desidentifier' => $this->getdesidentifier(),
			':desaddress' => $this->getdesaddress(),
			':desnumber' => $this->getdesnumber(),
			':descomplement' => $this->getdescomplement(),
			':descity' => $this->getdescity(),
			':desstate' => $this->getdesstate(),
			':descountry' => $this->getdescountry(),
			':deszipcode' => $this->getdeszipcode(),
			':desdistrict' => $this->getdesdistrict(),
		));

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function update() {

		$sql = new Sql();
		$results = $sql->select("CALL sp_addressesupdate_save(:idaddress, :iduser, :desidentifier, :desaddress, :desnumber, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)", array(
			':idaddress' => $this->getidaddress(),
			':iduser' => $this->getiduser(),
			':desidentifier' => $this->getdesidentifier(),
			':desaddress' => $this->getdesaddress(),
			':desnumber' => $this->getdesnumber(),
			':descomplement' => $this->getdescomplement(),
			':descity' => $this->getdescity(),
			':desstate' => $this->getdesstate(),
			':descountry' => $this->getdescountry(),
			':deszipcode' => $this->getdeszipcode(),
			':desdistrict' => $this->getdesdistrict(),
		));

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public static function setMsgError($msg) {

		$_SESSION[Address::SESSION_ERROR] = $msg;

	}

	public static function getMsgError() {

		$msg = (isset($_SESSION[Address::SESSION_ERROR])) ? $_SESSION[Address::SESSION_ERROR] : "";
		Address::clearMsgError();

		return $msg;

	}

	public static function clearMsgError() {

		$_SESSION[Address::SESSION_ERROR] = NULL;

	}

	public static function setMsgSuccess($msg) {

		$_SESSION[Address::SESSION_SUCCESS] = $msg;

	}

	public static function getMsgSuccess() {

		$msg = (isset($_SESSION[Address::SESSION_SUCCESS]) && $_SESSION[Address::SESSION_SUCCESS]) ? $_SESSION[Address::SESSION_SUCCESS] : '';
		Address::clearMsgSuccess();

		return $msg;

	}

	public static function clearMsgSuccess() {

		$_SESSION[Address::SESSION_SUCCESS] = NULL;

	}

}

?>