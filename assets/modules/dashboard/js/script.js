/*******************    Purchase Dashboard scripts    **************************/
/*******************************************************************************curreent date in purchase order******************************************************************/
var date = new Date();
 /*********************************************************DASHBOARD graphs**************************************************************************/
	
$(document).ready(function(e) {		
var startDate = new Date(date.getFullYear(), date.getMonth(), 1);
var endDate = new Date(date.getFullYear(), date.getMonth()+1, 0);
startDate = startDate.format('Y-m-d 00:00:00');
endDate = endDate.format('Y-m-d 23:59:59');	
getDashboardCount(startDate , endDate );
getIndentStatusGraph(startDate, endDate );
getMonthApprovetatusGraph(startDate, endDate );
getMrnStarRating(startDate, endDate );	
getPItoPoConversion(startDate, endDate );
getPOtoMRNConversion(startDate, endDate );
PoAmountTotalWithMaterial(startDate, endDate );
MRNAmountTotalWithMaterial(startDate, endDate );
piCompleteStatusAmountTotalWithMaterial(startDate, endDate );
getComparison(startDate ,endDate);
getProductionPlanning(startDate ,endDate);
getPoductionDataListingGraph(startDate ,endDate);
/*Accounts*/
dashboardPurchaseExpense();
dashboardMaterialSale();
dashboardPaymentReceivedDone();
/*Inventory*/
getMonthInventoryListingGraph();
getScrappedDetail();
getStockSummary();

/* crm */
getMonthLeadStatusGraph();		
$("#lineChart1").empty();
dashboardLeadAcheivedVsTarget();		
$("#graph_sale_order").empty();
dashboardSaleOrder();
$("#graph_donut_lead").empty();
getLeadStatusGraph();			
getWinLeadVsTotalGraph();
getDashboardCount();
getRecentActivities();
getCrmTableData();

});		

/******************************Show Upper counts from each module of CRM  ***********************************************/
	function getDashboardCount(startDate = '' , endDate = ''){	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getDashboardCount/',
				url: site_url +'purchase/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					//console.log('response===>>',response);	
					var dashboardCountHtml = '';	
					$.each( response.getDashboardCount, function( key, value ) {
						dashboardCountHtml += '<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="tile-stats"><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalCount+'</div><h3>'+value.name+'</h3><p>'+value.description+'</p></div></div>';
					});
					$('.top_tiles').html(dashboardCountHtml);
					
				}			
			});
	}
/*************************************Dashboard filteration data *************************************************************/
$('.dashboardFilter').daterangepicker({
    opens: 'left',
	useCurrent: true,
	//startDate: moment().startOf('hour'),
	startDate: new Date(date.getFullYear(), date.getMonth(), 1),
   // endDate: moment().startOf('hour').add(24, 'hour'),
    endDate: new Date(date.getFullYear(), date.getMonth()+1, 0),
	locale: {
	    //format: 'YYYY-MM',
	    format: 'DD-MM-YYYY',
	},	
  }, function(start, end, label) { 	
		var startDate = start.format('YYYY-MM-DD 00:00:00');
		var endDate = end.format('YYYY-MM-DD 23:59:59');	
			console.log('startDate===>>>',startDate);
		var dateRangeHtml = $(this)[0].element.context;			
		//$("#area-chart2").empty();
		$('.canvasDoughnut_Amount').replaceWith($('<canvas class="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>'));
		$('.pi_material_type_Amount').replaceWith($('<canvas class="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>'));
		$('#pieChart_Indent').replaceWith($('<canvas id="pieChart_Indent"></canvas>'));
		$('#pieChart_order').replaceWith($('<canvas id="pieChart_order"></canvas>'));
		
		
		
		
		
		$("#pieChart_Indent").empty();
		getPItoPoConversion(startDate ,endDate);
		$("#pieChart_order").empty();
		getPOtoMRNConversion(startDate ,endDate);	
		$(".progress").empty();
		getMrnStarRating(startDate ,endDate);	
		$("#graph_donut_PI").empty();
		getIndentStatusGraph(startDate ,endDate);
		$("#graph_Indent").empty();
		getMonthApprovetatusGraph(startDate ,endDate);			
		getMrnStarRating(startDate ,endDate);
		getDashboardCount(startDate ,endDate);
		$(".canvasDoughnut_Amount").empty();
		$("#MaterialAmount").empty();
		PoAmountTotalWithMaterial(startDate ,endDate);
		$("#completeMRNMaterialAmount").empty();
		MRNAmountTotalWithMaterial(startDate ,endDate);
		piCompleteStatusAmountTotalWithMaterial(startDate ,endDate);
		
		$("#graph_month_wise_production_data").empty();
		$("#graph_Indent1").empty();
		$("#graph_area1").empty();
		getComparison(startDate ,endDate);
		getProductionPlanning(startDate ,endDate);
		getPoductionDataListingGraph(startDate ,endDate);
		
		/* account */
		$("#graph_income_expanse").empty();
		dashboardPurchaseExpense(startDate ,endDate);		
		$("#graph_material_sale").empty();
		dashboardMaterialSale(startDate ,endDate);		
		$("#graph_payment_received_done").empty();
		dashboardPaymentReceivedDone(startDate ,endDate);
		
		/* inventory */
		$(".progress").empty();
		getScrappedDetail(startDate ,endDate);	
		$("#month_Wise_graph").empty();
		getMonthInventoryListingGraph(startDate ,endDate);	
		getDashboardCount(startDate ,endDate);
		$("#material_type_graph_donut").empty();
		getStockSummary(startDate ,endDate);	
		
		/* CRM */		
		$("#area-chart2").empty();
		getMonthLeadStatusGraph(startDate ,endDate);		
		$("#lineChart1").empty();
		dashboardLeadAcheivedVsTarget(startDate ,endDate);		
		$("#graph_sale_order").empty();
		dashboardSaleOrder(startDate ,endDate);
		$("#graph_donut_lead").empty();
		getLeadStatusGraph(startDate ,endDate);			
		getWinLeadVsTotalGraph(startDate ,endDate);
		getRecentActivities(startDate ,endDate);
		getCrmTableData(startDate ,endDate);
		
		
		
		
		
		
  });  
 
 $('.dashbrd_filter').on('click',function(){	
		$('.pi_material_type_Amount').replaceWith($('<canvas class="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>'));
		var status_value2 = $('.select_value2').val();
		var startDate = '';
		var endDate = '';
		
		piCompleteStatusAmountTotalWithMaterial(startDate,endDate,status_value2);
 
 });
 $('.dashbrd_filter_PO').on('click',function(){
 	$('.canvasDoughnut_Amount').replaceWith($('<canvas class="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>'));
		var status_value2 = $('.select_value21').val();
		
		var startDate = '';
		var endDate = '';
		PoAmountTotalWithMaterial(startDate,endDate,status_value2);
 
 });

/********************************************progrss bar star ratings********************************************************/ 
  function getMrnStarRating(startDate = '' , endDate = ''){
		if($(".mrnStarRatingDiv").length) {	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getWinLeadVsTotalGraph/',
				url: site_url +'purchase/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					
					var result = response.getMrnStarRating[0];
					//alert(JSON.stringify(result));
					console.log("ratingResult",result);
					console.log("ratingResulttype",typeof(result));
					var totalMrnRating = result.Total;
					var mrnStaRatingHtml ='<h1 style="text-align: center;">MRN Rating: '+totalMrnRating+'</h1>';
					var i=1;
					jQuery.each(result, function(name, value) {	
					var bg_color_class = '';
						if(name != 'Total'){						
							switch (i) {
								case 1:
									bg_color_class = 'bg-purple';
									break;	
								case 2:
									bg_color_class = 'bg-orange';
									break;
								case 3:
									bg_color_class = 'bg-blue';
									break;	
								case 4:
									bg_color_class = 'bg-green';
									break;
								case 5:
									bg_color_class = 'bg-red';
									break;
							}
							var starWidth =  (value == 0)?0:(value * 100 / totalMrnRating);
							mrnStaRatingHtml +='<div class="x_content"><div class="widget_summary"><div class="w_left w_25"><span class="'+name+'">'+i+' Star : '+value+'</span></div><div class="w_center w_55"><div class="progress"><div class="progress-bar '+bg_color_class+' pg'+i+'" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:'+starWidth+'%"><span class="sr-only">20% Complete</span></div></div></div><div class="w_right w_20"><span class="total"></span></div><div class="clearfix"></div></div></div>';
							i++;
						}
					});
					$('.mrnStarRatingDiv').html(mrnStaRatingHtml);
				}			
			});
	}
	
	}

	
	
/******************donut chart for approve dissaporve**************************/
function getIndentStatusGraph(startDate = '' , endDate = ''){		
	if($("#graph_donut_PI").length) {
		if(startDate!='' && endDate!=''){
			ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			ajaxData = {};
		}
		$.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			data: ajaxData,
			success: function(response){		
				var result = response.getIndentStatusGraph[0];
				
				var ptotal = parseInt(result.Approved) + parseInt(result.Dissaproved) + parseInt(result.Pending) ;				
				if(ptotal == 0){
					$("#graph_donut_PI").css("display","none");
					$(".emptyIndentStatusDiv").css("display","block");
				}else{	
					$("#graph_donut_PI").css("display","block");
					$(".emptyIndentStatusDiv").css("display","none");				
				Morris.Donut({
					element: 'graph_donut_PI',
					data: [
							{label: 'Approved', value: ((parseInt(result.Approved)/ ptotal) * 100).toFixed(2), count: result.Approved},
							{label: 'Disapproved', value: ((parseInt(result.Dissaproved)/ ptotal) * 100).toFixed(2), count: result.Dissaproved},
							{label: 'Pending', value: ((parseInt(result.Pending)/ ptotal) * 100).toFixed(2), count: result.Pending}
							
							],
					colors: ["#1ABB9C" , "#E74C3C","#F39C12" ],
					formatter: function (y,data) {	
					return data.count + "  (" + y + "%" +")";					 
					},
					resize: true
					});
				}
				
			}			
		});	
		
	}
}


/******************bar graph ststaus and amount for approve dissaprove******************/
function getMonthApprovetatusGraph(startDate = '' , endDate = ''){	
		if ($('#graph_Indent').length){
				if(startDate!='' && endDate!=''){
					var ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					var ajaxData = {};
				}
			
				$.ajax({        
					url: site_url +'purchase/graphDashboardData/',
					dataType: 'json',
					type: 'POST',				
					data: ajaxData,
					success: function(result){	
					
						var monthApprovetatusGraphData = JSON.stringify(result.getMonthApprovetatusGraph);
						
						var nullAmountCount = count( monthApprovetatusGraphData,'"Amount":"0"' );
						var nullApprovedCount = count(monthApprovetatusGraphData,'"Approve":"0"');
						var nullDisapprovedCount = count(monthApprovetatusGraphData,'"disapprove":"0"');
						console.log('nullAmountCount===>>>',nullAmountCount);
						console.log('nullApprovedCount===>>>',nullApprovedCount);
						console.log('nullDisapprovedCount===>>>',nullDisapprovedCount);
						if((nullAmountCount == 12) && (nullApprovedCount == 12) && (nullDisapprovedCount == 12)){
							$("#graph_Indent").css("display","none");
							$(".emptyPurchaseIndentDiv").css("display","block");
						}else{
							$("#graph_Indent").css("display","block");
							$(".emptyPurchaseIndentDiv").css("display","none");
							result = result.getMonthApprovetatusGraph;
							console.log('ggggRedsult===>>>',result);
							Morris.Bar({
							  element: 'graph_Indent',
							data: result,
							  xkey: 'period',
							  barColors: ['#34495E','#CE5454'],
							  ykeys: ['Approve', 'disapprove' , 'Amount'],
							  labels: ['Approve', 'disapprove', 'Amount'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true							  	 
							});	
						}
					}			
				});		
	}
}
	

/************ Pie chart pi to po conversion ************/
function getPItoPoConversion(startDate = '' , endDate = ''){
  if ($('#pieChart_Indent').length ){
	  var ctx = document.getElementById("pieChart_Indent");
	  if(startDate!='' && endDate!=''){
		var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
		}
		$.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){
				result = result.getPItoPoConversion;			
				if(result[0].pi_not_converted == 0 && result[0].poCreate ==0){ // if both converted and non converted pi are zero than show empty message
						$("#pieChart_Indent").css("display","none");
						$(".emptyPiToPoDiv").css("display","block");
			}else{// if both converted and non converted pi are not zero
					$("#pieChart_Indent").css("display","block");
					$(".emptyPiToPoDiv").css("display","none");				
				    var data = {
					datasets: [{
					 data: [result[0].pi_not_converted , result[0].poCreate ] ,
					  backgroundColor: [						
						"#CE5454",
						"#455C73",
					  ],
					  label: 'My dataset' // for legend
					}],
					labels: [
					  "Purchase Indent not converted",
					  "PoCreated",
					]
				  };
				  var pieChart = new Chart(ctx, {
					data: data,
					type: 'pie',
					otpions: {
					  legend: false
					}	
				  });
			}			
			}		
		});	
  }
}

/************ Pie chart PO to MRN conversion on dashboard ************/
function getPOtoMRNConversion(startDate = '' , endDate = ''){
  if ($('#pieChart_order').length ){
		var ctx1 = document.getElementById("pieChart_order");
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				var ajaxData = {};
			}
		$.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){
				result = result.getPOtoMRNConversion; 
				console.log("pie order",result);
				if(result[0].po_not_converted_to_mrn == 0 && result[0].po_converted_to_mrn ==0){// if both converted and non converted PO are not zero
					$("#pieChart_order").css("display","none");
					$(".emptyPoToMrnDiv").css("display","block");
				}else{
					$("#pieChart_order").css("display","block");
					$(".emptyPoToMRNDiv").css("display","none");				
					var data1 = {
						datasets: [{
							data: [ result[0].po_not_converted_to_mrn , result[0].po_converted_to_mrn ],
							backgroundColor: [
							   "#3498DB",
							   "#CE5454",
							],
							label: 'My dataset' // for legend
						}],
					   labels: [
							"PO Pending For MRN",
							"PO Converted To MRN", 
					   ]
					};
					var pieChart1 = new Chart(ctx1, {
										data: data1,
										type: 'pie',
										otpions: {legend: false }	
								});
				}
			}			
		});		
	 
  }
}


/********* Doughnut chart for material disaplya from PO and amouunt total ************/
function PoAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
	
	if ($('.canvasDoughnut_Amount').length){
		 if(startDate!='' || endDate!='' || status_value2!=''){
		var ajaxData = {'startDate':startDate , 'endDate':endDate , 'status_value2':status_value2 };
		}else{
			var ajaxData = {};
		}
		 $.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){
				result = result.PoAmountTotalWithMaterial;
				console.log("esultpiechar t",result);
				var table = '';
				var amount = 0;
				var poTotalAmount = 0;
					table += '<h2>Material Name</h2><h2>Amount</h2><br>';
				$.each(result.poAmountData, function(name, value) {	
					amount = value.totalAmount == null?0:value.totalAmount;
					poTotalAmount += parseInt(amount);
					table += '<div><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount+'</div><br>';
                   })	
				    table += '<div><b>Total</b></div><div><b>'+poTotalAmount+'</b></div><br>';
				$("#MaterialAmount").html(table);				
				var labelObject = new Array();
				var dataObject = new Array();
				var poDataCount = (result.poCountData).length;
				var poZeroCount = 0;
				$.each(result.poCountData, function(name, value) {		
					if(value.count == 0){
						poZeroCount++;
					}
					labelObject.push(value.material_type_name);
					dataObject.push(value.count);
                })	
				if(poDataCount != poZeroCount){
					$(".canvasDoughnut_Amount").css("display","block");
					$(".emptyPoCountMaterialDiv").css("display","none");	
						var chart_doughnut_settings = {
						type: 'doughnut',
						tooltipFillColor: "rgba(51, 51, 51, 0.55)",
						data: {
							labels: labelObject,
							datasets: [{
								data: dataObject,
								backgroundColor: [
									"#BDC3C7",
									"#1ABB9C",
									"#CE5454",
									"#3498DB",
									"#E74C3C"
								],
								hoverBackgroundColor: [
									"#CFD4D8",
									"#1ABB9C",
									"#9932CC",
									"#49A9EA",
									"#36CAAB"
								],
							}]
						},
						options: { 
							legend: false, 
							responsive: false 
						}
					}	
					
					$('.canvasDoughnut_Amount').each(function(){				
						var chart_element = $(this);
						var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);				
					});	
				}else{
					$(".canvasDoughnut_Amount").css("display","none");
					$(".emptyPoCountMaterialDiv").css("display","block");
				}
				
					
		  }			
	   });		
	}  
}
/********* Doughnut chart for material disaplya from MRN and amouunt total ************/
function MRNAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
	if ($('.mrn_material_type_Amount').length){
		if(startDate!='' || endDate!='' || status_value2!=''){
		var ajaxData = {'startDate':startDate , 'endDate':endDate , 'status_value2':status_value2 };
		}else{
			var ajaxData = {};
		}
		$.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){
				console.log("fffffff",result);
				result = result.MRNAmountTotalWithMaterial;
				var table = '';
				var amount1 = 0;
				var MRNTotalAmount = 0;
					table += '<h2>Material Name</h2><h2>Amount</h2><br>';
				$.each(result.MRNAmountData, function(name, value) {	
					amount1 = value.totalAmount == null?0:value.totalAmount;
					MRNTotalAmount += parseInt(amount1);
					table += '<div><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount1+'</div><br>';
                   })	
				    table += '<div><b>Total</b></div><div><b>'+MRNTotalAmount+'</b></div><br>';
				$("#completeMRNMaterialAmount").html(table);				
				var labelObject = new Array();
				var dataObject = new Array();
				var MRNDataCount = (result.MRNCountData).length;
				var MRNZeroCount = 0;
				$.each(result.MRNCountData, function(name, value) {		
					if(value.count == 0){
						MRNZeroCount++;
					}
					labelObject.push(value.material_type_name);
					dataObject.push(value.count);
                })	
				if(MRNDataCount != MRNZeroCount){
					$(".mrn_material_type_Amount").css("display","block");
					$(".emptyMrnCompleteCountMaterialDiv").css("display","none");	
						var chart_doughnut_settings = {
						type: 'doughnut',
						tooltipFillColor: "rgba(51, 51, 51, 0.55)",
						data: {
							labels: labelObject,
							datasets: [{
								data: dataObject,
								backgroundColor: [
									"#BDC3C7",
									"#1ABB9C",
									"#CE5454",
									"#3498DB",
									"#E74C3C"
								],
								hoverBackgroundColor: [
									"#CFD4D8",
									"#1ABB9C",
									"#9932CC",
									"#49A9EA",
									"#36CAAB"
								],
							}]
						},
						options: { 
							legend: false, 
							responsive: false 
						}
					}	
					
					$('.mrn_material_type_Amount').each(function(){				
						var chart_element = $(this);
						var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);				
					});	
				}else{
					$(".mrn_material_type_Amount").css("display","none");
					$(".emptyMrnCompleteCountMaterialDiv").css("display","block");
				}
				
					
		  }			
	   });		
	}  
}



/******get State id on select address *****/




/********* Doughnut chart for material display from PI complete and amount total ************/
function piCompleteStatusAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
	
	if ($('.pi_material_type_Amount').length){
		 if(startDate!='' ||  endDate!='' || status_value2!=''){
		var ajaxData = {'startDate':startDate , 'endDate':endDate , 'status_value2' :status_value2 };
		}else{
			var ajaxData = {};
		}
		 $.ajax({        
			url: site_url +'purchase/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){				
				result = result.piCompleteStatusAmountTotalWithMaterial;
				console.log("esultpiechar t",result);
				var table = '';
				var amount = 0;
				var piTotalAmount = 0;
				table += '<h2>Material Name</h2><h2>Amount</h2><br>';
				$.each(result.piAmountData, function(name, value) {	
				amount = value.totalAmount == null?0:value.totalAmount;
					table += '<div class="PIcls" data-id="'+ value.id +'"><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount+'</div><br>';
					piTotalAmount += parseInt(amount);
                })	
				table += '<div><b>Total</b></div><div><b>'+piTotalAmount+'</b></div><br>';
				$("#completePiMaterialAmount").html(table);				
				var labelObject = new Array();
				var dataObject = new Array();
				var piDataCount = (result.piCountData).length;
				var piZeroCount = 0;
				
				$.each(result.piCountData, function(name, value) {		
					if(value.count == 0){
						piZeroCount++;
					}
					labelObject.push(value.material_type_name);
					dataObject.push(value.count);
                })	
				
				if(piDataCount != piZeroCount){
				
					$(".pi_material_type_Amount").css("display","block");
					$(".emptyPoCountMaterialDiv").css("display","none");
					
						var chart_doughnut_settings = {
						type: 'doughnut',
						tooltipFillColor: "rgba(51, 51, 51, 0.55)",
						data: {
							labels: labelObject,
							datasets: [{
								data: dataObject,
								backgroundColor: [
									"#BDC3C7",
									"#1ABB9C",
									"#CE5454",
									"#3498DB",
									"#E74C3C"
								],
								hoverBackgroundColor: [
									"#CFD4D8",
									"#1ABB9C",
									"#9932CC",
									"#49A9EA",
									"#36CAAB"
								],
							}]
						},
						options: { 
							legend: false, 
							responsive: false 
						}
					}	
					
					$('.pi_material_type_Amount').each(function(){				
						var chart_element = $(this);
						var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
					});	
				}else{
					$(".pi_material_type_Amount").css("display","none");
					$(".emptyPoCountMaterialDiv").css("display","block");
				}
				
					
		  }			
	   });		
	} 

}
	$(document).on("click",".PIcls",function(){ 
	  window.location.replace(site_url+'purchase/purchase_indent/');
		 setTimeout(function(){
		//window.open(site_url+'purchase/purchase_indent/', '_blank');
		 $(".PIcls").bind("click", (function () {
			 var mat_idd = $(this).attr('data-id');
			 $(".filterBtn").removeAttr("disabled");	
			alert("Button 2 is clicked!");

			$(".filterBtn").trigger("click");
			
					
			}));
			
		 }, 6000);	
	});

function disableRadioClick(){
//alert(878);
e.preventDefault();
        e.stopPropagation();
	return false;
}
$(document).ready(function(){
	$(".departments").select2({
allowClear: true,
		placeholder: "Select Department",
		});
		
$(".status_check").select2({
allowClear: true,
		placeholder: "Select Status",
		});
$(".company_unit").select2({
allowClear: true,
		placeholder: "Select Unit",
		});			
	
	

/*********************toggle on apporve dissaprove And bar graph *************************/
$('.collapsePieGraph').click(function() {
	$('#indentApprove').slideToggle('fast');
	
});

$('.collapseBarGraph').click(function() {
	$('#monthWiseGraph').slideToggle('fast');
	
});
});




function count(string,char) {
	console.log(string);
	console.log(char);
 var re = new RegExp(char,"gi");
  return string.match(re).length;
}











/*******************    Production  Dashboard scripts    **************************/


/*bar graph for material listing*/
function getPoductionDataListingGraph(startDate = '' , endDate = ''){
	if ($('#graph_month_wise_production_data').length){
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
			}
		$.ajax({        
			url: site_url +'production/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){			
				result = result.getPoductionDataListingGraph;	
				Morris.Bar({
					element: 'graph_month_wise_production_data',
					data: result,
					//data: abc,
					xkey: 'month',
					barColors: ['#26B99A', '#34495E','#B22222' ,'#BA00C7','#122AFF' ,'#FF2525'],
					ykeys: ['sumOutput'],
					labels: ['sumOutput'],
					//ykeys: ['44','sumWastage' , 'sumElectricity', 'sumOutput' ,'sumCosting' , 'sumDowntime'],
					//labels: ['sumConsumed','sumWastage','sumElectricity' , 'sumOutput' ,'sumCosting' , 'sumDowntime'],
					hideHover: 'auto',
					xLabelAngle: 60,
					resize: true
				});			
			}			
		});		
	}
}

/*bar graph for material listing*/
function getProductionPlanning(startDate = '' , endDate = ''){
	if ($('#graph_Indent1').length){
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
			}
		$.ajax({        
			url: site_url +'production/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){			
				result = result.getProductionPlanning;
				Morris.Bar({
					element: 'graph_Indent1',
					data: result,
					xkey: 'month',
					barColors: ['#26B99A', ],
					ykeys: ['sumOutput'],
					labels: ['sumOutput'],
					hideHover: 'auto',
					xLabelAngle: 60,
					 resize: true
				});		
			}			
		});		
	}
}


function getComparison(startDate = '' , endDate = ''){
	if ($('#graph_area1').length ){
	//if ($('#lineChart').length ){	
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
			}
		$.ajax({        
			url: site_url +'production/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			success: function(result){
				//alert(JSON.stringify(result));
			console.log("dfdf");
				result = result.getComparison;
				console.log("rsssss",result);
				Morris.Area({
				  element: 'graph_area1',
				   data: result,				
				  xkey: 'date',
				  ykeys: ['sumOutput'],
				  lineColors: ['#26B99A'],
				  labels: ['Output'],
				  pointSize: 1,
				  hideHover: 'auto',
				  resize: true				 
				});
			}			
		});		
	}
}




/*******************    CRM Dashboard scripts    **************************/
function getMonthLeadStatusGraph(startDate = '' , endDate = ''){
	$("#graph_bar_group_lead").empty();
		if ($('#graph_bar_group_lead').length ){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
					//url: site_url +'crm/monthLeadStatusGraph/',
					url: site_url +'crm/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(result){	
						result = result.monthLeadStatusGraph;
						Morris.Bar({
						  element: 'graph_bar_group_lead',
						  data: result,
						  xkey: 'period',
						  barColors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000'],
						  ykeys: ['New', 'Contacted','Qualified', 'UnQualified','Win', 'Loose' ],
						  labels: ['New', 'Contacted','Qualified', 'UnQualified','Win', 'Loose' ],
						  hideHover: 'auto',
						  xLabelAngle: 60,
						  resize: true
						});
						
					}			
				});
	}
	}
	
	
	
		function dashboardLeadAcheivedVsTarget(startDate = '' , endDate = ''){	
			
		if ($('#lineChart1').length ){	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}		
			$.ajax({        
				//url: site_url +'crm/monthLeadTargetGraph/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(result){	
					console.log('result==>>',result);
					result = result.monthLeadTargetGraph;
					var ctx = document.getElementById("lineChart1");
			  var lineChart = new Chart(ctx, {
				type: 'line',
				data: {
				  labels: ["January", "February", "March", "April", "May", "June", "July","Aug","Sept","october","november","december"],
				  datasets: [{
					label: "Lead Target",
					backgroundColor: "rgba(38, 185, 154, 0.31)",
					borderColor: "rgba(38, 185, 154, 0.7)",
					pointBorderColor: "rgba(38, 185, 154, 0.7)",
					pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(220,220,220,1)",
					pointBorderWidth: 1,
					//data: [31, 74, 6, 39, 20, 85, 7,6,78,65,32,65]
					data: result.leadTarget
				  }, {
					label: "Lead Acheived",
					backgroundColor: "rgba(3, 88, 106, 0.3)",
					borderColor: "rgba(3, 88, 106, 0.70)",
					pointBorderColor: "rgba(3, 88, 106, 0.70)",
					pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
					pointHoverBackgroundColor: "#fff",
					pointHoverBorderColor: "rgba(151,187,205,1)",
					pointBorderWidth: 1,
					//data: [82, 23, 66, 9, 99, 4, 2,85,96,32,45,78]
					data: result.leadAcheived
				  }]
				},
			  });
				}			
			});
		
		
	
			
			}
			
			}
			
			
function dashboardSaleOrder(startDate = '' , endDate = ''){
	$("#graph_sale_order").empty();
	$("#graph_sale_order_count").empty();
		if ($('#graph_sale_order').length ){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
					//url: site_url +'crm/monthSaleOrderGraph/',
					url: site_url +'crm/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(result){
						result = result.monthSaleOrderGraph;	
						console.log('resultSaleOrderPriceData===>>>',result);
						
						
							saleOrderPriceJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].period;
								item ["Amount"] = $(this)[0].Amount;
								saleOrderPriceJsonObj.push(item);
							});
							
							saleOrderPriceCountJsonObj = [];
							$(result).each(function() {
								saleOrderPriceCountItem = {}
								saleOrderPriceCountItem ["period"] = $(this)[0].period;
								saleOrderPriceCountItem ["Approve"] = $(this)[0].Approve;
								saleOrderPriceCountItem ["Disapprove"] = $(this)[0].Disapprove;
								saleOrderPriceCountJsonObj.push(saleOrderPriceCountItem);
							});
							console.log('jsonObjsaleOrderPriceCountJsonObj===>>>',saleOrderPriceCountJsonObj); 
							Morris.Bar({
							  element: 'graph_sale_order',
							//  data: result,
							  data: saleOrderPriceJsonObj,
							  xkey: 'period',
							  //barColors: ['#ACADAC','#F75151' ,'#008000', '#ff0000'],
							  barColors: ['#008000','#F75151'],
							//  ykeys: ['Approve', 'Disapprove' ],
							//  labels: ['Approve', 'Disapprove' ],
							 //ykeys: ['Approve', 'Disapprove','Amount' ],
							 ykeys: ['Amount' ],
							// labels: ['Approve', 'Disapprove','Amount' ],
							 labels: ['Amount' ],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							});
							
							Morris.Bar({
							  element: 'graph_sale_order_count',
							//  data: result,
							  data: saleOrderPriceCountJsonObj,
							  xkey: 'period',
							  //barColors: ['#ACADAC','#F75151' ,'#008000', '#ff0000'],
								barColors: ['#008000','#ff0000' ,'#F75151'],
								labels: ['Approve', 'Disapprove'],
								ykeys: ['Approve', 'Disapprove'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							});
						
						
						
						
						
						
						
					}			
				});
	}
	}
	
	
	
	function getLeadStatusGraph(startDate = '' , endDate = ''){
			if($("#graph_donut_lead").length) {	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
			
				$.ajax({        
				//	url: site_url +'crm/getLeadStatusGraph/',
					url: site_url +'crm/graphDashboardData/',
					dataType: 'json',
					type: 'POST',
					//data: {},
					data: ajaxData,
					success: function(response){							
						//var result = response[0];
						var result = response.getLeadStatusGraph[0];
						console.log('result===>>',result);
						var ptotal = parseInt(result.New) + parseInt(result.Contacted) + parseInt(result.Qualified) + parseInt(result.Unqualified) + parseInt(result.Win) + parseInt(result.Loose);
						if(ptotal == 0){
							//$("#graph_donut_lead").css("display","none");
							$("#graph_donut_lead").empty();
							$("#graph_donut_lead").html("No Data");
							
						}
						Morris.Donut({
							element: 'graph_donut_lead',
							data: [
									{label: 'New', value: ((parseInt(result.New)/ ptotal) * 100).toFixed(2), count: result.New},
									{label: 'Contacted', value: ((parseInt(result.Contacted)/ ptotal) * 100).toFixed(2), count: result.Contacted},
									{label: 'Qualified', value: ((parseInt(result.Qualified)/ ptotal) * 100).toFixed(2), count: result.Qualified},
									{label: 'UnQualified', value: ((parseInt(result.Unqualified)/ ptotal) * 100).toFixed(2), count: result.Unqualified},
									{label: 'Win', value: ((parseInt(result.Win)/ ptotal) * 100).toFixed(2), count: result.Win},
									{label: 'Loose', value: ((parseInt(result.Loose)/ ptotal) * 100).toFixed(2), count: result.Loose}
									],
							colors: ['#F75151', '#34495E', '#ACADAC', '#3498DB', '#008000', '#ff0000'],
							formatter: function (y,data) {	
							return data.count + "  (" + y + "%" +")";					 
							},
							resize: true
							});
						
					}			
				});
		}
	}
	
	
	function getWinLeadVsTotalGraph(startDate = '' , endDate = ''){
		if($(".progress").length) {	
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getWinLeadVsTotalGraph/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){							
					var result = response.getWinLeadVsTotalGraph[0];
					$('.win').html('Success : '+result.Win);
					$('.total').html('Total : '+result.Total);
					if(result.Win == 0){
							var winPercentage = 0;
					}else{
						var winPercentage = result.Win * 100 / result.Total;
					}						
					$('.progress-bar').css('width',winPercentage+'%');
				}			
			});
		}	
	}
	
	/*   Show Upper counts from each module of CRM  */
	/*function getDashboardCount(startDate = '' , endDate = ''){
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({        
				//url: site_url +'crm/getDashboardCount/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){
					console.log('response===>>',response);	
					var dashboardCountHtml = '';	
					$.each( response.getDashboardCount, function( key, value ) {
						dashboardCountHtml += '<div  style="width:20%;" class=" animated flipInY col-lg-2 col-md-2 col-sm-6 col-xs-12"><div class="tile-stats" ><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalCount+'</div><h3>'+value.name+'</h3><p>'+value.description+'</p></div></div>';
					});
					$('.top_tiles').html(dashboardCountHtml);
					
				}			
			});
	}
	*/
	
	
	
		
	function getRecentActivities(startDate = '' , endDate = ''){			
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({  
				//url: site_url +'crm/recentActivitiesDashboardData/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){	
					console.log('resonse===>>>',response);
						var leadActicityHtml = '';
						if($.isEmptyObject(response.leadActivity)){
							$('.leadDashboardActivity').html('No  records');
						}else{
						$.each( response.leadActivity, function( key, value ) {
							console.log('value===>>>',value);
							var company = value.company == null?'Lead':value.company;
							leadActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+company+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						
						$('.leadDashboardActivity').html(leadActicityHtml);
						}
						
						
						
						var accountActicityHtml = '';
						if($.isEmptyObject(response.accountActivity)){
							$('.accountDashboardActivity').html('No  records');
						}else{
						$.each( response.accountActivity, function( key, value ) {
							console.log('value===>>>',value);
							var accountName = value.name == null?'Account':value.name;
							accountActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						$('.accountDashboardActivity').html(accountActicityHtml);
						}
						
						var saleOrderActicityHtml = '';
						if($.isEmptyObject(response.saleOrderActivity)){
							$('.saleOrderDashboardActivity').html('No  records');
						}else{
						$.each( response.saleOrderActivity, function( key, value ) {
							console.log('value===>>>',value);
							var accountName = value.name == null?'Account':value.name;
							var contactName = value.first_name == null?'Contact':value.first_name + ' ' +value.last_name;
							saleOrderActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Contact Name To : '+contactName+'</a></span><div class="byline"><span>Due Date: '+value.payment_date+'</span></div></div><div class="byline"></div><p class="excerpt">Amount : '+value.grandTotal+'</a></p></div></div></li>';
						});
						$('.saleOrderDashboardActivity').html(saleOrderActicityHtml);
						}
						
				}			
			});		
	}
	
	
	function getCrmTableData(startDate = '' , endDate = ''){			
				if(startDate!='' && endDate!=''){
					ajaxData = {'startDate':startDate , 'endDate':endDate};
				}else{
					ajaxData = {};
				}
				$.ajax({  
				//url: site_url +'crm/recentActivitiesDashboardData/',
				url: site_url +'crm/graphDashboardData/',
				dataType: 'json',
				type: 'POST',
				data: ajaxData,
				success: function(response){	
					console.log('resonse===>>>',response);
						/* var leadActicityHtml = '';
						$.each( response.leadActivity, function( key, value ) {
							console.log('value===>>>',value);
							var company = value.company == null?'Lead':value.company;
							leadActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+company+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						$('.leadDashboardActivity').html(leadActicityHtml);
						
						var accountActicityHtml = '';
						$.each( response.accountActivity, function( key, value ) {
							console.log('value===>>>',value);
							var accountName = value.name == null?'Account':value.name;
							accountActicityHtml += '<li><div class="block"><div class="block_content"><h2 class="title"><a>'+accountName+'</a></h2><div class="byline"><span>Created Date: '+value.created_date+'</span></div> <div class="byline"><span> <a>Assigned To : '+value.name+'</a></span><div class="byline"><span>Due Date: '+value.due_date+'</span></div></div><div class="byline"><span>Subject : '+value.subject+'</span></div><p class="excerpt">'+value.comment+'</a></p></div></div></li>';
						});
						$('.accountDashboardActivity').html(accountActicityHtml); */
				}			
			});		
	}
	
	 
  
  /*****************************************  Accounts graph       ***********************************************/
  
/*   income expense dashboard graph      */
function dashboardPurchaseExpense(startDate = '' , endDate = ''){
	if ($('#graph_income_expanse').length ){
		if(startDate!='' && endDate!=''){
			ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			ajaxData = {};
		}	
		$("#graph_income_expanse").empty();			
				$.ajax({   
					url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
					dataType: 'json',
					type: 'POST',
					data:   ajaxData,
					success: function(result){
						 result = result.monthWiseIncomeExpenseAmountGraph;
							incomeExpensePriceJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].month;
								item ["expense"] = $(this)[0].expense;
								item ["income"] = $(this)[0].income;
								incomeExpensePriceJsonObj.push(item);
							});
							Morris.Bar({
							  element: 'graph_income_expanse',
							  data: incomeExpensePriceJsonObj,
							  xkey: 'period',
							  barColors: ['#26B99A', '#3498db', '#ACADAC', '#3498DB'],
							  ykeys: ['income', 'expense'],
							  labels: ['Income', 'Expense'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							}); 
					}

				});
			}

}

/*   Material sale dashboard graph      */
	function dashboardMaterialSale(startDate = '' , endDate = ''){		
	$("#graph_material_sale").empty();		
		if ($('#graph_material_sale').length ){
			if((startDate!='') && (endDate!='')){ 
				ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				ajaxData = {};
			}
			$.ajax({   
				url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
				dataType: 'json',
				type: 'POST',
				data:   ajaxData,
				success: function(result){
						result = result.materialSaleAmountGraph;					
						materialSaleAmountJsonObj = [];
						$(result).each(function() {
							item = {}
							item ["label"] = $(this)[0].matarial_name;
							item ["value"] = $(this)[0].amount;
							materialSaleAmountJsonObj.push(item);
						});							
							Morris.Donut({
							  element: 'graph_material_sale',								
							  data: materialSaleAmountJsonObj,
							  colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
							  formatter: function (y) {
								return y + " Rs";
							  },
							  resize: true
							});
				}
			});
		}	
	}
	
	
/*   Payment done and received dashboard graph   */	
	function dashboardPaymentReceivedDone(startDate = '' , endDate = ''){	
		$("#graph_payment_received_done").empty();		
		if ($('#graph_payment_received_done').length ){
			if(startDate!='' && endDate!=''){
				ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				ajaxData = {};
			}
			$.ajax({   
				url: site_url +'account/monthWiseIncomeExpenseAmountGraph/',
				dataType: 'json',
				type: 'POST',
				data:  ajaxData,
				success: function(result){
						result = result.monthWiseCashFlowGraph;
							monthWiseCashFlowGraphJsonObj = [];
							$(result).each(function() {
								item = {}
								item ["period"] = $(this)[0].month;
								item ["paymentReceived"] = $(this)[0].paymentReceived;
								item ["paymentDone"] = $(this)[0].paymentDone;
								monthWiseCashFlowGraphJsonObj.push(item);
							});
							
							Morris.Bar({
							  element: 'graph_payment_received_done',
							  data: monthWiseCashFlowGraphJsonObj,
							  xkey: 'period',
							  barColors: ['#26B99A', '#3498db', '#ACADAC', '#3498DB'],
							  ykeys: ['paymentReceived', 'paymentDone'],
							  labels: ['Payment Received', 'Payment Done'],
							  hideHover: 'auto',
							  xLabelAngle: 60,
							  resize: true
							}); 
				}
			});
		}	
	}
	
	
	
	/**************** Inventory graph *****************/
	
/***************************************bar graph for material listing***************************************************/
function getMonthInventoryListingGraph(startDate = '' , endDate = ''){
	if ($('#month_Wise_graph').length){
			if(startDate!='' && endDate!=''){
				var ajaxData = {'startDate':startDate , 'endDate':endDate};
			}else{
				var ajaxData = {};
			}
		
			$.ajax({        
				url: site_url +'inventory/graphDashboardData/',
				dataType: 'json',
				type: 'POST',				
				data: ajaxData,
				success: function(result){
					result = result.getMonthInventoryListingGraph;
					console.log(result);
					Morris.Bar({
					  element: 'month_Wise_graph',
					  data: result,
					  xkey: 'period',
					  barColors: ['#26B99A', '#34495E','#B22222','#E11CD2' ,'#CD853F'],
					  ykeys: ['scrapQty','consumedQty', 'moveQty','halfBookQty' , 'stockCheckQty'],
					  labels: ['Scrap','Move','Consumed' , 'Half/Full book','stock check'],
					  hideHover: 'auto',
					  xLabelAngle: 60,
					  resize: true
					});		
				}			
			});		
	}
}

/**********************************************stock summary graph*****************************************************************************/
function getStockSummary(startDate = '' , endDate = ''){					  
	if ($('#material_type_graph_donut').length){
		
		if(startDate!='' && endDate!=''){
			var ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			var ajaxData = {};
		}
		$.ajax({        
			url: site_url +'inventory/graphDashboardData/',
			dataType: 'json',
			type: 'POST',				
			data: ajaxData,
			
			success: function(result){
				var result = result.getStockSummary;
					var labelObject =new Array();
						$.each(result, function (key, val) {
							labelObject.push({
								label: val.Name, 
								value:  val.total
							});
						});
						Morris.Donut({
							element: 'material_type_graph_donut',
							data:labelObject,
							colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB','#FF0000' ,'#FFFF00','#F08080','#FF4500','#FFD700','#FF8C00','#008000','#556B2F','#20B2AA','#008080','#1E90FF','#0000CD','#FF00FF','#800080','#FF69B4','#C71585','#DAA520','#8A2BE2','#DDA0DD','#87CEFA','#000080','#483D8B','#4B0082','#2F4F4F','#800000','#A0522D','#7FFFD4','#008B8B','#32CD32','#FFA07A'],
								formatter: function (y) {
								return y ;
							},
							resize: true
						});
			}			
		});		
	}  
}


/***************************************************get scrapped detail******************************************************************/
function getScrappedDetail(startDate = '' , endDate = ''){
	if($("#scrappedDiv").length) {	
		if(startDate!='' && endDate!=''){
			ajaxData = {'startDate':startDate , 'endDate':endDate};
		}else{
			ajaxData = {};
		}
		$.ajax({      
			url: site_url +'inventory/graphDashboardData/',
			dataType: 'json',
			type: 'POST',
			data: ajaxData,
			success: function(response){
				var result = response.getScrappedDetail;
				var scrappedData = '';
				var i = 0;
				$.each(result, function (index,value) {
					var Width =  value.sum;
					scrappedData += '<div class="widget_summary"><div class="w_left w_25"><span class="ConsumedScrap">'+value.name+'</span></div><div class="w_center w_55"><div class="progress"><div class="progress-bar bg-green pg4" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:'+Width+'%"><span class="sr-only"></span></div></div></div><div class="w_right w_20"><span class="totalConsumed">'+value.sum +'-'+value.uom+'</span></div><div class="clearfix"></div></div>';
				});
				$('#scrappedDiv').html(scrappedData);	
			}		
		});
	}
}	


