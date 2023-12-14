<?php
require_once "../vendor/autoload.php";
use Dompdf\Dompdf;

class ServicioPDF {
    private $nombrePdf;
    private $contenidoHtml;

    public function __construct($nombrePdf = "documento.pdf", $contenidoHtml = "<h1>Hola Mundo</h1>") {
        $this->nombrePdf = $nombrePdf;
        $this->contenidoHtml = $contenidoHtml;
    }

    public function generar() {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->contenidoHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($this->nombrePdf, $output);

        return $this->nombrePdf;
    }
}
?>
