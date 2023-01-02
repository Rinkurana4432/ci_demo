<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
	<p class="text-muted font-13 m-b-30"></p>
	<?php
	setlocale(LC_MONETARY, 'en_IN.UTF-8');//Function for Indian currency format   
	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;
		$company_brnaches = getNameById('company_detail',$this->companyGroupId,'id');
		if(!empty($company_brnaches)){
	?>
	
	<form action="<?php echo site_url(); ?>account/sale_register" method="post" id="select_from_brnch">
		<div class="required item form-group company_brnch_div" >
			<label class="required control-label col-md-3 col-sm-2 col-xs-4" for="company_branch">Select Company Branch</label>
			<div class="col-md-3 col-sm-3 col-xs-12">
			<select class="itemName form-control Get_data_accoriding_tobranch" name="selected_branch_idd" name="compny_branch_id" width="100%">
				<!--option value=""> Select Company Branch </option-->
				<option Value ="All">Company Branch All</option> 
				<?php
					$branch_Add = json_decode($company_brnaches->address);
					foreach($branch_Add as $val_branch){ ?>
					<option <?php if($val_branch->add_id == $_POST['selected_branch_idd']){ ?> selected="selected" <?php }?> value="<?php echo $val_branch->add_id; ?>"><?php echo $val_branch->compny_branch_name; ?> </option>
					
				</option>
			<?php } ?>
			</select>		
						
			</div>
			<input type="hidden" value='' class='start_date' name='start'/>
			<input type="hidden" value='' class='end_date' name='end'/>
			<input type="submit" value="Filter" class="btn btn-info">
		</div>    
	</form>	
	<?php } ?>
	<br/>
	<form action="<?php echo site_url(); ?>account/sale_register" method="post" id="export-form">
		<input type="hidden" value='' id='hidden-type' name='ExportType'/>
		<input type="hidden" value='' class='start_date' name='start'/>
		<input type="hidden" value='' class='end_date' name='end'/>
	</form>
	<form action="<?php echo site_url(); ?>account/create_pdf_all" method="post" id="export-form-pdf">
		<input type="hidden" value="<?php echo $this->companyGroupId; ?>"  name="login_c_id">
		<input type="hidden" value='' class='start_date' name='start'/>
		<input type="hidden" value='' class='end_date' name='end'/>
	</form>
	<form action="<?php echo base_url(); ?>account/sale_register" method="post" id="date_range">	
		 <input type="hidden" value='' class='start_date' name='start'/>
		 <input type="hidden" value='' class='end_date' name='end'/>  
	</form>
<div class="row hidde_cls">
	<div class="col-md-12 export_div">
		<div class="col-md-4">
		<fieldset>
			<div class="control-group">
			  <div class="controls">
				<div class="input-prepend input-group">
				  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
				  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value=""  data-table="account/sale_register"/>
				</div>
			  </div>  
			</div>
		  </fieldset>
		</div>
		<div class="col-md-4">
			<div class="btn-group"  role="group" aria-label="Basic example">
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
				<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel"><a href="javascript:void();" title="Please check your open office Setting">Export to excel</a></li>
							<li id="export-to-csv"><a href="javascript:void();" title="Please check your open office Setting">Export to csv</a></li>
							<!--li id="export-to-pdf"><a href="javascript:void();" title="Please check your open office Setting">Export to Pdf</a></li-->
						</ul>
				</div>
				<!--<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export">
					<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Company Branch <span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu" id="export-menu">
							<li id="export-to-excel">
							<a href="javascript:void();" title="Please check your open office Setting">Export to excel</a>
							</li>
							
							
						</ul>
				</div>-->
			</div>
		</div>
	</div>
</div>
  <div id="print_div_content">	
 
         <table id="example" class="table table-striped table-bordered get_Data_fortbl" data-id="account"  border="1"  data-order='[[1,"desc"]]'> 		
			<thead>
			<tr>
				<th>Id</th>
				<th>Material</th>
				<th>Party Name</th>
				<th>Total</th>
				<th>Tax</th>
				<th>Amount With Tax</th>
				<th>Quantity</th>
				<th>Paid or Not</th>
				<th>Created By</th>
				<th>Voucher Date</th>				
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
		
		   <?php 

		   if(!empty($saleReg_Data)){
			  
				$sum_tax = $sum_total = $sum_total_with_tax = 0;
				
				
			   foreach($saleReg_Data as $invoice){
				  //pre($invoice);
				$action = '';
			
					$action .=  '<a href="javascript:void(0)" id="'. $invoice["id"] . '" data-id="sale_ledger_details" class="sale_ledger_details btn btn-warning btn-xs" id="' . $invoice["id"] . '"><i class="fa fa-eye"></i> View </a>';
					
					
					$edited_by = ($invoice['edited_by']!=0)?(getNameById('user_detail',$invoice['edited_by'],'u_id')->name):'';
					
					
					
					$material_id_datas = json_decode($invoice['descr_of_goods'],true);
					
					if($material_id_datas == ''){
						
					}else{
						$material_names = '';
						foreach($material_id_datas  as $matrial_new_id){
							$material_id_get = $matrial_new_id['material_id'];
							@$material_name = ($material_id_get!=0)?(getNameById('material',$material_id_get,'id')->material_name):'';
							@$material_names1 .= $material_name.',';
							@$material_names .= '<a href="javascript:void(0)" id="'.$material_id_get.'" data-id="material_view" class="inventory_tabs"> '.$material_name.'</a>,';
						
						}
					}

					$party_name = getNameById('ledger',$invoice['party_name'],'id');
					$sale_ledger_name = getNameById('ledger',$invoice['sale_ledger'],'id');
					
					if($invoice['pay_or_not'] =='1'){
						$paid_or_not =  'Paid';
					}else{
						$paid_or_not = 'Not Paid';
					}
					$descr_of_goods_qty_rate_tax = json_decode($invoice['descr_of_goods']);
					
					
					$total_tax_dtl = json_decode($invoice['invoice_total_with_tax']);
				
					$sum_tax+= $total_tax_dtl[0]->totaltax;
					$sum_total+= $total_tax_dtl[0]->total;
					$sum_total_with_tax+= $total_tax_dtl[0]->invoice_total_with_tax;
								
					$dd = count($descr_of_goods_qty_rate_tax);

						
					

				foreach($descr_of_goods_qty_rate_tax as $get_qty_uom){
					
					 $qqty = $get_qty_uom->quantity;
					 $uuom = $get_qty_uom->UOM;
					 $uom_name = getNameById('uom',$uuom,'id');
					
				}
				
				if($dd > 1){ 
						$Details_view = '<a inv-id="'.$invoice['id'].'" href="javascript:void(0)" class="get_quantity_details"><span style="font-size:11px;"> View Detail </span></a>';
						}else{
							$Details_view = '';
						}
						//$resultss = substr_count( $material_names, ","); 
						
				echo "<tr>
					<td>".$invoice['id']."</td>
					
					<td>".@$material_names."</td>  
					<td><a href='javascript:void(0)' id='". $invoice['party_name'] . "' data-id='ledger_view' class='add_account_tabs'>".$party_name->name."</a></td>
					<td>".money_format('%!i',$total_tax_dtl[0]->total)."</td>
					
					<td class='txxx'>".money_format('%!i',$total_tax_dtl[0]->totaltax)."</td>
					<td>".money_format('%!i',$total_tax_dtl[0]->invoice_total_with_tax)."</td> 
					<td>".$qqty.' / '.$uom_name->uom_quantity."</td>
					<td>".$paid_or_not."</td>
					<td><a href='".base_url()."users/edit/".$invoice['created_by']."'>".getNameById('user_detail',$invoice['created_by'],'u_id')->name."</a></td>	
					<td>". date("j F , Y", strtotime($invoice['date_time_of_invoice_issue']))."</td>	
					<td class='hidde'>".$action."</td>
				</tr>";
				$output[] = array(
					   'Invoice No.' => $invoice['id'], 
					   'Material Name'  => $material_names1,
					   'Party Name' => $party_name->name,
					   'Sub Total' => money_format('%!i',$total_tax_dtl[0]->total),
					   'Tax' => money_format('%!i',$total_tax_dtl[0]->totaltax),
					   'Email' => money_format('%!i',$total_tax_dtl[0]->invoice_total_with_tax),
					   'Paid Or Not' => $paid_or_not,
					   'Registration Type' => getNameById('user_detail',$invoice['created_by'],'u_id')->name,
					   'Created Date' => date("d-m-Y", strtotime($invoice['date_time_of_invoice_issue'])),
					);	   
			 
			}  
		$data3  = $output;
		//pre($data3);
		export_csv_excel($data3); 
	   ?>
			 </tbody>
		
		   <tr><td colspan="11"></td></tr>
            <tr class="boot_strp_Data">
                <th colspan="3" style="text-align:center;">Total</th>
                <th  class="totlamt"></th>
                <th class="tx_cls"></th>
                <th class="totltxamt"></th>
                <th><a href="javascript:void(0)" class="get_quantity_details">Quantity Details</a></th>
				<th colspan="6"></th>
           </tr>
			<tr style="display:none;" class='php_ddta'>
               
                <th colspan="3" style="text-align:center;">Total</th>
                <th  class="totlamt_php"><?php echo money_format('%!i',$sum_total); ?></th>
                <th class="tx_cls_php"><?php echo money_format('%!i',$sum_tax); ?></th>
                <th class="totltxamt_php"><?php echo money_format('%!i',$sum_total_with_tax); ?></th>
				 <th><a href="javascript:void(0)" class="get_quantity_details">Quantity Details</a></th>
				<th colspan="6"></th>
            </tr>
			<?php
				$totalw = $totaltax_w = $total_with_tax = 0;
				foreach($saleReg_Data as $total_amt){ 
				$in_ttl = json_decode($total_amt['invoice_total_with_tax']);
				$totalw += $in_ttl[0]->total;
				$totaltax_w += $in_ttl[0]->totaltax;
				$total_with_tax += $in_ttl[0]->invoice_total_with_tax;
				}
			?>
			 <tr><td colspan="12"></td></tr>
			 <tr>
               
                <th colspan="3" style="text-align:center;">Grand Total</th>
                <th  class="totlamt_php"><?php echo money_format('%!i',$totalw); ?></th>
                <th class="tx_cls_php"><?php echo money_format('%!i',$totaltax_w); ?></th>
                <th class="totltxamt_php"><?php echo money_format('%!i',$total_with_tax); ?></th>
				<th colspan="6"></th>
                
            </tr>
		
			<?php } ?>
     
		
	</table>


	



 

	<!--table class="table table-dark table-striped table-bordered"  border="1" cellpadding="3" style="width: 50%;text-align: center;">
	  <thead>
			<tr>
				<th style="text-align: center;">Total</th>
				<th style="text-align: center;">Tax Total</th>
				<th style="text-align: center;">Grand Total</th>
			</tr>
		
		</thead>
	<tbody>
		  <?php
		  $totalw = $totaltax_w = $total_with_tax = 0;
			foreach($saleReg_Data as $total_amt){ 
			$in_ttl = json_decode($total_amt['invoice_total_with_tax']);
			$totalw += $in_ttl[0]->total;
			$totaltax_w += $in_ttl[0]->totaltax;
			$total_with_tax += $in_ttl[0]->invoice_total_with_tax;
			}
		  ?>
	  <tr class="chks" >
		<td><?php //echo money_format('%!i',$totalw); ?></td>
		<td><?php //echo money_format('%!i',$totaltax_w);?></td>
		<td><?php //echo money_format('%!i',$total_with_tax); ?></td>
	 </tr>
	  </tbody>
	</table--> 
</div>      
</div>		

<div id="add_invoice_detail_modal_sale" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Invoice Detail</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>

<div id="Quantity_details" class="modal fade in"  role="dialog">  
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Quantity Details</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
	</div>



<?php
 $this->load->view('common_modal'); 
?>











