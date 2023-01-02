//datatble_pagination('user_index'); 
/*DataTable Pagination*/
/*function datatble_pagination(table_id = ''){
	$(document).ready(function(){
		var responsiveHelper = undefined;
		var breakpointDefinition = {
			tablet: 1024,
			phone : 480
		};
		 var type_check = $("."+table_id).attr("data-id");
		if(type_check == 'user') {
		 var columns = [
			  { "data": "id" },
			  { "data": "name" },
			  { "data": "user_profile" },
			  { "data": "email" },
			  { "data": "designation" },
			  { "data": "age" },
			  { "data": "contact_no" },
			  { "data": "experience" },
			  { "data": "date_joining" },
			  { "data": "action" },
			  ];
		}
		var id = $("#id").val();
		var id = '';
		var id = '';
		if($("#id").length > 0) {
			id = $("#id").val();  
		}		
		alert(table_id);
		$('.'+table_id).DataTable({
			"dom": "<'row'<'col-md-6'l <'toolbar'>><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
			"processing": true,
			"length": 10,
			"start": 0,
			"serverSide": true,
			"order":[[0,'desc']],
			"ajax":{
				"url": "http://localhost/erp/user/pagination_data",
				"dataType": "json",
				"type": "POST",
				"data":{type_check:type_check,id:id}
			},
			"columns": columns,
			autoWidth: false,
			preDrawCallback: function () {
				/* Initialize the responsive datatables helper once. */
			/*	if (!responsiveHelper) {
					//responsiveHelper = new ResponsiveDatatablesHelper($("#"+table_id), breakpointDefinition);
					//responsiveHelper = new ResponsiveDatatablesHelper($("#"+table_id), breakpointDefinition);
				}
			},			
			rowCallback  : function (row) {
				//responsiveHelper.createExpandIcon(row);
			},
			drawCallback : function (settings) {
				//responsiveHelper.respond();
			}
		});
		$("div.toolbar").html('<div class="table-tools-actions"><button class="btn btn-primary add_departments" style="margin-left:12px" id="test2">Add</button></div>');		
	});
}*/

