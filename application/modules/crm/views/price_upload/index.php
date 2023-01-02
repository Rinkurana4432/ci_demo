<?php ini_set('display_errors', '0'); ?>
<html><head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

</head><body>
<div class="x_content">
<form action="<?php echo base_url(); ?>crm/importprice" method="post" enctype="multipart/form-data" style="margin-top: 30px;">
<div class="col-md-12">
		
	<div class="col-md-8">
      	<div class="col-md-3">
		<input type="file" id="fileUpload"  class="form-control col-md-2" name="uploadFile" />
		</div>
		<div class="col-md-3">
		<label class="col-md-3" style="padding:8px;">From</label>
		<div class="col-md-9">
		<input type="date" id="website" name="from_date" class="optional form-control col-md-7 col-xs-12" data-validate-length-range="0" > 
		</div>
         </div>
		 <div class="col-md-3">
		<label class="col-md-3" style="padding:8px;">To</label>
		<div class="col-md-9">
		<input type="date" id="website" name="to_date" class="optional form-control col-md-12 col-xs-12" data-validate-length-range="0" > 
		</div>
        </div>
		<div class="col-md-3">
		<input type="submit" class="form-control col-md-12" name="importe" value="Import" />
		</div>
	</div>

	<div clas="col-md-4">
		<div class="col-md-12">
		<!-- <label class="col-md-2" style="padding:8px;">Donwload Blank Excel</label> -->
		<a class="col-md-2" style="padding:8px;" href="<?php echo base_url(); ?>assets/modules/crm/blnkexcel.xls" download>Donwload Template</a>
		</div>
	</div>
</div>
</form>

<hr />
<div id="dvExcel">
	
</div>
</div>
		