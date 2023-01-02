<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>	

	
	<p class="text-muted font-13 m-b-30"></p> 
<?php if(!empty($contacts)){ ?>
	<div class="row hidde_cls export_div">
				<div class="col-md-12">
					 
					<div class="col-md-3 datePick-left">  
				<input type="hidden" value='contacts' id="table" data-msg="Contacts" data-path="crm/contacts"/>
				<input type="hidden" value='contacts' id="favr" data-msg="Contacts" data-path="crm/contacts" favour-sts="1"/>   


				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						  <?php /*input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/contacts"> */?>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/contacts">
						</div>
					  </div>
					</div>
				</fieldset>
			<form action="<?php echo base_url(); ?>crm/contacts" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>	
			</div>
					
						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="<?php echo base_url(); ?>crm/exportContacts" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="<?php echo base_url();?>assets/modules/crm/downloads/CONTACTS.xls" title="Please check your open office Setting">Export to Blank Excel</a></li>
									</ul>
									 
							</div>
			               <form action="<?php echo base_url(); ?>crm/contacts" method="post" >
								<input type="hidden" value='1' name='favourites'/>
								 <input type="hidden" value='' class='start_date' name='start'/>
								 <input type="hidden" value='' class='end_date' name='end'/>								  
												
							 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

							</form>
						</div>

			
			<div class="col-md-3 col-xs-12 datePick-right">
						
				<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Import<span class="caret"></span></button>
									<ul class="dropdown-menu import-bar" role="menu" id="export-menu">
										<li><form action="<?php echo base_url(); ?>crm/importContacts" method="post" enctype="multipart/form-data">	
					<input type="file" class="form-control col-md-2" name="uploadFile" id="file" style="width: 70%">
					<input type="submit" class="form-control col-md-2" name="importe" value="Import" style="width: 30%;"/></li>
			</form>
									</ul>
							</div>
			    
				<?php if($can_add) {
					echo '<button type="button" class="btn btn-primary add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="contact">Add</button>';

				} ?>
				
				<form action="<?php echo site_url(); ?>crm/contacts" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
				</form>
			</div>
				</div>
			</div>
	<?php } ?>	
		<div id="print_div_content">
		  <!-------------datatable-buttons--------->          
			<div class="col-md-6">
			<div class="input-group">
			<span class="input-group-addon">
						<i class="ace-icon fa fa-search"></i>
					</span>
			<input type="text" class="form-control search-query" placeholder="Type your search word" name="search" id="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];}//echo $search_string;?>">
			</div></div>
			<hr>
			<input type="hidden" id="visible_row" value=""/>
	<?php /* <table id="datatable-buttons" style="width:100%" class="table table-striped table-bordered account_index" data-id="account" border="1" cellpadding="3"> */ ?>
	<table id="mytable" style="width:100%" class="table tblData table-striped table-bordered account_index" data-id="account" border="1" cellpadding="3">
		<thead>
			<tr>
				<th>All<br><input id="selecctall" type="checkbox"></th>
				<th>ID</th>
				<th>Contact Name</th>
				<th>Company Name</th>
				<th>Phone</th>
				<th>Email</th> 
				
				<th>Created Date</th>
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
		   <?php if(!empty($contacts)){
			   foreach($contacts as $contact){ 
			   $action = '';
			  if($can_edit) { 
					//$action = $action.'<a href="'.base_url().'crm/editContact/'.$contact["id"].'" class="btn btn-info btn-xs add_crm_tabs"><i class="fa fa-pencil"></i> Edit </a>';
					$action =  '<a href="javascript:void(0)" id="'. $contact["id"] . '" data-id="contact" class="add_crm_tabs btn btn-edit btn-xs" data-tooltip="Edit" id="' . $contact["id"] . '"><i class="fa fa-pencil"></i> </a>';					 
					
					}
					$action .=  '<a href="javascript:void(0)" id="'. $contact["id"] . '" data-id="contact_view" class="add_crm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $contact["id"] . '"><i class="fa fa-eye"></i>  </a>';
					

					if($can_delete) { 
											$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deleteContact/'.$contact["id"].'"><i class="fa fa-trash"></i></a>';
										}
				$accountName = ($contact['account_id']!=0)?(getNameById('account',$contact['account_id'],'id')):'';
				if(!empty($accountName)){
					$name = $accountName->name;
				}else{
					$name = $contact['company'];
				}
				$draftImage = '';
				if($contact['save_status'] == 0)
				// $draftImage = '<img src="'.base_url(). 'assets/images/draft.png"  width="10%" class="hidde" >';
			
			
			
			$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
			<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
			
			//$txt = "<input name='checkbox' class='checkbox1' type='checkbox'>";
			  echo "<tr>											   
											   		<td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox' data-ai=".$contact['account_id']."  value=".$contact['id'].">";
											   		if($contact['favourite_sts'] == '1'){
											   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$contact['id']."  checked = 'checked'><br/>";
											   				echo"<input type='hidden' value='contacts' id='favr' data-msg='Contacts Unmarked' data-path='crm/contacts' favour-sts='0' id-recd=".$contact['id'].">";
											   		}else{
															echo "<input class='star' type='checkbox'  title='Mark Record' value=".$contact['id']."><br/>";
															echo"<input type='hidden' value='contacts' id='favr' data-msg='Contacts Marked' data-path='crm/contacts' favour-sts='1' id-recd =".$contact['id'].">";
											   		}
											   		
											   		echo "</td>		
			
					<td class='sale_order_id' >". $draftImage . $contact['id']."</td>
					<td>".$contact['first_name']. " ".$contact['last_name']."</td>
					<td>".$name."</td>
					<td>".$contact['phone']."</td>
					<td>".$contact['email']."</td>
					<td>".date("j F , Y", strtotime($contact['created_date']))."</td>	
					<td class='hidde'>".$action."</td>	
			   </tr>";


			    $output[] = array(
					   'Contact Name' => $contact['first_name']. " ".$contact['last_name'],
					   'Account Name' => $name,
					   //'Buyer Order No.' => $buyer_order_no,
					   'Email' => $contact['email'],
					   'Phone No' => $contact['phone'],
					   'Created Date' => date("d-m-Y", strtotime($contact['created_date'])),
					);	
				}
				$data3  = $output;
				
				export_csv_excel($data3);
		   } ?>
		</tbody>                   
	</table>
	<?php echo $this->pagination->create_links(); ?>	
</div>
</div>

<div id="crm_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Contact</h4>
			</div>
			<div class="modal-body-content"></div>
		</div>
	</div>
</div>
<?php	
/*
if(isset($_POST["ExportType"]))
{

 ob_end_clean();
    switch($_POST['ExportType'])
    {
		case "export-to-excel" :
            // Submission from
            $filename = $_POST["ExportType"] . ".xlsx";       
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
			//pre($data3);die();
		    ExportFile($data3);
            exit();
        case "export-to-csv" :
            // Submission from
            $filename = $_POST["ExportType"] . ".csv";            
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Expires: 0");
            ExportCSVFile($data3);
            //$_POST["ExportType"] = '';
            exit();
		default :         
            die("Unknown action : ".$_POST["action"]);
            break;
    }
}
 
function ExportCSVFile($records) {
    // create a file pointer connected to the output stream
    $fh = fopen( 'php://output', 'w' );
    $heading = false;
        if(!empty($records))
			ob_end_clean();
          foreach($records as $row) {
            if(!$heading) {
              // output the column headings
              fputcsv($fh, array_keys($row));
              $heading = true;
            }
            // loop over the rows, outputting them
             fputcsv($fh, array_values($row));
              
          }
          fclose($fh);
}
 
function ExportFile($records) {
    $heading = false;
    if(!empty($records))
		//ob_end_clean();
      foreach($records as $row) {
        if(!$heading) {
          // display field/column names as a first row
          echo implode("\t", array_keys($row)) . "\n";
          $heading = true;
        }
        echo implode("\t", array_values($row)) . "\n";
      }
    exit;
}
*/
?>