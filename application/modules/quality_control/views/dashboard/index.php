 
<div class="row dashboard-main">
	<div class="row top_tiles col-md-12 col-sm-12 col-xs-12">
	    <div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
	        <div class="tile-stats" >
	            <div class="icon">
	                <i class="fa fa-archive" aria-hidden="true"></i></div>
	            <div class="count"><?php echo $this->Quality_control_model->get_count('quality_control'); ?></div>
	            <p>No. of Formats</p>
	            </div>
	            </div>
	              <div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
	        <div class="tile-stats" >
	            <div class="icon">
	                <i class="fa fa-eye" aria-hidden="true"></i></div>
	            <div class="count"><?php echo $this->Quality_control_model->get_count('inspection_report_master'); ?></div>
	            <p>No. of Inspection Report</p>
	            </div>
	            </div>
	            <div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12">
	        <div class="tile-stats" >
	            <div class="icon">
	                <i class="fa fa-file" aria-hidden="true"></i></div>
	            <div class="count"><?php echo $this->Quality_control_model->get_count('controlled_report_master'); ?></div>
	            <p>No. of Controlled Report</p>
	            </div>
	            </div>
	</div>
</div>
