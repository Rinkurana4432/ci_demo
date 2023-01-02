<?php   
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $obj_pdf->SetCreator(PDF_CREATOR);  
    $obj_pdf->SetTitle("BOM Routing");  
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
	#$company_data = getNameById('company_detail',$dataPdf->created_by,'id');
	#$company_data = getNameById('company_detail',$dataPdf->created_by_cid,'id');
	#pre($company_data); die;
	#$companyLogo = base_url().'assets/modules/company/uploads/'.$company_data->logo;
	
	/* $obj_pdf->Image($companyLogo,2,4,10,10,'PNG');
	$imagesign = base_url().'assets/modules/crm/uploads/signature5c0b5d8fa371e.png';
	$obj_pdf->Image($imagesign,2,4,10,10,'PNG');
						
    $supplierName=getNameById('supplier',$dataPdf->supplier_name,'id');	
    $state= getNameById('state',$supplierName->state,'state_id'); */
    $obj_pdf->AddPage(); 
    $content = ''; 
	$content .=  '<style>'.file_get_contents(base_url("assets/css/style.css")).'</style>';
    $content .= '<div class="col-md-12 col-sm-12 col-xs-12" id="print_divv"  style="padding:0px;"> 
	<div class="table-responsive" >
		<h3 class="Material-head">BOM Routing<hr></h3>
		<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">BOM Routing Number :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div></div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">BOM Routing Product Name :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div ><b></b></div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Party Code :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div ></div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Process Type :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">Product specification :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">Material Type :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
				 
					<div></div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">Lot Quantity :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div></div>
				</div>
			</div>				 
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <label for="material">Test Certificate :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div></div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 form-group">
				<label for="material">Party requirement :</label>
				<div class="col-md-7 col-sm-12 col-xs-12 form-group">
					<div></div>
				</div>
			</div>
		</div>		  
	<hr>
	<div class="bottom-bdr"></div>		  
	<div class="container mt-3">
		<div class="well" id="chkIndex_1" style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">	
			<div class="label-box">
				<div class="col-md-12" style="padding: 0px; border-left: 1px solid #c1c1c1;"><label style="background: #f5f5f5;font-size: 16px;">Material Details</label></div>
					<div class="col-md-4 col-sm-12 col-xs-12 form-group" style="border-left: 1px solid #c1c1c1;"><label>Material name</label></div>
					<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>Qauntity</label></div>			   
					<div class="col-md-4 col-sm-12 col-xs-12 form-group"><label>UOM</label></div>			   
			</div>
			
			<div class="row-padding">
			    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
					<div style="border-left:1px solid #c1c1c1 !important;" class="tab-div"></div>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 form-group">
					<div  class="tab-div"></div>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 form-group">
					<div  class="tab-div"></div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="container mt-3">
		
        <div class="Process-card">											
		<h3 class="Material-head"><div class="test-hadding">Process Name : <p></p></div><hr></h3>										 
		<div style="overflow:auto; padding:0px; border-radius: 0px !important; margin-top: 15px;">
          	<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<label >Shift :</label>
					<div class="col-md-7" ></div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group">
					<label>Machine Name :</label>
					<div  class="col-md-7">
						
					</div>
				</div>																				 
			</div>
			<div class="col-md-6 label-left" style=" padding:0px; margin-bottom:20px;">
			        <div class="col-md-12 col-sm-12 form-group">
					 <label>Workers :</label>
					  <div  class="col-md-7"></div>
									
					 </div>
					 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					 <label>Description :</label>
					 <div  class="col-md-7"></div>
					 </div>
			</div>
		</div>
		<div class="col-md-12 col-xs-12 col-sm-12" id="chkIndex_1" style=" padding:0px; border-radius: 0px !important; margin-bottom: 15px;">	
			
		</div>
		<div class="col-md-12" > 
			<div class="col-md-6 label-left" style=" margin-bottom:20px; border-right: 1px solid;" >									
               <label style="width: 100%; text-align: center;">Dos </label>
			    <div class="col-md-12">
					<div></div>
				</div>
			</div>
			<div class="col-md-6 label-left" style="  margin-bottom:20px;"  >
                <label style="width: 100%;   text-align: center;">Donts </label>				
				<div class=" col-md-12">
					<div></div>
				</div>
			</div>
		</div>
		
		<div class="col-md-8 col-xs-12 col-sm-12 " style="margin-top: 12px;" >						 
			<div class="col-md-12 label-left">
					<label style="width: auto;padding-top: 12px;font-size: 15px;">Attachments :</label>	
					<div class="col-md-6 col-xs-12 col-sm-12"> 
						
					</div>		
			</div>
		</div>
		
		</div>
		

	</div>	
	</div>
</div>';
    
    
			
    $obj_pdf->writeHTML($content); 
	ob_end_clean();	
  $obj_pdf->Output('sample.pdf', 'I');   
 ?> 