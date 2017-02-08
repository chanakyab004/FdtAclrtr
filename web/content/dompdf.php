<?php
//set_include_path(get_include_path() . PATH_SEPARATOR );

require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$variable = 'Hello world. I am using DOMPDF.';


$html =
  '<html><body>'.
  '<h1>Test '.$variable.'</h1>'.
  '</body></html>';

  $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        
        $dompdf->get_quirksmode();

        $dompdf->render();

        

        $dompdf->stream('hello',array('Attachment'=>0));//Display in Browser
       //$dompdf->stream("hello");//Direct Download

        //$dom = $dompdf->getDom();
        //$dompdf->assertEquals('', $dom->textContent);


// $dompdf->load_html($html);
// $dompdf->render();

// //$dompdf->stream("hello.pdf");Direct Download

// $dompdf->stream('hello.pdf',array('Attachment'=>0));//Display in Browser
?>