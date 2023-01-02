<div class="x_content">
<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
<p class="text-muted font-13 m-b-30"></p> 
	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab_content_ledgers" id="ledgeres_tab" role="tab" data-toggle="tab" aria-expanded="true">Ledgers</a>
			</li>
			<li role="presentation" class=""><a href="#invoice_tab" role="tab" id="invoice_tab_2" data-toggle="tab" aria-expanded="false">Sale</a>
			</li>
			<li role="presentation" class=""><a href="#sale_ledger_import" role="tab" id="sale_ledger_Tab" data-toggle="tab" aria-expanded="false">Sale Ledger</a>
			</li>
		</ul>
			<div id="myTabContent" class="tab-content">
			   <div role="tabpanel" class="tab-pane fade active in" id="tab_content_ledgers" aria-labelledby="ledgeres_tab">
					<table  class="table table-striped table-bordered" data-id="account">
						<thead><tr><th>Upload Ledger excel file</th></tr></thead>
						<tbody>
							<tr>
								<td>
									<form action="<?php echo base_url();?>account/import_view" method="post" enctype="multipart/form-data">
										<input type="file" name="uploadFile" value="" /><br><br>
										<input type="submit" name="upload_Data_ledgers" value="Upload Ledgers" class="btn btn-primary" />
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="invoice_tab" aria-labelledby="invoice_tab_2">
				<table  class="table table-striped table-bordered" data-id="account">
						<thead><tr><th>Upload Invoices excel file</th></tr></thead>
						<tbody>
							<tr>
								<td>
									<form action="<?php echo base_url();?>account/import_invoices" method="post" enctype="multipart/form-data">
										<input type="file" name="uploadFile" value="" /><br><br>
										<input type="submit" name="upload_invoices_data" value="Upload Invoices" class="btn btn-primary" />
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				
				</div>
				
				<div role="tabpanel" class="tab-pane fade" id="sale_ledger_import" aria-labelledby="sale_ledger_Tab">
				<table  class="table table-striped table-bordered" data-id="account">
						<thead><tr><th>Upload Sale Ledger excel file</th></tr></thead>
						<tbody>
							<tr>
								<td>
									<form action="<?php echo base_url();?>account/import_sale_ledgers" method="post" enctype="multipart/form-data">
										<input type="file" name="uploadFile" value="" /><br><br>
										<input type="submit" name="upload_invoices_data" value="Upload Sale Ledger" class="btn btn-primary" />
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				
				</div>
			</div>
	</div>
</div>



