<?php 

namespace Hcode;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Rain\Tpl;

class Mailer {
	
	const USERNAME = "email aqui";
	const PASSWORD = "email aqui";
	const NAME_FROM = "Hcode Store";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	    );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		$this->mail = new PHPMailer(true);
		$this->mail->isSMTP();
		$this->mail->SMTPOptions = array(
			'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			    'allow_self_signed' => true
			 )
			); 
		$this->mail->SMTPDebug = SMTP::DEBUG_OFF;
		$this->mail->Host = 'smtp.gmail.com';
		$this->mail->Port = 587;
		$this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$this->mail->SMTPAuth = true;
		$this->mail->Username = Mailer::USERNAME;
		$this->mail->Password = Mailer::PASSWORD;
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
		$this->mail->addAddress($toAddress, $toName);
		$this->mail->Subject = $subject;
		$this->mail->msgHTML($html);

		}

	public function send()
	{

		return $this->mail->send();

	}

}

 ?>