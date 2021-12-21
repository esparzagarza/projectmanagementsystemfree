<?php
class MailService
{

	function sendSale($file, array $ente, array $sale)
	{

		$mail = new PHPMailer();

		$mail->From     = "atencion@sistenet.mx";

		$mail->FromName = 'Soluciones Sistenet';

		$mail->AddAddress($ente['email']);

		$mail->WordWrap = 50;

		$mail->IsHTML(true);

		$mail->AddAttachment($file);

		$mail->Subject  =  $file;

		$mail->Body     =  "De acuerdo a su amable solicitud, permitame presentarle el siguiente documento adjunto";

		$mail->IsSMTP();

		$mail->Host = "sistenet.mx";

		$mail->SMTPAuth = true;

		$mail->Username = "atencion@sistenet.mx";

		$mail->Password = "Atencion_123";

		if ($mail->Send()) {

			unlink($file);

			return true;
		}

		return false;
	}
}
