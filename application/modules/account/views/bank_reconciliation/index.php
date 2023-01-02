<div class="x_content">
	<?php if($this->session->flashdata('message') != ''){
		echo '<div class="alert alert-info">'.$this->session->flashdata('message').'</div>';
	} 
	
	$Login_user_id = $_SESSION['loggedInUser']->u_id;
	

	
	?>
</div>
	<div class="col-md-12 item form-group">
		<div class="col-md-12 item form-group">
		<table id="datatable-buttons"  class="table table-striped table-bordered">
			
			<thead>
				<tr>
					<th>Comming</th>
					<th>Soon</th>
				</tr>
			</thead>
			<tbody>				      
					 <?php
					$libTr = '';
					$assTr = '';
					$libTr .= '<td><table  id="datatable-buttons"  class="table table-striped table-bordered">';
					$assTr .= '<td><table  id="datatable-buttons"  class="table table-striped table-bordered">';
					
					
						
				
					$libTr .= '</td></table>';
					echo $libTr;
					$assTr .= '</td></table>';
					echo $assTr;
					
					
					 ?>
		</tbody>
		
	</table>
			
		
	</div>
</div>

