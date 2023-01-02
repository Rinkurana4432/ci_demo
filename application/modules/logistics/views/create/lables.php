<?php   
    //$pdf->setPageOrientation('L');
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
    // page with custom size rotated clockwise 270 deg.
     //$obj_pdf = new TCPDF('L', 'pt', ['format' => [$width, $height], 'Rotate' => 270]); 
    //$obj_pdf = new TCPDF('L', 'pt', ['format' => 'A4', 'Rotate' => 90]);
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("PURCHASE ORDER");  
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);	  
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $obj_pdf->SetDefaultMonospacedFont('helvetica');  
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
    $obj_pdf->setPrintHeader(false);  
    $obj_pdf->setPrintFooter(false);   
    $obj_pdf->SetAutoPageBreak(TRUE, 10);  
    $obj_pdf->SetFont('helvetica', '', 9);
// pre($dataPdf);
// die();	
 

	$companyLogo = ''; 
	$obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
    $obj_pdf->AddPage(); 
  	setlocale(LC_MONETARY, 'en_IN');
    $content = ''; 
	#echo $companyLogo; die;
 

	 
 $content .= '
<!DOCTYPE html>
<html>
<head>
      <title>Page Title</title>
   </head>
   <body>
      <div >
	   <table style="width: 550px;display: table;margin-bottom: 22px; border-spacing: 5px;">
	   <tr style="margin-bottom:20px;">
         <td style="float: left;font-family: Arial, Helvetica, sans-serif;align-content: center;align-items: center;padding: 10px;border-radius: 4px;margin: 5px; border: 2px solid #000;">
            <table style="width: 100%;">
			  <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Code:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span style="float: right;">312313</span>  </td>            
			   </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span >Test</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Quantity:</h2></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>4</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Cartoon No:</h4></td>
                   <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>(B)52</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="width: 40%;margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Party Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>SILIGURI/31.12.21</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Dispatched Date:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>1.12.21</span></td>
               </tr>
            </table>
         </td>
         <td style="float: left;font-family: Arial, Helvetica, sans-serif;align-content: center;align-items: center;padding: 10px;border-radius: 4px;margin: 5px; border: 2px solid #000;">
            <table style="width: 100%;">
			  <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Code:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span style="float: right;">312313</span>  </td>            
			   </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span >Test</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Quantity:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>4</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Cartoon No:</h4></td>
                   <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>(B)52</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="width: 40%;margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Party Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>SILIGURI/31.12.21</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Dispatched Date:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>1.12.21</span></td>
               </tr>
            </table>
         </td>
		 </tr>
		 <tr>
         <td style="float: left;font-family: Arial, Helvetica, sans-serif;align-content: center;align-items: center;padding: 10px;border-radius: 4px;margin: 5px; border: 2px solid #000;">
            <table style="width: 100%;">
			  <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Code:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span style="float: right;">312313</span>  </td>            
			   </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span >Test</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Quantity:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>4</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Cartoon No:</h4></td>
                   <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>(B)52</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="width: 40%;margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Party Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>SILIGURI/31.12.21</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Dispatched Date:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>1.12.21</span></td>
               </tr>
            </table>
         </td>
         <td style="float: left;font-family: Arial, Helvetica, sans-serif;align-content: center;align-items: center;padding: 10px;border-radius: 4px;margin: 5px; border: 2px solid #000;">
            <table style="width: 100%;">
			  <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Code:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span style="float: right;">312313</span>  </td>            
			   </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Product Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span >Test</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                  <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Quantity:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>4</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Cartoon No:</h4></td>
                   <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>(B)52</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="width: 40%;margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Party Name:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>SILIGURI/31.12.21</span></td>
               </tr>
               <tr style="align-content: center;align-items: center;margin-bottom: 6px !important;overflow: hidden;">
                   <td style="padding:3px 5px;"><h4 style="margin: 0px 0px;font-weight: bold;font-size: 13px;float: left;">Dispatched Date:</h4></td>
                  <td style="text-align:right;padding:3px 5px;font-size: 13px;"><span>1.12.21</span></td>
               </tr>
            </table>
         </td>
		 </tr>
		 </table>
         
      </div>
      
   
</body></html>'; 
				
 
$obj_pdf->setPageOrientation('L');

 $obj_pdf->writeHTML($content);  
 ob_end_clean();	
 $obj_pdf->Output('PurchaseOrder.pdf', 'I');   
 ?> 