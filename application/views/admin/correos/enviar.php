<?php
switch ($encuesta){
	case 1 : 
		$titulo = "Evaluación Clima Laboral";
	break;
	case 2 : 
		$titulo = "Evaluación al Desempeño (DNC)";
	break;
	case 3 : 
		$titulo = "Encuesta de Satisfacción de Usuarios SIGC";
	break;
	case 4 : 
		$titulo = "Encuesta de Satisfacción de Usuarios SIBIB(Solo usuarios pertenecientes al SIBIB)";
	break;
	case 5 : 
		$titulo = "Registro de Infraestructura";
	break;
}
require_once('includes/class.phpmailer.php');
		
	$email_subject = 'Coordinacion de Calidad Actividades en el SIGC';
	$email_body = "<p>Por medio de la presente nos permitimos informarle que la <strong> ".$titulo."&nbsp;".$observaciones." a partir de ".$fecha;
	$email_body.="</strong> </p> Agradeciendo su apoyo para mantener vigente el Sistema De Calidad.<strong>";
	$email_body.="<br> Atte </br> Coordinacion de Calidad UJED";
	$mail = new PHPMailer;

	$mail->IsSMTP();                                          // Set mailer to use SMTP
	$mail->Host     = 'correo.ujed.mx';                       // Specify main and backup server (gmail: 'sl://smtp.gmail.com')
	$mail->Port     = 25;                                     // Set the SMTP port (gmail: 465)
	$mail->SMTPAuth = true;                                   // Enable SMTP authentication
	$mail->Username = 'no.reply@correo.ujed.mx';              // SMTP username
	$mail->Password = 'u7yR$';                                // SMTP password
//  $mail->SMTPSecure = 'tls';                                // Enable encryption, 'ssl' also accepted
	if($jefes->num_rows() > 0){
		foreach($jefes->result() as $row){*/
			$mail->From     = 'no.reply@correo.ujed.mx';
			$mail->FromName = 'Coordinacion de Calidad';
			$mail->AddReplyTo( 'reply@to.com' );
			$mail->AddAddress($row->Correo,$row->Nombre);  		// Add a recipient
			$mail->AddBCC('ccontroldocumental@gmail.com');
			$mail->AddBCC('coordinacioncalidadujed@gmail.com');
			$mail->AddBCC('iscalmeda@gmail.com');
			$mail->WordWrap = 50;                                     // Set word wrap to 50 characters
			$mail->IsHTML(true);                                      // Set email format to HTML

			$mail->Subject  = '=?UTF-8?B?'.base64_encode( $email_subject ).'?=';
			$mail->Body     = $email_body;
		}
	}*/
			if ( !$mail->Send() ) {
				echo 'error';
				exit;
			}
		
?>*/