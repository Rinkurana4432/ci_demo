
<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	}?>
<form action="<?php echo base_url();?>inventory/import_view_mat" method="post" enctype="multipart/form-data">
    Upload excel file : 
    <input type="file" name="uploadFile" value="" /><br><br>
	<input type="submit" name="submit_material_data" value="Upload" class="btn btn-primary" />
</form>