<div class="x_content">
<?php
if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}

	$this->companyGroupId = (isset($_SESSION['companyGroupSessionId']) && $_SESSION['companyGroupSessionId']!='' && $_SESSION['companyGroupSessionId'] != 0)?$_SESSION['companyGroupSessionId']:$_SESSION['loggedInUser']->c_id ;

 ?>
<div class="stik">	
<form action="<?php echo site_url(); ?>crm/crmterms_condtn" method="post" id="export-form">
					<input type="hidden" value='' id='hidden-type' name='ExportType'/>
					<input type="hidden" value='' class='start_date' name='start'/>
					<input type="hidden" value='' class='end_date' name='end'/>
					<input type="hidden" value='<?php if(!empty($_POST['account_name'])){echo $_POST['account_name'] ;} ?>' class='account_name' name='account_name'/>
				</form>
		
</div>

	<div class="row hidde_cls export_div">

		 

				<div class="col-md-12">
					<div class="col-md-3 datePick-left">  
					<input type="hidden" value='termscond' id="table" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn"/>


					<input type="hidden" value='termscond' id="favr" data-msg="Terms & Conditions" data-path="crm/crmterms_condtn" favour-sts="1"/>              
				<fieldset>
					<div class="control-group">
					  <div class="controls">
						<div class="input-prepend input-group">
						  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
						<?php /*  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" data-table="crm/termscond"> */?>
						  <input type="text" style="width: 200px" name="tabbingFilters" id="tabbingFilters" class="form-control" value="" data-table="crm/crmterms_condtn">
						</div>
					  </div>
					</div>
				</fieldset>
			<form action="<?php echo base_url(); ?>crm/crmterms_condtn" method="post" id="date_range">	
				 <input type="hidden" value='' class='start_date' name='start'/>
				 <input type="hidden" value='' class='end_date' name='end'/>
			</form>	
			</div>

						<div class="btn-group"  role="group" aria-label="Basic example">
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm">Copy</button>
							<button type="button" class="btn btn-default buttons-copy buttons-html5 btn-sm" id="bbtn">Print</button>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown">Export<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
										<li id="export-to-excel"><a href="javascript:void(0);" title="Please check your open office Setting">Export to excel</a></li>
										<li id="export-to-csv"><a href="javascript:void(0);" title="Please check your open office Setting">Export to csv</a></li>
									</ul>
							</div>
							<div class="dropdown btn btn-default buttons-copy buttons-html5 btn-sm export ">
								<button class="btn btn-secondary dropdown-toggle btn-default" type="button" data-toggle="dropdown"><i class="fa fa-filter" aria-hidden="true"></i>Filter<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" id="export-menu">
									<div id="demo">
										<?php if(!empty($termsconds) && $can_view){ ?>
										<form action="<?php echo base_url(); ?>crm/crmterms_condtn" method="post">
											<div class="row hidde_cls filter1">
												<div class="col-md-12">
													<div class="btn-group col-md-12"  role="group" aria-label="Basic example">
														<select class="form-control selectAjaxOption select2 select2-hidden-accessible" name="termscond_name" data-id="user_detail" data-key="id" data-fieldname="name" width="100%" tabindex="-1" aria-hidden="true" required="required" data-where="c_id=<?php echo $this->companyGroupId; ?>">
															<option value="">Select Option</option>
														</select>
													</div>
													<input type="submit" value="Filter" class="btn filterBtn filt1"  data-table="crm/crmterms_condtn">
												</div>
											</div>
										</form>	<?php } ?>
									</div>
									</ul>
							</div>
							<form action="<?php echo base_url(); ?>crm/crmterms_condtn" method="post" >
								<input type="hidden" value='1' name='favourites'/>
								 <input type="hidden" value='' class='start_date' name='start'/>
								 <input type="hidden" value='' class='end_date' name='end'/>								  
												
							 <button class="btn btn-default btn-sm pull-left" name="favourites"><i class="fa fa-star" aria-hidden="true"></i>Favorites</button>

							</form>
			                <button class="btn btn-default btn-sm pull-left" id="del_all"><i class="fa fa-trash"></i>Delete</button>
						</div>

				<div class="col-md-3 datePick-right">
					
					<button type="button" class="btn btn-primary add_crm_tabs addBtn" data-toggle="modal" id="add" data-id="editterms_condtn">Add</button>
              </div>	
					
				</div>
			</div>
	<p class="text-muted font-13 m-b-30"></p> 
<div id="print_div_content">	
	<table id="datatable-buttons" class="table table-striped table-bordered termscond_index" data-id="crmterms_condtn" style="width:100%" border="1" cellpadding="3">
		<thead>
			<tr>
				<th>All<br><input id="selecctall" type="checkbox"></th>
				<th class="col-sm-1">Id</th>
				<th>Tittle</th>
				<th>Content</th>
				<th>Created Date</th>
				<th class='hidde'>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($termsconds)){
					foreach($termsconds as $termscond){ 
					    $action = '';
					    if($can_edit) { 
							//$action = $action.'<a href="'.base_url().'crm/edittermscond/'.$termscond["id"].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>'; 
							$action =  '<a href="javascript:void(0)" id="'. $termscond["id"] . '" data-id="editterms_condtn" class="add_crm_tabs btn btn-edit  btn-xs" data-tooltip="Edit" id="' . $termscond["id"] . '"><i class="fa fa-pencil"></i> </a>';
						}	
						#if($can_view) { 				
							$action .=  '<a href="javascript:void(0)" id="'. $termscond["id"] . '" data-id="termscond_view" class="add_crm_tabs btn btn-view   btn-xs" data-tooltip="View" id="' . $termscond["id"] . '"><i class="fa fa-eye"></i>  </a>';			
						#}

							if($can_delete) { 
											$action = $action.'<a href="javascript:void(0)" data-tooltip="Delete" class="delete_listing btn btn-xs btn-delete" data-href="'.base_url().'crm/deletetermscond/'.$termscond["id"].'"><i class="fa fa-trash"></i></a>';
										}
						

                            


						$draftImage = '';
						if($termscond['save_status'] == 0)
						$draftImage = '<a href="javascript:void(0)" class="draft-icon" data-tooltip="Draft">
			<img class="img-responsive hidde" src="'.base_url(). 'assets/images/draft.png" > </a>';
					   echo "<tr>											   
											   		<td><input termscond='checkbox[]' class='checkbox1 checkbox[]' type='checkbox'  value=".$termscond['id'].">";
											   		if($termscond['favourite_sts'] == '1'){
											   				echo "<input class='star' type='checkbox'  title='Mark Record' value=".$termscond['id']."  checked = 'checked'><br/>";
											   				echo"<input type='hidden' value='termscond' id='favr' data-msg='Terms & Conditions Unmarked' data-path='crm/crmterms_condtn' favour-sts='0' id-recd=".$termscond['id'].">";
											   		}else{
															echo "<input class='star' type='checkbox'  title='Mark Record' value=".$termscond['id']."><br/>";
															echo"<input type='hidden' value='termscond' id='favr' data-msg='Terms & Conditions Marked' data-path='crm/crmterms_condtn' favour-sts='1' id-recd =".$termscond['id'].">";
											   		}
											   		
											   		echo "</td>
							<td>".$draftImage . $termscond['id']."</td>
							<td>".$termscond['terms_tittle']."</td>
							<td>".$termscond['content']."</td>
							<td>".date("j F , Y", strtotime($termscond['created_date']))."</td>	
							<td class='hidde'>".$action."</td>	
					   </tr>";
					 $output[] = array(
						   'Tittle' => $termscond['terms_tittle'],
						   'Content' => $termscond['content'],
						   'Created Date' => date("d-m-Y", strtotime($termscond['created_date'])),
						);	
				}
				$data3  = $output;
				export_csv_excel($data3);
			} ?>
		</tbody>                   
	</table>
	</div>
</div>
<div id="crm_add_modal" class="modal fade in"  role="dialog">
	<div class="modal-dialog modal-lg modal-large">
		<div class="modal-content" style="display:table;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
			</div>
			<div class="modal-body-content" ></div>
		</div>
	</div>
</div>
<script>
var measurementUnits = '';

</script>
