<?php
use PHPMailer\PHPMailer\PHPMailer;
require "./vendor/autoload.php";

class ServicioCorreos {
    private $asunto;
    private $descripcion;
    private $destinatario;

    public function __construct($destinatario = null, $asunto = "asunto", $descripcion = "descripción") {
        $this->asunto = $asunto;
        $this->descripcion = $descripcion;
        $this->destinatario = $destinatario;
    }

    public function enviar() {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
        $mail->Username   = "emarcha466@g.educaand.es";
        $mail->Password   = "cbdo sdoz aziz tlud";
        $mail->SetFrom('emarcha466@g.educaand.es', 'Prueba');
        $mail->Subject    = $this->asunto;
        $mail->MsgHTML($this->descripcion);
        $address = $this->destinatario;
        $mail->AddAddress($address, "Yo");

        $result = $mail->Send();

        if(!$result) {
            echo "Error" . $mail->ErrorInfo;
        } else {
            echo "Correo enviado correctamente<br>";
        }
    }
}

?>