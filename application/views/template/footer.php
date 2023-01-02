				</div>			</div>		</div>	</div></div>        <!-- footer content -->
        <footer>
			<div class="pull-right">Copyright: 2018-2019</div>
			<div class="clearfix"></div>
        </footer>
     <!-- /footer content -->
      </div>
    </div>
	<!-- quick add material -->

    <?= $this->load->view('template/quickMaterialAdd'); ?>
	
	<script>		var site_url = '<?php echo base_url(); ?>';	</script>		<?php
			$i = 0;
			foreach($js as $scripts){ 			if($i == 0){ 			}else{} 		?>
		<script src="<?php echo base_url() . $scripts; ?>"></script>
			<?php $i++;
		} ?>
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.js"></script>
		 <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
        </script>
        
        <?php
        	if($this->session->flashdata('success')){ ?>
        		<script type="text/javascript">
        			swal("Successfuly","<?= $this->session->flashdata('success') ?>", "success");
        		</script>
        <?php } 
        	if($this->session->flashdata('error')){ ?>
        		<script type="text/javascript">
        			swal("Opps","<?= $this->session->flashdata('error') ?>", "error");
        		</script>
        <?php }?>

  </body>
</html>