<?php

namespace Hcode;

use PHPMailer\PHPMailer\PHPMailer;
use Rain\Tpl;

class Mailer {

	const USERNAME = "nelton@masterpublica.com.br";
	const PASSWORD = "N@rsiNotMP351";
	const NAMEFROM = "Master Pública";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array()) {

		$config = array(
			"tpl_dir" => $_SERVER['DOCUMENT_ROOT'] . "/views/email/",
			"cache_dir" => $_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
			"debug" => false,
		);
		Tpl::configure($config);
		$tpl = new Tpl;
		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}
		$html = $tpl->draw($tplName, true);

		$this->mail = new PHPMailer;
		$this->mail->isSMTP();
		//Ativar depuração SMTP
		//SMTP::	//USAR QUANDO ESTIVER EM PRODUÇÃO
		//SMTP:: DEBUG_CLIENT = mensagens para o cliente 		//USAR QUANDO ESTIVER EM TESTES
		//SMTP:: DEBUG_SERVER = mensagens do cliente e do servidor 		//USAR QUANDO ESTIVER EM DESENVOLVIMENTO
		$this->mail->SMTPDebug = ''; //SMTP::DEBUG_CLIENT;
		$this->mail->Host = 'smtp.zoho.com';
		$this->mail->Port = 587;
		$this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$this->mail->SMTPAuth = true;
		$this->mail->Username = Mailer::USERNAME; //'nelton@masterpublica.com.br'
		$this->mail->Password = Mailer::PASSWORD; //'N@rsiNotMP351'
		$this->mail->setFrom(Mailer::USERNAME, utf8_decode(Mailer::NAMEFROM));
		$this->mail->addAddress($toAddress, $toName);
		$this->mail->Subject = $subject;
		$this->mail->msgHTML(utf8_decode($html));
		$this->mail->AltBody = '2ª opção: Teste de envio de e-mail do curso PHP 7 utilizando a Classe PHPMailer com ZohoMail';
	}

	public function send() {
		return $this->mail->send();
	}

}

?>