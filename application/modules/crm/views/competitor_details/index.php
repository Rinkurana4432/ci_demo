
			<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;



 ?>
<div class="stik">	
<form action="<?php echo site_url(); ?>crm/competitor_details" method="get" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
					<input type="hidden" value='<?php if(isset($_GET['end']))echo $_GET['end'];?>' class='end_date' name='end'/>
                    <input type="hidden" value='<?php if(isset($_GET['favourites']))echo $_GET['favourites'];?>'  name='favourites'/>
                    <input type="hidden" value='<?php if(isset($_GET['search']))echo $_GET['search'];?>' name='search'/>
					<input type="hidden" value='<?php if(!empty($_GET['account_name'])){echo $_GET['account_name'] ;} ?>' class='account_name' name='account_name'/>
				</form>


		
</div>
<div class="col-md-12 col-xs-12 for-mobile">
      <div class="Filter Filter-btn2">
	        	<form class="form-search" method="post" action="<?= base_url() ?>crm/competitor_details">
	<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-check"></i>
					</span>
					<input type="text" class="form-control search-query" placeholder="Enter id,Name" name="search" id="search" value="<?php if(!empty($_GET['search']))echo $_GET['search'];?>" data-ctrl="crm/competitor_details">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-purple btn-sm">
							<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
							Search
						</button>
						 <a href="<?php echo base_url(); ?>crm/competitor_details">
				<input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
					</span>
				</div>
</div>
			</form>	
			<button style="margin-right: 0px !important;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo" aria-expanded="true"><i class="fa fa-filter" aria-hidden="true"></i>Filter By<span class="caret"></span></button>
	  <div id="demo" class="collapse" aria-expanded="true" style="">
	         <div class="col-md-3 datePick-left">                
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/accounts"> */?>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/competitor_details">
						</div>
					  </div>
					</div>
				</fieldset>
			<form action="<?php echo base_url(); ?>crm/competitor_details" method="get" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>	
			</div>
	  </div>
	  </div>
</div>
		
		<?php #if(!empty($competitor_details)){ ?>
	<div class="row hidde_cls export_div">

			
				<div class="col-md-12">
						<input type="hidden" value='competitor_details' id="table" data-msg="Competitor" data-path="crm/competitor_details"/>

					

						<div class="btn-group"  role="group" aria-label="Basic example">
						   	<?php 
				if($can_add) {
					//echo '<a href="'.base_url().'crm/editAccount/"><button type="buttton" class="btn btn-info">Add</button></a>'; 
					echo '<button type="button" class="btn btn-success add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="competitor_details"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add</button>';
				} ?>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
							<form action="<?php echo base_url(); ?>crm/competitor_details" method="get" style="display:inline-block;">
								<input type="hidden" value='1' name='favourites'/>
								 <input type="hidden" value='<?php if(isset($_GET['start']))echo $_GET['start'];?>' class='start_date' name='start'/>
								 <input type="hidden" value='<?php if(isset($_GET['end'])) echo $_GET['end'];?>' class='end_date' name='end'/>								  
												
							 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

							</form>
						
							


							<!-- <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>-->
						</div>

					
					
				</div>
			</div>
	<?php # } ?>	
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">
	<!-------------datatable-buttons--------->          
			
				<form class="form-search" id="orderby" method="post" action="<?= base_url() ?>crm/competitor_details">
			<input type="hidden" name="order" id="order" value="<?php if(isset($_POST['order'])==''||$_POST['order']=='desc'){echo 'asc';}else{echo 'desc';}?>">
			</form>
			
	<table id="mytable" class="table tblData table-striped table-bordered" data-id="competitor_details" style="width:100% ; margin-top:40px;" border="1" cellpadding="3">
		<thead>
			<tr>
				<th>All<br><input id="selecctall" type="checkbox"></th>
				<th scope="col" class="col-sm-1">Id
			<span><a href="<?php echo base_url(); ?>crm/competitor_details?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>crm/competitor_details?sort=desc" class="down"></a></span></th>
				<th scope="col">Company Name
	<span><a href="<?php echo base_url(); ?>crm/competitor_details?sort=asc" class="up"></a>
      <a href="<?php echo base_url(); ?>crm/competitor_details?sort=desc" class="down"></a></span></th>
				<th scope="col">Phone</th>
				<th scope="col">Created By</th>
				<th scope="col">Created Date</th>
				<th scope="col" class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($competitor_details)){
					foreach($competitor_details as $competitordetails){ 
					    $action = '';
					    if($can_edit) { 
							//$action = $action.'<a href="'.base_url().'crm/editAccount/'.$account["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
							$action =  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="competitor_details" class="add_crm_tabs btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $competitordetails["id"] . '"><i class="fa fa-pencil"></i> </a>';
						}	
						/*#if($can_view) { 				
							$action .=  '<a href="javascript:void(0)" id="'. $competitordetails["id"] . '" data-id="account_view" class="add_crm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $competitordetails["id"] . '"><i class="fa fa-eye"></i>  </a>';			
						#}*/
						

						if($can_delete) { 
							$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete"  class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/delete_competitor_details/'.$competitordetails["id"].'"><i class="fa fa-trash"></i></a>';
						}

						
						$createdBy = getNameById('user_detail',$competitordetails['created_by'],'u_id');
						if(!empty($createdBy)){
							$createdByName = $createdBy->name;
						}else{
							$createdByName = '';
						}
						$draftImage = '';
						if($competitordetails['save_status'] == 0)
						$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
			<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
					   echo "<td><input name='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  data-ai=".$competitordetails['id']." value=".$competitordetails['id'].">";
											   		if($competitordetails['favourite_sts'] == '1'){
											   				echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."  checked = 'checked'><br/>";
											   				echo"<input type='hidden' value='competitor_details' id='favr' data-msg='Competitor Details' data-path='crm/competitor_details'  id-recd=".$competitordetails['id'].">";
											   		}else{
															echo "<input class='star' type='checkbox' onclick='favour()' title='Mark Record' value=".$competitordetails['id']."><br/>";
															echo"<input type='hidden' value='competitor_details' id='favr' data-msg='Competitor Details' data-path='crm/competitor_details'  id-recd =".$competitordetails['id'].">";
													
											   		}
											   		
											   		echo "</td>
							<td data-label='Id:'>".$draftImage . $competitordetails['id']."</td>
							<td data-label='Company Name:'>".$competitordetails['name']."</td>
							<td data-label='phone:'>".$competitordetails['phone']."</td>
							<td data-label='created By:'>".$createdByName."</td>
							<td data-label='created date:'>".date("j F , Y", strtotime($competitordetails['created_date']))."</td>	
							<td data-label='action:' class='hidde'>".$action."</td>	
					   </tr>";
					 $output[] = array(
						   'Account ID' => $competitordetails['id'],
						   'Account Name' => $competitordetails['name'],
						   'Phone No' => $competitordetails['phone'],
						   'Created By' => $createdByName,
						   'Created Date' => date("d-m-Y", strtotime($competitordetails['created_date'])),
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
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Competitor Details</h4>
			</div>
		<div class="modal-body-content"></div>
		</div>
	</div>
</div>



<script>
var measurementUnits = '';

</script>
