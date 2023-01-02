<div class="x_content">
		<?php if($this->session->flashdata('message') != ''){
			echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
		}?>
		<p class="text-muted font-13 m-b-30"></p>                   
		<div class="col-md-12 connectSearchBtn">
	<?php /*<form class="form-horizontal" method="POST" action="<?php echo base_url().'company/searchCompanyList' ;?>" >*/?>
		<input type="text" class="form-control searchCompanyList" name="company_name" placeholder="SEARCH COMPANY TO CONNECT...">
		<?php /*<span class="input-group-btn">								
			<button type="submit" class="btn btn-primary btn btn-primary btnerp-stylefull searchCompanyList"><i class="fa fa-search"></i></button>
		</span>
	</form>*/?>
	<div class="companyList"></div>
	<div class="companyProfile"></div>
	
</div>
</div>

		