
  function commanSelect2() {
      $('.commanSelect2').select2();
    }
 /**********************Multi sale-ordeer  *********************************************/
 $(document).ready(function(){
    $('.machinePurchaseDate').daterangepicker({ // To hide dates after current date in date picker                          
                            locale: {
                                format: 'DD-MM-YYYY',
                            },
                            singleDatePicker: true,
                            maxDate: new Date(),
                            singleClasses: "picker_3"
                        }, function(start, end, label) {
                            console.log(start.toISOString(), end.toISOString(), label);
                        });
   });
$(document).ready(function () {
     //  $.ajax({ 
     //    url: site_url+'production/getAllSemiProduct/',
     //     success: function(response) {
     //        if (response) {
     //             $('#semiProductName').html(response)
     //        }
     //    }
     // });
    // Setup - add a text input to each footer cell
    $('#sale_price_updatde thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#sale_price_updatde thead');
 
    var table = $('#sale_price_updatde').DataTable({
            scrollY: 400,
            scrollX: true,
            scroller: true,
        orderCellsTop: true,
        fixedHeader: true,
         
        initComplete: function () {

            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
					
                
                   /* if(title == "Semi Product Name"){
                    $(cell).html('<select style="width: 100%;padding: 6px 0px; " class="commanSelect2" id="semiProductName" ><option value="" >Select Option</option></select>');
                    $(
                        'select',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('change')
                        .on('change', function (e) {
                            e.stopPropagation();
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                           // $(this)
                             //   .focus()[0]
                               // .setSelectionRange(cursorPosition, cursorPosition);
                        });
                    } else { */
                     $(cell).html('<input type="text" placeholder="' + title + '" />');   
                     $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
							
							// if(title == ""){
								// regexr.replace('{search}', '(((' + this.value + ')))');
							// }
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                  /*  } */
                    
 
                    // On every keypress in this input
                    
                });
        },
    });
    commanSelect2();
});

  /**********************multi sale-order*********************************************/

  
$(document).ready(function () {
    $('#selecctallSaleorder').click(function (event) { //on click
        if (this.checked) { // check select status
              var totalSaleOrder=totalworkOrderQty =0;
              var saleOrderNo = [];
              var saleOrderId = [];
              var job_cardID = '';
              var materialNameID = '';
              var materialTypeID = '';
              var customerNameID = [];
            $('.checkboxSaleOrder').each(function () {  //loop through each checkbox
                this.checked = true; //select all checkboxes with class "checkbox1"
                 id=$(this).closest('.rowtr').attr("id"); 
                 var workorderqty=$('#' +id).find('.workorderqty').val();
                    $('#' +id).find('.saleOrderPandingQty').each(function(){
                      totalSale  = parseInt($(this).val());
                      totalSaleOrder += totalSale;
                     });
                     $('#' +id).find('.workorderqty').each(function(){
                      totalworkOrder  = parseInt($(this).val());
                      totalworkOrderQty += totalworkOrder;
                     });  
                    var saleOrder_no = $('#' +id).find('.saleOrderno').val();
                        saleOrderNo.push(saleOrder_no);
                    var saleOrder_id  = $('#' +id).find('.saleOrderno').attr('saleOrderID');          
                        saleOrderId.push(saleOrder_id); 
                        materialNameID = $('#' +id).find('.materialName').val();
                        materialTypeID  = $('#' +id).find('.materialName').attr('materialTypeID');          
                        job_cardID  = $('#' +id).find('.materialName').attr('job_card');          
                     var customerName_id = $('#' +id).find('.customerName').val();
                        customerNameID.push(customerName_id);
                      $('#totalsaleOrderQty').val(totalSaleOrder); 
                      $('#totalworkorderqty').val(totalworkOrderQty); 
                      $('#workorderleftQty').val('0');
                      $('.job_card').val(job_cardID);
                      $('.sale_order_id').val(saleOrderId);
                      $('.sale_order_no').val(saleOrderNo);
                      $('.material_name').val(materialNameID);
                      $('.materialType').val(materialTypeID);
                      $('.customer_name_id').val(customerNameID);
            });
        } else {
            $('.checkboxSaleOrder').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
                        
                        $('.job_card').val('');
                        $('#totalworkorderqty').val('0'); 
                        $('#totalsaleOrderQty').val('0'); 
                        $('#workorderleftQty').val('0');
                        $('.sale_order_id').val('');
                        $('.sale_order_no').val('');
                        $('.material_name').val('');
                        $('.materialType').val('');
                        $('.customer_name_id').val('');
            });
        }
    });
 });
function getDataOnCheck(event,t){
	  var TrId = $(t).closest('.rowtr').attr("id");
      var workorderqty=$('#' +TrId).find('.workorderqty').val(); 
      var totalSaleOrderOld=$('#totalsaleOrderQty').val();  
      var totalworkorderqtyOld=$('#totalworkorderqty').val();
      var totalSale  = totalworkOrder = 0;
      var saleOrderNo = [];
      var job_cardID = '';
      var saleOrderId = [];
      var materialNameID = '';
      var materialTypeID = '';
      var customerNameID = [];
     
       $('.checkboxSaleOrder').each(function(){    
              
            if($(this).is(":checked")){
                var TrId = $(this).closest('.rowtr').attr("id"); 
                var saleOrder_no = $('#' +TrId).find('.saleOrderno').val();
                     saleOrderNo.push(saleOrder_no);
                var saleOrder_id  = $('#' +TrId).find('.saleOrderno').attr('saleOrderID');          
                     saleOrderId.push(saleOrder_id);    
                     materialNameID = $('#' +TrId).find('.materialName').val();

                     materialTypeID  = $('#' +TrId).find('.materialName').attr('materialTypeID');          
                     job_cardID  = $('#' +TrId).find('.materialName').attr('job_card');          
                 var customerName_id = $('#' +TrId).find('.customerName').val();
                     customerNameID.push(customerName_id);  
                         $('#' +TrId).find('.workorderqty').attr('name', 'convortWorkOrderQty[]');
                         $('#' +TrId).find('.saleOrderqty').attr('name', 'totalSaleOrder_Qty[]');
                         $('#' +TrId).find('.materialName').attr('name', 'material_name[]');
                         $('#' +TrId).find('.customerName').attr('name', 'customer_name_id[]');
                         $('#' +TrId).find('.semiProductName').attr('name', 'semiProductNameid[]');
                         $('#' +TrId).find('.job_cardNo').attr('name', 'job_card[]');
                         $('#' +TrId).find('.material_type_id').attr('name', 'material_type_id[]');
                         $('#' +TrId).find('.saleOrderPandingQty').attr('name', 'saleOrderPandingQty[]');

                         ///Get Material QTY ///
                            $.ajax({
                             type: "POST",
                             url: site_url + 'production/getMaterialQty',
                             data: {
                                materialNameID: materialNameID
                             },
                            success: function(data) {
                              $('.availableQty').val(data);
                            }

                            });

                         ///Get Material QTY ///
                  } 
         });  
      $('#' +TrId).find('.saleOrderPandingQty').each(function(){
           totalSale  = parseInt($(this).val());        
       }); 
        $('#' +TrId).find('.workorderqty').each(function(){
            totalworkOrder  = parseInt($(this).val());
        });
      var subTotal = totalworkOrderQty = workorderLefQty = 0;
       if($(t).is(":checked")){
        subTotal=parseInt(totalSaleOrderOld) + parseInt(totalSale);
        totalworkOrderQty=parseInt(totalworkorderqtyOld) + parseInt(totalworkOrder);
        setTimeout(function () { 
       if(totalSaleOrderOld > totalworkorderqtyOld){
            workorderLefQty = totalSaleOrderOld - totalworkorderqtyOld;
	   }else if(totalSaleOrderOld==totalworkorderqtyOld){
            workorderLefQty = 0;
        }
    }, 1000);
      }else{
        subTotal=totalSaleOrderOld-totalSale;
        totalworkOrderQty = totalworkorderqtyOld-totalworkOrder;
        setTimeout(function () { 
        if(totalSaleOrderOld > totalworkorderqtyOld){
            workorderLefQty = totalSaleOrderOld - totalworkorderqtyOld;
        }else if(totalSaleOrderOld==totalworkorderqtyOld){
            workorderLefQty = 0;
        }
       }, 1000);
      }   
       $('#' +TrId).find('.workorderqty').css("display", "block");  
       $('.job_card').val(job_cardID);
       $('.material_name').val(materialNameID);
       $('.materialType').val(materialTypeID);
       $('.customer_name_id').val(customerNameID);
       $('.sale_order_id').val(saleOrderId);
       $('.sale_order_no').val(saleOrderNo);
       $('#totalsaleOrderQty').val(subTotal); 
       $('#totalworkorderqty').val(totalworkOrderQty);  
       $('#workorderleftQty').val(workorderLefQty);
       
       
 }

function  getWorkorederAdd(event,t){
      var TrId = $(t).closest('.rowtr').attr("id");
       var totalsaleOrderQtyOld = $('#totalsaleOrderQty').val();
       var totalworkorderqtyOld = $('#totalworkorderqty').val();
      if ($('#' +TrId).find('.checkboxSaleOrder').is(":checked")){
       
        var newWorkOrderQty = 0;
        $('.checkboxSaleOrder').each(function(){            
            if($(this).is(":checked")){
               var TrId = $(this).closest('.rowtr').attr("id");      
                 newWorkOrderQty += parseInt($('#' +TrId).find('.workorderqty').val());
              }
         });    
       var new_workorder_val = newWorkOrderQty;
       var workorderLefQty = totalsaleOrderQtyOld - newWorkOrderQty;
     if (new_workorder_val){  
       $('#totalworkorderqty').val(new_workorder_val); 
       $('#workorderleftQty').val(workorderLefQty); 
       }
      }else{
         $('#' +TrId).find('.workorderqty').css("display", "none");
    }
       
 }  

 function getWorkOrderAbQty(event,t){
      var workOrderID=$(t).val();
     $.ajax({
        type: "POST",
        url: site_url + 'production/getWorkOrderAbQty',
        data: {
        workOrderID: workOrderID
        },
        success: function(data) {
          $('.availableQty').text(data);
        }

        });
}
/*****************Add *******************/

// $(document).on('change', '.checkboxSaleOrder', function (event) {
// var TrId = $(this).closest('.rowtr').attr("id");
// var  saleOrderNo = [];
// $('.checkboxSaleOrder:checked').each(function(n){
//     alert($(this).val());
//     $(this).next('td').addClass('input');
//         //var saleOrder_no = $(this).next('td').find('input').val();         
//             saleOrderNo.push(saleOrder_no);       
//        });
// console.log(saleOrderNo);
// });