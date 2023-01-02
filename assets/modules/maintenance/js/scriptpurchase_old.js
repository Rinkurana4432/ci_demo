/*function selectTwo(){
//alert(7777);
$("select").select2();
 }*/

/******-------------Purchase Order Editable table------------------- *****/
function PoEditTbl(){
const $tableID = $('#table_edit');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTr = `
 <tr>
            <td class="pt-3-half" contenteditable="false">
      <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
                      <option value="">Select Option</option>
                    </select>
      </td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
      <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half" contenteditable="true"></td>
            <td>
              <span class="table-remove">
        <a href="#!"  class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;

 $('.table_add').on('click', 'p', () => {

   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

   if ($tableID.find('tbody tr').length === 0) {

     $('tbody').append(newTr);
   }

   $tableID.find('table').append($clone);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });




 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
/******-------------Purchase Order Editable table ------------------- *****/
  /******-------------Add Charges in Purchase Order Editable table  ------------------- *****/
 function poaddCharges(){
 var row=1;
  $(document).on("click", "#add-row", function () {
  var new_row = `
<tr>
            <td class="pt-3-half" contenteditable="false">
      <select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)">
                      <option value="">Select Option</option>
                    </select>
      </td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
      <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half" contenteditable="true"></td>
            <td>
              <span class="table-remove">
        <a href="#!"  class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;
      //console.log('new_row===>>>>',new_row);
   
  $('tbody').append(new_row);
  row++;
  return false;
  });
 }

/******-------------End  ------------------- *****/
/******-------------Purchase Indent Editable table------------------- *****/
function PiEditTbl(){
const $tableID = $('#table_edit');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTr = `
<tr>
            <td class="pt-3-half" contenteditable="false">  </td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
      <td class="pt-3-half only-numbers" contenteditable>
      </td>
            <td class="pt-3-half " contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable></td>
            <td>
              <span class="table-remove">
        <a href="#!"  class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;

 $('.table_add').on('click', 'p', () => {

   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

   if ($tableID.find('tbody tr').length === 0) {

     $('tbody').append(newTr);
   }

   $tableID.find('table').append($clone);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });




 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
/******-------------Purchase Indent Editable table ------------------- *****/
  /******-------------Add Charges in Purchase Indent Editable table  ------------------- *****/
 function piaddCharges(){
 var row=1;
  $(document).on("click", "#add-row", function () {
    //alert(11);
  var new_row = `
<tr>
            <td class="pt-3-half" contenteditable="false">  </td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
      <td class="pt-3-half only-numbers" contenteditable>
      </td>
            <td class="pt-3-half " contenteditable></td>
            <td class="pt-3-half noeditable" contenteditable></td>
            <td>
              <span class="table-remove">
        <a href="#!"  class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;
      //console.log('new_row===>>>>',new_row);
   
  $('tbody').append(new_row);
  row++;
  return false;
  });
 }

/******-------------End ------------------- *****/
/******-------------Editable table MRN------------------- *****/
function EditTbl(){
const $tableID = $('#table_edit');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTr = `
<tr>
            <td class="pt-3-half" contenteditable="true">1</td>
            <td class="pt-3-half" contenteditable="true">2</td>
            <td class="pt-3-half" contenteditable="true">3</td>
            <td class="pt-3-half" contenteditable="true">4</td>
      <td class="pt-3-half" contenteditable="true">5</td>
            <td class="pt-3-half" contenteditable="true">6</td>
            <td class="pt-3-half" contenteditable="true">7</td>
            <td class="pt-3-half" contenteditable="true">8</td>
      <td class="pt-3-half" contenteditable="true">9</td>
            <td class="pt-3-half" contenteditable="true">10</td>
            <td>
              <span class="table-remove">
        <a href="#!" data-tooltip="Delete" class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;

 $('.table_add').on('click', 'p', () => {

   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

   if ($tableID.find('tbody tr').length === 0) {

     $('tbody').append(newTr);
   }

   $tableID.find('table').append($clone);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });




 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
/******-------------Editable table End ------------------- *****/
  /******-------------Add Charges in MRN Editable table  ------------------- *****/
 function addCharges(){
 var row=1;
  $(document).on("click", "#add-row", function () {
    //alert(11);
  var new_row = `
<tr>
            <td class="pt-3-half" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
      <td class="pt-3-half only-numbers" contenteditable="true"></td>
            <td class="pt-3-half only-numbers" contenteditable="true"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half only-numbers" contenteditable="true"></td>
      <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td class="pt-3-half noeditable" contenteditable="false"></td>
            <td>
              <span class="table-remove">
        <a href="#!" data-tooltip="Delete" class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;
      //console.log('new_row===>>>>',new_row);
   
  $('tbody').append(new_row);
  row++;
  return false;
  });
 }

/******-------------End Add Charges in MRN Editable table ------------------- *****/
/******-------------Editable table Supplier modal------------------- *****/
function editSupplierTbl(){
const $tableID = $('#table_edit');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTrSupplr = `
 <tr>
            <td class="pt-3-half" contenteditable="false">
      <select class="materialNameId form-control  selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)" data-id="material" data-key="id" data-fieldname="material_name" data-where="created_by_cid=<?php echo $_SESSION['loggedInUser']->c_id; ?> AND status=1" >
      <option value="">Select Option</option>
      </select>
      </td>
          <td class="pt-3-half noeditable" contenteditable="false"></td>
        <td>
              <span class="table-remove">
        <a href="#!" data-tooltip="Delete" class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;
 $('.table_add').on('click', 'p', () => {
   const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');

   if ($tableID.find('tbody tr').length === 0) {

     $tableID.find('tbody').append(newTrSupplr);
   }

   $tableID.find('table').append($clone);
 });

 $tableID.on('click', '.table-remove', function () {

   $(this).parents('tr').detach();
 });




 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
/******------------- End Editable table Supplier modal------------------- *****/

/******-------------Editable table Supplier modal Contact Details------------------- *****/
function editContactTbl(){
const $tableID = $('#table_edit_contact');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTrContact = `
<tr>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half" contenteditable></td>
            <td class="pt-3-half only-numbers" contenteditable></td>
      <td>
              <span class="table-remove">
        <a href="#!" class="btn btn-delete btn-lg" >
        <i class="fa fa-trash"></i></a>
      </span>
            </td>
          </tr>`;

$('.table_contact_supplr').on('click', '.addcontact', () => {
  const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line');
  if ($tableID.find('tbody tr').length === 0) {
    $tableID.find('tbody').append(newTrContact);
  }
  $tableID.find('table').append($clone);
});

$tableID.on('click', '.table-remove', function () {
   $(this).parents('tr').detach();
});




 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', () => {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach((header, i) => {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
}
/******------------- End Editable table Supplier modal Contact Details------------------- *****/

/************ prefix of material type ************/ 
$('.material_type').on('change',function(){
  var materialTypePrefix = $('option:selected', this).attr('material_type_prefix');
  $(".prefix").html(materialTypePrefix);
  $(".matPrefix").val(materialTypePrefix);
}); 
  
/************ id proof jquery ************/
function IdProof(){
  $("#proof").on('change', function () {
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#profile-holder");
      image_holder.empty();
      var reader = new FileReader();
      reader.onload = function (e) {
        $("<img />", { "src": e.target.result,"class": "", "height":"100px", "width":"100px"}).appendTo(image_holder);
      }
      image_holder.show();
      reader.readAsDataURL($(this)[0].files[0]);
    } else { 
      alert("This browser does not support FileReader."); 
    }
  });
} 

/************ get address corresponding to supplier name ************/
function getSupplierAddress(evt, t){
  var option = $(t).find('option:selected');
  var supplierId = option.val();
  $.ajax({
    type: "POST",
    url: site_url + 'purchase/getSupplierAddressId',
    data: {id:supplierId}, 
    success: function(data){
      if(data != '') {
        var dataObj =JSON.parse(data);      
        $("#address").val(dataObj.address);
      }
    }
  });      
}
 
 
 /************ freight button hide show ************/
function showFreight(){
  //$(function() {    
  
    if($("input[name='terms_delivery']:checked").val() =='To be paid by customer'){   
      $('#freight1').show();
    }else{
      $('#freight1').hide();
    }
    //$('#freight1').hide();
    $('input[name="terms_delivery"]').on('click', function() {
      if ($(this).val() != 'FORPrice') {
        $('#freight1').show();
      }
      else {
        $('#freight').val('');
        $('#freight1').hide();
        keyupFunction();
      }
      
      $('.ad_rm_readonly').prop('disabled', true);
        init_select2();
      var sale_company_state_idd = $('#sale_company_state_id').val();
      var party_billing_state = $('#party_billing_state_id').val();
      
      
        if(party_billing_state != sale_company_state_idd){
           $('.cgst_amt1').hide();
           $('.sgst_amt1').hide();
           $('.igst_amt1').show();
         }else{
            $('.cgst_amt1').show();
            $('.sgst_amt1').show();
            $('.igst_amt1').hide();
         }
    });
  //});
}


  
  
/************ modal OF all modules ************/
$(document).on("click",".add_purchase_tabs",function(){
  var id = $(this).attr('id');
  var tab = $(this).attr('data-id');

  var url = '';
  switch (tab) {
       case 'purchase':
                url = 'maintenance/purchase/';
                break;
      
      
    } 
    //alert('therdde');
    
    //if(tab == 'poCreate'){
    if(tab == 'convert_to_po'){
        $('.nxt_cls').html('Purchase Order');
    }
    
    if(tab == 'indentEdit'){
      
       $('.nxt_cls').html('Purchase Indent');
    }

    //if(tab == 'MrnEdit'){
    if(tab == 'convert_to_mrn'){
        $('.chng_lbl').html('GRN');
    }
    if(tab == 'convert_to_mrn_through_pi'){
        $('.chng_lbl').html('GRN');
    }
    if(tab == 'SupplierView'){
      $('.nxt_cls').html("Supplier View");
    }
    if(tab == 'OrderView'){
      $('.addtitle2').html('Purchase View');
    } 
    if(tab == 'indentView'){
      $('.addtitle2').html('Indent View');
    }
    if(tab == 'MRNView'){
      $('.addtitle1').html('GRN View');
      
    }   
      
    $.ajax({
      type: "POST",
      url: site_url + url,
      data: {id:id}, 
      success: function(data){
        $("#purchase_add_modal").modal({
          show:false,
          backdrop:'static'
        });
        if(data != '') {          
          if($('#purchase_add_modal').length){
            $('#purchase_add_modal').modal('show');
            $('#purchase_add_modal .modal-body-content').html(data);
               setTimeout(function(){ 
                 $("body").addClass("modal-open"); 
               }, 1000);
            checkDefectedMaterialsofMrn();
          }else{
            $('#common_modal').modal('toggle');
            $('#common_modal .modal-body-content').html(data);
            
            
          }
          /*display date*/
          var date = new Date();
            //date.setDate(date.getDate()-0);
            $('.delivery_date').datepicker({ 
            //startDate: date,
            format: 'dd-mm-yyyy',
          });
          /**/
          
          
          $('.datePicker').daterangepicker({
          singleDatePicker: true,
          minDate: new Date(),
          singleClasses: "picker_3",
          locale: {
              format: 'YYYY-MM-DD',
          }
          }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
          }); 
              
          if(tab =='editSupplier' || tab =='editSupplierNew'){
            
          addMoreSupplierContacts();
          addMoreSupplierProof();
          addMoreSupplierMaterial();
          IdProof();
          getTax();
          Get_Ledger_accodingTo_Parent();
          Get_account_group_or_parent_group_id();
          editSupplierTbl();
          editContactTbl();
          $('.cls_add_select2').select2();
          
          
          //}else if(tab =='indentEdit' || tab == 'poCreate'){
          }else if(tab =='indentEdit' || tab == 'convert_to_po' || tab =='indentEditNew'){
          //getSupplierAddress();
          IndentAddMoreMaterial();
          dateFunction();
          showFreight();
          getAddress();
          PurchaseAddMaterial();
          add_more_charges_details();
          
          add_charges_on_purchase();
          get_state_id_onselect();
          
          PiEditTbl();
          piaddCharges();
          remove_mat_during_convert_po();
          //getData();
          addMoredocuments();
          close_modal_Script();
          //}else if( tab == 'editOrder' || tab == 'MrnEdit'){          
          }else if( tab == 'editOrder' || tab == 'po_edit' || tab == 'po_edit_new' ){ 
          
          dateFunction();
          showFreight();
          getAddress();
          PurchaseAddMaterial();
          getTax();
          starRating();
          keyupFunction();
          IdProof();
          add_more_charges_details();
          get_state_id_onselect();
          PoEditTbl();
          poaddCharges();
          add_charges_on_purchase();
          //selectTwo();
          init_select_forAdd_suplier();
          remove_mat_during_edit();   
          addMoredocuments();
          close_modal_Script();
          //}else if(tab == 'MrnEdit'){
          }else if(tab == 'convert_to_mrn'){
            getAddress();
            get_state_id_onselect();
            add_more_charges_details();
            dateFunction();
            showFreight();
            AddMoreMaterialMrn();
            add_charges_on_purchase();
            getTax();
            starRating();
            keyupFunction();
            IdProof();
            remove_mat_during_convert_po();
            close_modal_Script();
          }else if(tab == 'convert_to_mrn_through_pi'){
            getAddress();
            get_state_id_onselect();
            add_more_charges_details();
            dateFunction();
            AddMoreMaterialMrn();
            add_charges_on_purchase();
            getTax();
            showFreight();
            remove_readonly();
            starRating();
            keyupFunction();
            remove_mat_during_convert_po();
            close_modal_Script();
          }else if( tab == 'EditMRN'){
            AddMoreMaterialMrn();
            add_more_charges_details();
            starRating();
            dateFunction();
            add_charges_on_purchase();
            getAddress();
            get_state_id_onselect();
            showFreight();
            EditTbl();
            addCharges();
            keyupFunction();
             //init_select221();
             close_modal_Script();
          }else if(tab == 'indentChangeStatus'){    
            dateFunction();         
              $('#poCheck').change(function(event) {  
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);
                  }         
              if(this.checked) {                
                $('.poSection').show();           
                //$('#po_code').show();
              }else{                
                $('.poSection').hide();       
              }         
            });               
            $('#mrnCheck').change(function(event) {
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                    
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);
                  }
              if(this.checked) {        
                $('.mrnSection').show();
                //$('#mrn_code').show();
              }else{          
                $('.mrnSection').hide();
              }           
            }); 
              

            $('#check_payment_complete').change(function(event) {
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);

                  }
              }); 
              
              
              
              
              
              



            
            $('#paymentCheck').change(function(event) {   
              if(this.checked) {                
                $('.paymentSection').show();  
              }else{              
                $('.paymentSection').hide();              
              }           
            });                       
            $(".flat").click(function(){    
              if($(".po_code").is(":checked")) {  
                $('#po_code').show();       
              }else{                
                $('#po_code').hide();     
              }             
              if($(".mrn_code").is(":checked")) {   
                $('#mrn_code').show();      
              }else{              
                $('#mrn_code').hide();      
              }     
            }); 
            $("#completeCheck").change(function(){
              if($('#completeCheck').is(":checked")) {
                $('#poCheck').attr('checked','checked');
                $('#mrnCheck').attr('checked','checked');
                $('#paymentCheck').attr('checked','checked');
                $('.mrn_code').attr('checked','checked');
                $('.poSection').show();           
                $('#po_code').show();               
                $('.mrnSection').show();
                $('#mrn_code').show();                
                $('.paymentSection').show();  
              }
              /*else{
                $('#poCheck').removeAttr('checked');
                $('.poSection').hide();                 
                $('#mrnCheck').removeAttr('checked');
                $('.mrnSection').hide();                
                $('#paymentCheck').removeAttr('checked');
                $('.paymentSection').hide();                  
              }*/
            });
        
          }else if(tab == 'indentView' || tab == 'OrderView' || tab == 'MrnView' ){
            
            
            $(".slide-toggle").click(function(){
                $(".box1").slideToggle(1000);
                
              });
            dateFunction(); 


              

            
            $('#poCheck').change(function(event) {  
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);
                  }         
              if(this.checked) {                
                $('.poSection').show();           
                //$('#po_code').show();
              }else{                
                $('.poSection').hide();       
              }         
            });               
            $('#mrnCheck').change(function(event) {
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                    
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);
                  }
                  
              if(this.checked) {        
                $('.mrnSection').show();
                //$('#mrn_code').show();
              }else{          
                $('.mrnSection').hide();
              }           
            }); 
              

            $('#check_payment_complete').change(function(event) {
                if(($("#poCheck").prop("checked") == true) &&  ($("#mrnCheck").prop("checked") == true) &&  ($("#check_payment_complete").prop("checked") == true)){
                    $("#completeCheck").removeAttr("disabled");
                    $("#amount").attr("required", true);
                  }else{
                    $("#completeCheck").attr("disabled", true);
                    $('#completeCheck').attr('checked', false);
                  }
                  
              }); 

              $('.mrnwithout_form').click(function(){
                if($(this).prop("checked") == true){
                  $('.inptbtn').fadeOut();
                }
                
              });
              $('.mrninvoice_no').click(function(){
                if($(this).prop("checked") == true){
                  $('.inptbtn').fadeIn();
                }
              });



            
            $('#paymentCheck').change(function(event) {   
              if(this.checked) {                
                $('.paymentSection').show();  
              }else{              
                $('.paymentSection').hide();              
              }           
            });                       
            $(".flat").click(function(){    
              if($(".po_code").is(":checked")) {  
                $('#po_code').show();       
              }else{                
                $('#po_code').hide();     
              }             
              if($(".mrn_code").is(":checked")) {   
                $('#mrn_code').show();      
              }else{              
                $('#mrn_code').hide();      
              }     
            }); 
            $("#completeCheck").change(function(){
              if($('#completeCheck').is(":checked")) {
                $('#poCheck').attr('checked','checked');
                $('#mrnCheck').attr('checked','checked');
                $('#paymentCheck').attr('checked','checked');
                $('.mrn_code').attr('checked','checked');
                $('.poSection').show();           
                $('#po_code').show();               
                $('.mrnSection').show();
                $('#mrn_code').show();                
                $('.paymentSection').show();  
              }
              /*else{
                $('#poCheck').removeAttr('checked');
                $('.poSection').hide();                 
                $('#mrnCheck').removeAttr('checked');
                $('.mrnSection').hide();                
                $('#paymentCheck').removeAttr('checked');
                $('.paymentSection').hide();                  
              }*/
            });
                
            
            
          }else if(tab == 'budgetLimitEditAdd'){
            addPurchaseBudgetLimit();
            
          }
            /*validation*/
          $('form')
          .on('blur', 'input[required], input.optional, select.required', validator.checkField)
          .on('change', 'select.required', validator.checkField)
          .on('keypress', 'input[required][pattern]', validator.keypress);
            $('form').submit(function(e) {
              e.preventDefault();
              var submit = true;
              if (!validator.checkAll($(this))) {
                submit = false;
              }
              if (submit)
                this.submit();
                return false;
            });
             init_select2();
                       init_select221();  
             init_select_forAdd_suplier();
             Print_data_new();
             addMoredocuments();
             //$(".form-control").attr('autocomplete','off');
             close_modal_Script();
              
            
             
             
             
             

             
             
             
             
             
            
                    
        }
      }
    });
});
function close_modal_Script(){
  $('.close_modal2').click(function(){
   setTimeout(function(){ 
     $("body").removeClass("modal-open");
     }, 1000);
  });
}
  /* function Print_data_new(){
  if($('#btnPrint').length){
    document.getElementById("btnPrint").onclick = function () {
       $('.hidde').hide();
    var divToPrint1=document.getElementById("print_divv");
      newWin= window.open("");
       newWin.document.write(divToPrint1.outerHTML);
       newWin.print();
       newWin.close();
      
      location.reload();

    }
  }
         
  } */
  function remove_readonly(){

    $('.testtt').removeAttr('readonly');
    
  }

/*****************************************************************************ADD MORE Documents CONTACTS*********************************************************************/
function addMoredocuments(){
  var maxfields      = 5; //maximum input boxes allowed
  var wrap         = $(".fields_wrap"); //Fields wrapper
  var add_btn      = $(".add_more_docs"); //Add button ID
  var y = 1; //initlal text box count
  $(add_btn).click(function(e){ //on add input button click
    e.preventDefault();
    if(y < maxfields){ //max input box allowed
      y++;
      $(wrap).append('<div class="item form-group"><div class="col-md-9 col-sm-11 col-xs-12" style="padding-left: 0px;"><input type="file" class="form-control col-md-5 col-xs-5" name="docss[]"></div><button class="btn btn-danger rmv_field" type="button"><i class="fa fa-minus"></i></button></div>');
    }
  });
  $(wrap).on("click",".rmv_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); y--;
  });
}
/*****************************************************************************ADD MORE Documents CONTACTS*********************************************************************/
/*****************************************************************************ADD MORE SUPPLIERS CONTACTS*********************************************************************/
function addMoreSupplierContacts(){   
  var max_fields      = 10; //maximum input boxes allowed
  var wrapper         = $(".input_fields_wrap"); //Fields wrapper
  var add_button      = $(".add_field_button"); //Add button ID
  var x = 1; //initlal text box count
  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    if(x < max_fields){ //max input box allowed
      x++; 
    $(wrapper).append('<div class="well form-group scend-tr mobile-view" id="chkIndex_'+x+'"><div class="col-md-3 col-sm-12 col-xs-12 form-group item"><label class="col-md-12 col-xs-12">Name</label><input type="text" name="contact_detail[]"  id="multi_first" placeholder="Name" class="form-control col-md-7 col-xs-12 optional" ></div><div class="col-md-3 col-sm-12 col-xs-12 form-group item"><label class="col-md-12 col-xs-12">Email</label><input type="email" name="email[]"  placeholder="Email" class="optional form-control col-md-7 col-xs-12"></div><div class="col-md-3 col-sm-12 col-xs-12 form-group item"><label class="col-md-12 col-xs-12">Designation</label><input type="text" name="designation[]" placeholder="Designation" class="form-control col-md-7 col-xs-12 optional" ></div><div class="col-md-3 col-sm-12 col-xs-12 form-group item"><label class="col-md-12 col-xs-12">Contact Number</label><input style=" border-right: 1px solid #c1c1c1 !important;" type="text" name="mobile[]" placeholder="Contact number" class="form-control col-md-7 col-xs-12 optional" ></div><button class="btn btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');
      }
    });  
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
    }); 
}

/*************************************************************add more for id_proof for supplier*******************************************************************/
function addMoreSupplierProof(){
  var maxfields      = 5; //maximum input boxes allowed
  var wrap         = $(".fields_wrap"); //Fields wrapper
  var add_btn      = $(".field_button"); //Add button ID
  var y = 1; //initlal text box count
  $(add_btn).click(function(e){ //on add input button click
    e.preventDefault();
    if(y < maxfields){ //max input box allowed
      y++;
      $(wrap).append('<div class="item form-group"><div class="col-md-9 col-sm-12 col-xs-12" style="padding-left: 0px;"><input type="file" class="form-control col-md-5 col-xs-5" name="idproof[]"></div><button class="btn btn-danger rmv_field" type="button"><i class="fa fa-minus"></i></button></div>');
    }
  });
  $(wrap).on("click",".rmv_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); y--;
  });
}

/*************************************************************add more for material in supplier******************************************************************/
function addMoreSupplierMaterial(){
  var maxMatAdd    = 10; //maximum input boxes allowed
  var inputField         = $(".input_Material"); //Fields wrapper
  var add_material      = $(".addMoreMaterial"); //Add button ID
  
  //var y = 1; //initlal text box count
  var y = $('.input_Material .well').length; //initlal text box count
  $(add_material).click(function(e){ //on add input button click
    e.preventDefault();
    //var supplierMaterialAddedCount = $('.input_Material .well').length;
    if(y < maxMatAdd){ //max input box allowed
      y++;
      $(inputField).append('<div class="well scend-tr mobile-view" id="chkIndex_'+y+'"><div class="col-md-8 col-sm-12 col-xs-12 input-group" style="float:left;"><label class="col-md-12 col-sm-12 col-xs-12 ">Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name_id[]" onchange="getTax(event,this)"><option value="">Select Option</option></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"></div><div class="col-md-4 col-sm-12 col-xs-12 form-group"><label class="col-md-12 col-sm-12 col-xs-12">UOM</label><input style="width:100%; border-right: 1px solid #c1c1c1 !important;" type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly><input type="hidden" name="uom[]" class="uom" readonly></div><button class="btn btn-danger remve_field" type="button"><i class="fa fa-minus"></i></button></div>');
      var logged_user = $('#loggedUser').val();             
      var material_type_id = $('#material_type').val();
      //console.log("id",material_type_id);
      select2(material_type_id , logged_user);
      init_select2(); 
      init_select221();
    }     
    
    
  });
  $(inputField).on("click",".remve_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); y--;
  });

}


/****************************************************************************************GET STATE*****************************************************************************/
function getState(evt, t , type = ''){  
  var appendedClass = type != ''?'.'+type+'.state_id':'.state_id';
  var appendedClassCity = type != ''?'.'+type+'.city_id':'.city_id';
  $(appendedClass).empty();
  $(appendedClassCity).empty();
  var option = $(t).find('option:selected');
  console.log('option===>>>',option);   
  //var country_id = type != ''?type:$(option).val();
  var country_id =$(option).val();
  console.log('country_id===>>>',country_id); 
  if(country_id != ''){
    $(appendedClass).attr('data-where','country_id = '+country_id);   
    $(appendedClass).attr('data-id','state');
    $(appendedClass).attr('data-key','state_id');
    $(appendedClass).attr('data-fieldname','state_name'); 
  }
}

/****************************************************************************************GET CITY ******************************************************************************/
function getCity(evt , t, type = ''){
  var appendedClass = type != ''?'.'+type+'.city_id':'.city_id';
  $(appendedClass).empty(); 
  var option = $(t).find('option:selected');
  //var state_id = type != ''?type:$(option).val();
  var state_id = $(option).val();
  if(state_id != ''){ 
    $(appendedClass).attr('data-where','state_id = '+state_id);
    $(appendedClass).attr('data-id','city');
    $(appendedClass).attr('data-key','city_id');
    $(appendedClass).attr('data-fieldname','city_name');  
  } 
}

/***********************   GET MATERIAL NAME   *****************************/
function getMaterialName(evt, t , selProcessType = '' , c_id = '' ){
  //Grandtotal();
  //$(this).parents().closest('input=[text]').find('.materialNameId').empty();
  $('.materialNameId').empty();
  $(".uom").val('');
  $(".amount").val('');
  var logged_user = $('#loggedUser').val();
  console.log("loggeduser",logged_user);
  var option = $(t).find('option:selected');
  var material_type_id = selProcessType != ''?selProcessType:$(option).val();
  if(material_type_id != ''){
    select2(material_type_id , logged_user);
    //var x=$('.process_name_id').closest('select').find(':selected').val(); 
    //console.log(x);
    /*$('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+ logged_user);
    $('.materialNameId').attr('data-id','material');
    $('.materialNameId').attr('data-key','id');
    $('.materialNameId').attr('data-fieldname','material_name');*/

  }
}

function select2(material_type_id , logged_user){
    $('.materialNameId').attr('data-where','material_type_id = '+material_type_id+' AND created_by_cid='+logged_user+' AND status=1');
    $('.materialNameId').attr('data-id','material');
    $('.materialNameId').attr('data-key','id');
    $('.materialNameId').attr('data-fieldname','material_name');

}





/************** purchase indent addmore material ************/
function IndentAddMoreMaterial(){
  var maximum_add     = 10; //maximum input boxes allowed
  var inputfield        = $(".input_holder"); //Fields wrapper
  var add_more  = $(".addMorefileds"); //Add button ID
  //var x = 1; //initlal text box count
  var x = $('.goods_descr_wrapper .well').length; //initlal text box count
  
  
  
    
  $(add_more).click(function(e){ //on add input button click
    e.preventDefault();
    if ( $( ".well" ).length ){
      var lastid = $(".well:last").attr("id");
      console.log('lastid===>>>',lastid);   
      if(lastid != '' && typeof(lastid) != 'undefined'){
        var lastIdVal= lastid.split('_');   
        x = parseInt(lastIdVal[1]);
      }
    }
    
    /*var measurmentArray = '';
    $.each( measurementUnits, function( key, value ) {
      measurmentArray = measurmentArray+'<option value="'+value+'">'+value+'</option>';
    });*/
    if(x < maximum_add){ //max input box allowed
      x++; 
      
      $(inputfield).append('<div class="well scend-tr mobile-view"  id="chkIndex_'+x+'" style="overflow:auto;"><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label >Material Name</label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select><input type="hidden" name="mat_idd_name" id="matrial_Iddd"><input type="hidden" name="matrial_name" id="matrial_name"></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Description</label><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Quantity &nbsp;&nbsp; &nbsp;UOM</label><input type="text" placeholder="Qty." id="quantity" name="quantity[]" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunc(event,this)" onkeypress="return float_validation(event, this.value)" required="required"><input type="text" id="uom" name="uom1[]" class="form-control col-md-7 col-xs-12 uom1" readonly value=""><input type="hidden" name="uom[]" readonly class="uom"></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label class="col-md-2 col-sm-12 col-xs-12">Expected Amount</label><input type="text" id="amount" name="expected_amount[]" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunc(event,this)" placeholder="Exp Amt" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Purpose</label><textarea id="purpose"  name="purpose[]" class="form-control col-md-1" placeholder="purpose"></textarea><br><br></div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><label class="col-md-2 col-sm-12 col-xs-12 ">Sub Total</label><input  style="border-right: 1px solid #c1c1c1 !important;" id="sub_total"  name="sub_total[]" class="form-control col-md-2" placeholder="sub_total" readonly><br><br></div><button class="btn  btn-danger remove_field" type="button"><i class="fa fa-minus"></i></button></div>');
      //select2(1 ,1);
      var logged_user = $('#loggedUser').val();             
      var material_type_id = $('#material_type').val();
      select2(material_type_id , logged_user);
    }
    var mat_id = $('#material_type').val();
    init_select2();
    init_select221();
    remove_calculation_purchase_indent();
    
    
  });  
  $(inputfield).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove(); x--;
      keyupFunc(event,this);
      remove_calculation_purchase_indent();
      
  }); 
}         

function remove_calculation_purchase_indent(){
    var grand_total_val = $('#grandTot').val();
     if(grand_total_val == 0 || grand_total_val == ''){
        $(':input[type="submit"]').prop('disabled', true);
     }else{
       $(':input[type="submit"]').prop('disabled', false);
     }
  }       

/*******************************************************************************curreent date in purchase order******************************************************************/
var date = new Date();
 var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
 var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  $('#current_date').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    startDate: today,
    endDate: end,
    autoclose: true
  });
  
  
  $('#current_date_2').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    startDate: today,
    endDate: end,
    autoclose: true
  });


  /******************************************************************************* Select on record approve dissapprove ********************************************************/

// approve
$(document).on("click",".validatesr",function(){ 
  if(confirm('Are you sure!') == true) {
    var row = $(this).closest('tr');

  var nameAttributeId = $(this).attr('name');
  nameAttributeId = nameAttributeId.split("_");
    var loggedInUserId = $('#loggedInUserId').val();


     var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                 }).get();
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });

            console.log('Approve Values=>>>>>',checkValues);
    $.ajax({
        type: "POST",
        url: site_url+'purchase/approveIndentOrderbyselectrecord/',
        data: {id:checkValues, approve:1, validated_by:loggedInUserId,nameAttributeId:nameAttributeId}, 
        success: function(result) {
          if(result != '') {
            var obj = $.parseJSON(result);
           if(obj.status == 'success') {           
            window.location.href = site_url+'purchase/purchase_indent/';
           } 
          }
       }
    }); 


  }
});

/********************************************************************************approve dissaporve in purchase indent**********************************************************/ 
$(document).on("click",".validate",function(){ 
    var grandTotal = $(this).closest('tr').find(".grandTotal").html();
    var nameAttributeId = $(this).closest('tr').find(".validate").attr('name');
    nameAttributeId = nameAttributeId.split("_");
    
    var materialTypeId = $(this).closest('tr').find(".materialType").attr('data-id');
    //console.log(materialTypeId);
    
    
    $.ajax({
      type: "POST",
      url: site_url + 'purchase/getBudgetByMaterialTypeId',
      data: {id:materialTypeId}, 
      success: function(data){
        
        if(data != '') {      
          var dataObj =JSON.parse(data);
          var budgetValue = dataObj.budget;
          var Total = dataObj.Total;
          if(Total == 'null')
            var Total =0;
          if(parseInt(grandTotal) > parseInt(budgetValue)){
            if(confirm('Your Available Budget is'+budgetValue+ '\n Budget Spent '+Total+ ' \n Are you sure!') == true) {
              $(this).closest('tr').find(".createPO").show();
                var loggedinUser = $('#loggedInUserId').val();
                //console.log("this->>>>",this);
                //var indent_id = row.find("td.indent_id:nth-child(1)").text();
                //var nameAttributeId = $(this).attr('data-idd');
                //alert(nameAttributeId);
                //console.log('nameAttributeId',nameAttributeId);
                
                var indent_id = nameAttributeId[1];
                //var indent_id = nameAttributeId[1];
                  //console.log("indent_id",indent_id);
                  $.ajax({
                     type: "POST",
                     url: site_url+'purchase/approveIndentOrder/',
                     data: { id:indent_id, approve:1, validated_by:loggedinUser }, 
                     success: function(result) {
                       if(result != '') {
                      //var obj = $.parseJSON(result);
                      var obj = JSON.parse(result);
                      //alert(obj.msg);
                         if(obj.status == 'success') {
                          location.reload();
                         } 
                       }
                     }
                  
                 });
            }
          }else if(confirm('Are you sure!') == true) {
              $(this).closest('tr').find(".createPO").show();
                var loggedinUser = $('#loggedInUserId').val();
                //console.log("this->>>>",this);
                //var indent_id = row.find("td.indent_id:nth-child(1)").text();
                //var nameAttributeId = $(this).attr('data-idd');
                //alert(nameAttributeId);
                //console.log('nameAttributeId',nameAttributeId);
                
                var indent_id = nameAttributeId[1];
                //var indent_id = nameAttributeId[1];
                  //console.log("indent_id",indent_id);
                  $.ajax({
                     type: "POST",
                     url: site_url+'purchase/approveIndentOrder/',
                     data: { id:indent_id, approve:1, validated_by:loggedinUser }, 
                     success: function(result) {
                       if(result != '') {
                      //var obj = $.parseJSON(result);
                      var obj = JSON.parse(result);
                      //alert(obj.msg);
                         if(obj.status == 'success') {
                          location.reload();
                           
                         } 
                       }
                     }
                  
                 });
          }
            
        }
      }
    });   
  });
    /*if(confirm('Are you sure!') == true) {
    var row = $(this).closest('tr');
    $(this).closest('tr').find(".createPO").show();
    var loggedinUser = $('#loggedInUserId').val();
    //var indent_id = row.find("td.indent_id:nth-child(1)").text();
    var nameAttributeId = $(this).attr('name');
    console.log('nameAttributeId',nameAttributeId);
    nameAttributeId = nameAttributeId.split("_");
    var indent_id = nameAttributeId[1];
      $.ajax({
         type: "POST",
         url: site_url+'purchase/approveIndentOrder/',
         data: { id:indent_id, approve:1, validated_by:loggedinUser }, 
         success: function(result) {
             if(result != '') {
          //var obj = $.parseJSON(result);
          var obj = JSON.parse(result);
          //alert(obj.msg);
             if(obj.status == 'success') {
                location.reload();
               
               } 
           }
         }
      
     });  
    }*/
 
$(document).on("click", ".disapprove", function () {
  var row = $(this).closest('tr');
  //var indent_id = row.find("td.indent_id:nth-child(1)").text(); 
  var nameAttributeId = $(this).attr('name');
  nameAttributeId = nameAttributeId.split("_");
  var indent_id = nameAttributeId[1];
  var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });
    if ($('.checkbox1:checked')){ 
         $(".disapproveReasonModal #indent_id").val(checkValues);
      }
     if ($(".checkbox1").prop('checked')==false){ 
          console.log('Value=>>>>>>',indent_id);
        $(".disapproveReasonModal #indent_id").val(indent_id);
    }
  var disapprove_reason = row.find("td .disapprove_reason").text();
  //$(".disapproveReasonModal #indent_id").val(indent_id);
  $(".disapproveReasonModal #disapprove_reason").text(disapprove_reason);
    $('.disapproveReasonModal').modal('show');
});


/***********************purchase order add material*********************/
function PurchaseAddMaterial(){
  
    var maximum      = 10; //maximum input boxes allowed
    var wrap_material = $(".input_material"); //Fields wrapper
    var button_add    = $(".addButton"); //Add button ID
    var x = 1; //initlal text box count
    
    $(button_add).click(function(e){//on add input button click
      e.preventDefault(); 
      
      if ( $( ".well" ).length ){
      var lastid = $(".well:last").attr("id");
      console.log('lastid===>>>',lastid);   
      if(lastid != '' && typeof(lastid) != 'undefined'){
        var lastIdVal= lastid.split('_');   
        x = parseInt(lastIdVal[1]);
      }
    }
      
        if(x < maximum){ //max input box allowed
          x++; 
  
    $(wrap_material).append('<div class="well item form-group scend-tr mobile-view" id="chkIndex_'+x+'"><div class="col-md-2 col-sm-6 col-xs-6 form-group"><label>Material Name<span class="required">*</span></label><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2 Add_mat_onthe_spot" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><div class="col-md-2 col-sm-12 col-xs-6 form-group"><label>Description</label><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-6 form-group"><label>Quantity &nbsp;&nbsp; &nbsp;UOM</label><input type="text" id="quantity" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"><input id="uom" type="text" name="uom1[]"  placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly><input type="hidden" name="uom[]" readonly class="uom"></div><div class="col-md-2 col-sm-6 col-xs-6 form-group"><label>Price</label><input type="text" name="price[]"  placeholder="price/per" class="form-control col-md-7 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Sub Total</label><input type="text" name="sub_total[]" id="sub_total" placeholder="sub total" class="form-control col-md-7 col-xs-12" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>GST</label><input type="text" name="gst[]"  placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax"  id="gst_tax"  min="0"  onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>Sub Tax</label><input type="text" name="sub_tax[]"  placeholder="Tax" class="form-control col-md-7 col-xs-12 key-up-event" min="0" readonly></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label >Total</label><input style="border-right: 1px solid #c1c1c1 !important;" type="text" name="total[]"  placeholder="total" class="form-control col-md-7 col-xs-12" readonly id="total" min="0"></div><button class="btn  btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div>');
    var logged_user = $('#loggedUser').val();             
    var material_type_id = $('#material_type').val();
    
    
    select2(material_type_id , logged_user);  
    }
    //var mat_id = $('#material_type').val();
      //getMaterials(mat_id,x);
      //init_select2();
      init_select221();
    });
    
      $(wrap_material).on("click",".remove_btn", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
        keyupFunction(event,this);
    });
}

/**************** Calculation in purchase order *************/
function keyupFunction(evt , t){
  var closestId = $(t).closest(".well").attr("id");
  var qty , price , gst_tax , sub_tax, amt ,grand_total, received_quantity,amt_p_bill,sub_tax_purchase , total_sub_tax_sub_total_purchase;
  qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
  price = parseFloat($("#"+closestId+" input[name='price[]'").val());
  
  amt_p_bill = parseFloat(qty) * parseFloat(price);
  var amt_p_bill_Decimal = amt_p_bill.toFixed(2);
  $("#"+closestId+" input[name='sub_total_amt_purchse_bill[]'").val(amt_p_bill_Decimal);
  if (($("#"+closestId+" input[name='received_quantity[]'").length > 0) && ($("#"+closestId+" input[name='received_quantity[]'").val() != '')){
    received_quantity = parseFloat($("#"+closestId+" input[name='received_quantity[]'").val());
    amt = received_quantity * price;
  }else{
    amt = parseFloat(qty) * parseFloat(price);
  }
  if(isNaN(amt)) amt = 0;
  var amt_Decimal = amt.toFixed(2);
  $("#"+closestId+" input[name='sub_total[]'").val(amt_Decimal);
  gst_tax = $("#"+closestId+" input[name='gst[]'").val();
  sub_tax= gst_tax * amt/100; 
  sub_tax_purchase = gst_tax * amt_p_bill/100;  
  total_sub_tax_sub_total_purchase =  sub_tax_purchase + amt_p_bill;  
  $("#"+closestId+" input[name='amount_with_tax[]'").val(total_sub_tax_sub_total_purchase); 
  var subtotal_amount_add_with_tax = 0
  $("input[name='amount_with_tax[]']").each(function(){
    subtotal_amount_add_with_tax += parseFloat($(this).val());  
  });   
  $('#total_amount_purchase').val(subtotal_amount_add_with_tax);  
  var total_taxxx = 0
  $("input[name='sub_tax[]']").each(function(){
    total_taxxx += parseFloat($(this).val()); 
  });
  $('#total_tax').val(total_taxxx);
  $("#"+closestId+" input[name='sub_tax[]'").val(sub_tax);
  total = parseFloat(sub_tax) + parseFloat(amt);
  $("#"+closestId+" input[name='total[]'").val(total.toFixed(2));
  total = parseFloat($("input[name='grand_total'").val());
  subtotal();
  remove_calculation_MRN();
}
/* script for edit purchase order and purchase indent*/
function remove_mat_during_edit(){
  $(document).on("click",".remove_btn1",function(){
    var closestId = $(this).closest(".well").attr("id");
    $("#"+closestId+" input[name='quantity[]'").val('0');
    $("#"+closestId+" input[name='material_name[]'").val('');
    $(this).closest(".well").css("display", "none");
    keyupFunction(event,this);
  });

}
function remove_mat_during_convert_po(){
  
  $('.check_matt').on('click',function(){
    
    $(this).closest(".well").css("display", "none");
    var closestId = $(this).closest(".well").attr("id");
    var mat_idd = $("#"+closestId+" select[name='material_name[]'").val();
    console.log('mat_idd===>>>',mat_idd);
    console.log('closestId===>>>',closestId);
    $('#'+closestId+' .for_hide_val').val(mat_idd);
    $("#"+closestId+" input[name='total[]'").remove();
    $("#"+closestId+" input[name='gst[]'").remove();
    $("#"+closestId+" input[name='price[]'").remove();
    $("#"+closestId+" input[name='quantity[]'").remove();
    $("#"+closestId+" input[name='description[]'").remove();
    
    //after Getting id 'mat_idd' its remove for conditions
    setTimeout(function(){
     $("#"+closestId+" select[name='material_name[]'").val('');
     subtotal();
    }, 1000);
    keyupFunction(event,this);
    remove_calculation_MRN();
    
    setTimeout(function(){
       var charges_val = $('input[name="other_charges"]').val();
       if(charges_val != ''){
        $('input[name="other_charges"]').val('');
       }  
    }, 1000);
    
  }); 
}
function remove_calculation_MRN(){
  
  var grand_total_val = $('#subttot').val();
     if(grand_total_val == 0 || grand_total_val == ''){
       $(':input[type="submit"]').prop('disabled', true);
     }else{
       $(':input[type="submit"]').prop('disabled', false);
     }
  }       

/* script for edit purchase order and purchase indent*/
function subtotal() {   
  var tot = 0
  $("input[name='total[]']").each(function(){
    tot += parseFloat($(this).val());
    //tot += (isNaN($(this).val())) ? 0 : parseFloat($(this).val());
  });
  
  
  $("#subttot").val(tot)
    var frt = parseFloat($("input[name='freight'").val());
    if(isNaN(frt)) {
      var frt = 0;
    }
    
    var otherCharges = parseFloat($("input[name='other_charges'").val());
    if(isNaN(otherCharges)) {
      var otherCharges = 0;
    }
    
    var finvalue = parseFloat(frt) + parseFloat(tot) + parseFloat(otherCharges);
    if(isNaN(finvalue)) {
    var finvalue = 0;
    }
  $("#subttot").val(finvalue.toFixed(2));
  
  /******************display message for available budget AND spent budget**************/
  var getGrandTotal = $("#subttot").val();
  var getSelectedMaterialType = $('.material_type_id').find('option:selected').val();
  
  $.ajax({
      type: "POST",
      url: site_url + 'purchase/getBudgetByMaterialTypeId',
      data: {id:getSelectedMaterialType}, 
      success: function(data){
        if(data != '') {      
          var dataObj =JSON.parse(data);
          var budgetValue = dataObj.budget;
          var Total = dataObj.Total;
          if(Total == null){
             var Total = 0;
          }
          if(parseInt(getGrandTotal) > parseInt(budgetValue)){
            
            $('.totalBudget').html("Available Budget = " + budgetValue);
            
            $('.budgetSpent').html("Budget Spent = " + Total);
            
            setTimeout(function() { 
              $('.totalBudget').html(''); 
              $('.budgetSpent').html(''); 
              // $('.totalBudget').addClass('display','none'); 
              // $('.budgetSpent').addClass('display','none'); 
              // $('.totalBudget').slideUp('slow').html('').removeAttr('display');
              // $('.budgetSpent').slideUp('slow').html('').removeAttr('display');
              // $('.totalBudget').css('display','block');
              // $('.budgetSpent').css('display','block');
            }, 5000); 
          }
        }
      }
    });   
  /*****************end of budget code**************************************/
  
}
     
/*******************************************************amount total in purchase indent********************************************************/  
  function keyupFunc(evt , t){
    var closestId = $(t).closest(".well").attr("id");
    var qty , amount;
    qty = parseFloat($("#"+closestId+" input[name='quantity[]'").val());
    expected_amnt = parseFloat($("#"+closestId+" input[name='expected_amount[]'").val());
      if(isNaN(expected_amnt)) {
        var expected_amnt = 0;
      }
    total_amnt = parseFloat(qty) * parseFloat(expected_amnt);
    if(isNaN(total_amnt)) total_amnt = 0;
  var valueww = total_amnt.toFixed(2);
    $("#"+closestId+" input[name='sub_total[]'").val(valueww);
    Grandtotal();
    remove_calculation_purchase_indent();
  }
function Grandtotal() {
  var grandtot = 0;
  $("input[name='sub_total[]']").each(function(){
    grandtot += parseFloat($(this).val());
  });
  $("#grandTot").val(grandtot.toFixed(2));
  
  /**************display of budget available and spent in PI**********/
  var getGrandTotal = $("#grandTot").val();
  var getSelectedMaterialType = $('.materialTypeId').find('option:selected').val();
  $.ajax({
      type: "POST",
      url: site_url + 'purchase/getBudgetByMaterialTypeId',                       //get budget value ccrdng to materialType from material Type table
      data: {id:getSelectedMaterialType}, 
      success: function(data){
        if(data != '') {      
          var dataObj =JSON.parse(data);
          var budgetValue = dataObj.budget;
          var Total = dataObj.Total;
          if(Total == null){
             var Total = 0;
          }
          if(parseInt(getGrandTotal) > parseInt(budgetValue)){
            $('.msg1').html("Available Budget = " + budgetValue);
            $('.msg2').html("Budget Spent = " + Total);
            setTimeout(function() { 
            $('.msg1').html('');
            $('.msg2').html('');
              // $('.msg1').slideUp('slow');
              // $('.msg2').slideUp('slow');
              // $('.msg1').css('display','block');
              // $('.msg2').css('display','block');
            }, 5000); 
          }
        }
      }
    }); 
  /******************code end******************************/    
  
}
  
// function getData(){
// var getGrandTotal = $("#grandTot").val();
// console.log("getGrandTotal->>>>>",getGrandTotal);
  // var getSelectedMaterialType = $('.materialTypeId').find('option:selected').val();
  // console.log("getSelectedMaterialType->>>>>",getSelectedMaterialType);
  /*$.ajax({
      type: "POST",
      url: site_url + 'purchase/getBudgetByMaterialTypeId',
      data: {id:getSelectedMaterialType}, 
      success: function(data){
      //console.log('datattttt======>>>>>>>>>>>>>',data); 
        if(data != '') {      
          /*var dataObj =JSON.parse(data);
          console.log("dataobj",dataObj);
        //  parseInt($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
          parseFloat($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
          $("#"+closestId+"").find('.uom').val(dataObj.uom);
          $("#"+closestId+"").find('.amount').val(dataObj.sales_price);
          //parseInt($("#"+closestId+'"')find(".uom").val(dataObj.uom));*/
        /*}
      }
    });   */
//}
  
/*fetching tax value on material select*/
  function getTax(evt, t){
    var option = $(t).find('option:selected');  
    var materialId = option.val();
    var closestId = $(t).closest(".well").attr("id");
    //console.log("closes",closestId);
    $.ajax({
      type: "POST",
      url: site_url + 'purchase/getMaterialDataById',
      data: {id:materialId}, 
      success: function(data){
      //console.log('datattttt======>>>>>>>>>>>>>',data); 
        if(data != '') {      
          var dataObj =JSON.parse(data);
          console.log("dataobj",dataObj);
        //  parseInt($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
          parseFloat($("#"+closestId+" input[name='gst[]'").val(dataObj.tax));
          $("#"+closestId+"").find('.uom1').val(dataObj.uom);

          $("#"+closestId+"").find('.uom').val(dataObj.uomid);

          //$("#"+closestId+"").find('.amount').val(dataObj.sales_price);
          $("#"+closestId+"").find('.amount').val(dataObj.cost_price);
          //parseInt($("#"+closestId+'"')find(".uom").val(dataObj.uom));
        }
      }
    }); 
    var tax = option.attr('data-tax');
    var uom = $(this).find('.option').val();
    var closestId = $(t).closest(".well").attr("id");
    //parseInt($("#"+closestId+" input[name='gst[]'").val(tax));
    parseFloat($("#"+closestId+" input[name='gst[]'").val(tax));
     // parseInt($("#"+closestId+" input[name='gst[]'").val(tax));
     
  }




/*---
$(wrap_material).append('<div class="item form-group"><div class="well" id="chkIndex_'+x+'"><div class="col-md-2 col-sm-6 col-xs-12 form-group"><select  class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select> </div><div class="col-md-2 col-sm-12 col-xs-12 form-group"><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-12 form-group"><input type="number" id="quantity" name="quantity[]"  placeholder="Qty" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0"><input type="text" id="uom" name="uom[]"  placeholder="Uom" class="form-control col-md-7 col-xs-12 uom" readonly></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><input type="number" name="price[]"  placeholder="price/per" class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"  min="0"></div><input type="hidden" name="sub_total[]" id="sub_total" class="form-control col-md-7 col-xs-12"><input type="hidden" value="" name="sub_total_amt_purchse_bill[]"><div class="col-md-1 col-sm-6 col-xs-12 form-group"><input type="number" name="gst[]"  placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax"  id="gst_tax"  onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><input type="number" name="sub_tax[]"  placeholder="Tax" class="form-control col-md-7 col-xs-12 key-up-event" readonly><input type="hidden" value="" name="amount_with_tax[]"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"  min="0"><input type="number" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event"  onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><input type="number" name="total[]"  placeholder="total" class="form-control col-md-7 col-xs-12" min="0" readonly id="total"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Defected:</label><input type="checkbox" class="flat defected"/><input type="hidden" name="defected[]" class="defectedVal" value=""/></div><div class="col-md-2 col-sm-6 col-xs-12 form-group hideDiv defected_reason_div"><textarea name="defected_reason[]" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason"></textarea></div><button class="btn col-md-1 col-sm-12 col-xs-12 form-group btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div></div>');-----*/


/****************** ADD MORE FOR MRN **************/
function AddMoreMaterialMrn(){
  var maximum      = 10; //maximum input boxes allowed
  var wrap_material = $(".input_material"); //Fields wrapper
  var button_add    = $(".addButton"); //Add button ID
  var x = 1; //initlal text box count
  
  $(button_add).click(function(e){ //on add input button click    
    e.preventDefault(); 
    if ( $( ".well" ).length ){
      var lastid = $(".well:last").attr("id");
      console.log('lastid===>>>',lastid);   
      if(lastid != '' && typeof(lastid) != 'undefined'){
        var lastIdVal= lastid.split('_');   
        x = parseInt(lastIdVal[1]);
      }
    }
    
      if(x < maximum){ //max input box allowed
        x++;
        $(wrap_material).append('<div class="well item form-group scend-tr mobile-view" style="border-bottom: 1px solid #c1c1c1 !important;border-right: 1px solid #c1c1c1 !important;"id="chkIndex_'+x+'"><div class="col-md-1 col-sm-12 col-xs-6 form-group"><label>M. Name <span class="required">*</span></label><select class="materialNameId form-control col-md-2 col-xs-12 selectAjaxOption select2" id="mat_name" required="required" name="material_name[]" onchange="getTax(event,this)"><option value="">Select Option</option></select></div><input type="hidden" value="1" name="mrn_or_not"><div class="col-md-1 col-sm-12 col-xs-6 form-group"><label>Description</label><textarea id="description" name="description[]" class="form-control col-md-7 col-xs-12 description"></textarea></div><div class="col-md-2 col-sm-6 col-xs-6 form-group"><label style="float:left; width:100%">Quantity&nbsp;&nbsp;&nbsp; UOM</label><input type="text" id="quantity" name="quantity[]" placeholder="Qty." class="form-control col-md-7 col-xs-12 key-up-event" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"><input type="text" name="uom1[]"  placeholder="Uom" class="form-control col-md-7 col-xs-12 uom1" readonly><input type="hidden" name="uom[]" readonly class="uom"></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>price</label><input type="text" name="price[]" placeholder="pp" class="form-control col-md-12 col-xs-12 key-up-event amount" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><input type="hidden" name="sub_total[]" placeholder="sub total" class="key-up-event"><input type="hidden" value="" name="sub_total_amt_purchse_bill[]"><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>GST</label><input type="text" name="gst[]" placeholder="gst" class="form-control col-md-7 col-xs-12 key-up-event gst_tax" id="gst_tax" onkeyup="keyupFunction(event,this)" onchange="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>Tax</label><input type="text" name="sub_tax[]" placeholder="tax" class="form-control col-md-7 col-xs-12 key-up-event"  min="0" readonly></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label>Rcv d Qty</label><input type="text" name="received_quantity[]" placeholder="Received Quantity" class="form-control col-md-12 col-xs-12 key-up-event" onchange="keyupFunction(event,this)" onkeyup="keyupFunction(event,this)" min="0" onkeypress="return float_validation(event, this.value)"></div><div class="col-md-1 col-sm-6 col-xs-12 form-group"><label>Total</label><input type="text" name="total[]" placeholder="total" class="form-control col-md-12 col-xs-12 key-up-event" min="0" readonly><input type="hidden" value="" name="amount_with_tax[]"></div><div class="col-md-1 col-sm-6 col-xs-6 form-group"><label style="float:left;width:100%">Defected:</label><input style="margin-left: 36px;margin-top: 15px;" type="checkbox" class="flat defected"/><input  type="hidden" name="defected[]" class="defectedVal" value=""/></div><div class="col-md-2 col-sm-6 col-xs-6 form-group defected_reason_div hideDiv"><label >Def Reason</label><textarea style="border-right: 1px solid #c1c1c1 !important;" name="defected_reason[]" class="form-control col-md-7 col-xs-12 defected_reason" placeholder="Defected Reason" ></textarea></div><button class="btn form-group btn-danger remove_btn" type="button"><i class="fa fa-minus"></i></button></div>');
        checkDefectedMaterialsofMrn();
        var logged_user = $('#loggedUser').val();             
        var material_type_id = $('#material_type').val();
        select2(material_type_id , logged_user);  
        }
        //var mat_type_id = $('#item_type').val();
        //getMaterial(mat_type_id,x);
      //  init_select2();
        init_select221();
  });
  
    $(wrap_material).on("click",".remove_btn", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove(); x--;
      keyupFunction(event,this);
  });
}


/*********************************************************************************************star rating**************************************************************/
function starRating(){
$(function() {
  $("div.star-rating > s, div.star-rating-rtl > s").on("click", function(e) { 
  // remove all active classes first, needed if user clicks multiple times
  $(this).closest('div').find('.active').removeClass('active'); 
  //$(e.target).parentsUntil("div").addClass('active'); // all elements up from the clicked one excluding self
  $(e.target).prevAll('s').addClass('active'); // all elements up from the clicked one excluding self 
  $(e.target).addClass('active');  // the element user has clicked on
  console.log('rrrrr=>>>', $(e.target).prevAll('s').length+1);
    //var numStars = $(e.target).parentsUntil("div").length+1;
    var numStars = $(e.target).prevAll('s').length+1;
    $('#hidden_rating').val(numStars);
    
    
  });
});
}
/*****************************************************************************************date function ***********************************************************************/
function dateFunction(){
  /*payment date*/
  //var date = new Date();
  //date.setDate(date.getDate()-0);
  $('.delivery_date').datepicker({ 
    //startDate: date,
    format: 'dd-mm-yyyy',
    autoclose: true
  });
  //var date = new Date();
  //date.setDate(date.getDate()-0);
  $('.bill_datee').datepicker({ 
    //startDate: date,
    format: 'dd-mm-yyyy',
  });
  
  /*fetch curent date in purchase order*/
    var date = new Date();
     var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
     var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
      $('#current_date').datepicker({
      //format: "mm/dd/yyyy",
      format: "yyyy-mm-dd",
      todayHighlight: true,
      startDate: today,
      endDate: end,
      autoclose: true
      });
      $('#current_date').datepicker('setDate', today);
/*fetchsupplier address*/
var SupplierAddress = $('#supplier_name option:selected').attr('data-id');
          $("#address").val(SupplierAddress);   

          /*required date in indent*/
          
  var date = new Date();
    //date.setDate(date.getDate()-1);
    $('#req_date').datepicker({ 
      //startDate: date,
      format: "dd-mm-yyyy",
      autoclose: true
    });
  $('#req_date').on('changeDate', function (e) {
    $('.req_date').closest('.item').removeClass('bad');
  });
  
  var date = new Date();
    //date.setDate(date.getDate()-1);
    $('#req_date1').datepicker({ 
      //startDate: date,
      format: "dd-mm-yyyy",
      autoclose: true
    });
    
  var date1 = new Date();
    //date.setDate(date.getDate()-1);
    $('#req_date12').datepicker({ 
      //startDate: date1,
      format: "dd-mm-yyyy",
      autoclose: true
    }); 
    $('#inv_date').datepicker({ 
      startDate: date1,
      format: "dd-mm-yyyy",
      autoclose: true
    }); 
    
}

/***************************************************************Function to check the validation of a company's GSTIN No. ****************************************************/
  function fnValidateGSTIN(Obj) { 
  $("div.alert").remove();
  $('.gstin').parent('div').siblings().remove( '.alert' );
    if (Obj.value != "") {
      ObjVal = Obj.value;
      
      //var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9]{1}?$/;
      //var gstinPat = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[0-9]{1}Z[0-9A-Z]{1}?$/;
      var gstinPat = /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
      //alert(gstinPat);
      if (ObjVal.search(gstinPat) == -1) {
         console.log("Invalid GSTIN number");
         $('.gstin').closest('.item').addClass('bad');        
        
        $('.gstin').closest('.item').append("<div class='alert'>Invalid GSTIN number</div>");
        $(".signUpBtn").attr( "disabled", "disabled" );
        return false;
      }else{
        $(".signUpBtn").removeAttr("disabled");
        $('.gstin').closest('.item').removeClass('bad');  
        console.log("Correct GSTIN No");
        }
    }
  }
  
  function AllowIFSC(ifscode) {
    $("div.alert").remove();
    if (ifscode.value != "") {
      ifscodeVal = ifscode.value;
      var reg = /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/;
      if (ifscodeVal.match(reg)) {
        $(".signUpBtn").removeAttr("disabled");
        $('.ifsc_code').closest('.item').removeClass('bad');  
        console.log("Correct ifsc code No");
        
                return true;
            }else {
                $('.ifsc_code').closest('.item').addClass('bad');       
        
        
        $('.ifsc_code').closest('.item').append("<div class='alert'>Invalid ifsc code number</div>");
        $(".signUpBtn").attr( "disabled", "disabled" );
         console.log("Invalid ifsc code number");
                return false;
            }

        }
  } 

/**************************************************************************************get address******************************************************************************/
function getAddress(){
  $('.address').select2({
      allowClear: true,
      placeholder: 'Select Address',
      closeOnSelect: true,
      ajax: {
        url: site_url+'/purchase/getAddress',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            q: params.term
          };
        },    
      processResults: function (data) {
        if(data){
          return {
            results: data
          };
          
        }
      },
        cache: true,
       }

  });
  
  
}





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
            //dashboardCountHtml += '<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12"><a href="'+site_url +'purchase/'+value.url+'" data-table="'+value.tableName+'" class="filterUrl" target="_blank"><div class="tile-stats"><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalCount+'</div><h3>'+value.name+'</h3><p>'+value.description+'</p></div></a></div>';
            dashboardCountHtml += '<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="tile-stats filterUrl" data-url="'+site_url +'purchase/'+value.url+'" data-table="'+value.tableName+'"><div class="icon"><i class="'+value.icon+'"></i></div><div class="count">'+value.totalCount+'</div><h3>'+value.name+'</h3><p>'+value.description+'</p></div></div>';
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
    $('#canvasDoughnut_Amount').replaceWith($('<div id="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>'));
    $('#pi_material_type_Amount').replaceWith($('<div id="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>'));
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
    $("#canvasDoughnut_Amount").empty();
    $("#MaterialAmount").empty();
    PoAmountTotalWithMaterial(startDate ,endDate);
    $("#completeMRNMaterialAmount").empty();
    MRNAmountTotalWithMaterial(startDate ,endDate);
    //$(".pi_material_type_Amount").empty();
    //$("#completePiMaterialAmount").empty();
    
    
    
    
    piCompleteStatusAmountTotalWithMaterial(startDate ,endDate);
    
    
    
    /*$("#MaterialAmount").empty();
    PoAmountTotalWithMaterial(startDate ,endDate);*/
    
  });  
 
 $('.dashbrd_filter').on('click',function(){  
    $('#pi_material_type_Amount').replaceWith($('<div id="pi_material_type_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>'));
    var status_value2 = $('.select_value2').val();
    var startDate = '';
    var endDate = '';
    
    piCompleteStatusAmountTotalWithMaterial(startDate,endDate,status_value2);
 
 });
 $('.dashbrd_filter_PO').on('click',function(){
  $('#canvasDoughnut_Amount').replaceWith($('<div id="canvasDoughnut_Amount" height="140" width="140" style="margin: 15px 10px 10px 0"></div>'));
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
          }).on('click', function(i, row){
              var url = site_url+'purchase/purchase_indent';
              var startEndDate = $('.dashboardFilter').val();
              var items = startEndDate.split(' - ');
              var startDate = items[0];
              var endDate = items[1];
              var datakey = $(this).attr('data-key');
              var startParts = startDate.split('-');
              startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
              var endParts = endDate.split('-');
              endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
              var data = {start:startDate,end:endDate , label:row.label, dashboard:'dashboard'};
              $.ajax({
                  type: "POST",
                  url: url,
                  data: data, 
                  success: function(data){
                    var myWindow = window.open(url,'_self');
                    myWindow.document.write(data);
                   }
                });
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
            var nullAmountCount = count(monthApprovetatusGraphData,'"Amount":"0"');
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
          var url = site_url+'purchase/purchase_indent';
          pieChartClick('pieChart_Indent' , url , pieChart);
        
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
          
          var url = site_url+'purchase/purchase_order';
          pieChartClick('pieChart_order' , url , pieChart1);
        }
      }     
    });   
   
  }
}


/********* Doughnut chart for material disaplya from PO and amouunt total ************/
function PoAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
  
  if ($('#canvasDoughnut_Amount').length){
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
          table += '<div class="PIcls filterUrl" data-id="'+value.id+'" data-table="purchase_order" data-key="material_type" data-url="'+site_url+'purchase/purchase_order"><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount+'</div><br>';
          
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
          
          
          
          
          var dataObjectt = [];       
          $.each(result.poCountData, function(name, value) {  
            var dd = {
               label: value.material_type_name,
               value: parseInt(value.count),
               material_type_id: parseInt(value.material_type_id)
            };
            dataObjectt.push(dd);
          }); 
          
          console.log(dataObjectt);
            $("#canvasDoughnut_Amount").css("display","block"); 
            Morris.Donut({
              element: 'canvasDoughnut_Amount',
              data: dataObjectt,
              colors: ["#1ABB9C" , "#E74C3C","#F39C12","#F39C17","#F39C15","#F39C13","#F39C19","#F39C16" ],
              resize: true,
            }).on('click', function(i, row){
                console.log('row====>>>>',row);
                    var url = site_url+'purchase/purchase_order';
                    var startEndDate = $('.dashboardFilter').val();
                    var items = startEndDate.split(' - ');
                    var startDate = items[0];
                    var endDate = items[1];
                    var datakey = $(this).attr('data-key');
                    var startParts = startDate.split('-');
                    startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
                    var endParts = endDate.split('-');
                    endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
                    var data = {start:startDate,end:endDate , material_type_id:row.material_type_id, dashboard:'dashboard'};
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data, 
                        success: function(data){
                          var myWindow = window.open(url,'_self');
                          myWindow.document.write(data);
                         }
                      }); 
                });   
        
        }else{
          $("#canvasDoughnut_Amount").css("display","none");
          $(".emptyPoCountMaterialDiv").css("display","block");
        }
        
        
            /********** Complete incomplete PO pie chart*********/
  
        if ($('#po_complete_incomplete_pie_chart').length ){
           var ctx = document.getElementById("po_complete_incomplete_pie_chart");
          if(result.po_complete == 0 && result.po_incomplete ==0){ // if both converted and non converted pi are zero than show empty message
            $("#po_complete_incomplete_pie_chart").css("display","none");
            $(".emptyPOCompleteIncompleteDiv").css("display","block");
          }else{// if both converted and non converted pi are not zero
              $("#po_complete_incomplete_pie_chart").css("display","block");
              $(".emptyPOCompleteIncompleteDiv").css("display","none");       
              var data = {
              datasets: [{
               data: [result.po_complete , result.po_incomplete ] ,
                backgroundColor: [            
                "#CE5454",
                "#455C73",
                ],
                label: 'My dataset' // for legend
              }],
              labels: [
                "Complete PO",
                "Incomplete PO",
              ]
              };
              var pieChart = new Chart(ctx, {
              data: data,
              type: 'pie',
              otpions: {
                legend: false
              } 
              });
              
            var url = site_url+'purchase/purchase_order';
            pieChartClick('po_complete_incomplete_pie_chart' , url , pieChart);
          }
          
        }
        
        
        
          
      }     
     });    
  }  
}
/********* Doughnut chart for material disaplya from MRN and amouunt total ************/
function MRNAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
  if ($('#mrn_material_type_Amount').length){
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
        console.log('result===>>>>>',result);
        var table = '';
        var amount1 = 0;
        var MRNTotalAmount = 0;
          table += '<h2>Material Name</h2><h2>Amount</h2><br>';
        $.each(result.MRNAmountData, function(name, value) {  
          amount1 = value.totalAmount == null?0:value.totalAmount;
          MRNTotalAmount += parseInt(amount1);
          table += '<div class="PIcls filterUrl" data-id="'+value.id+'" data-table="mrn_details" data-key="material_type" data-url="'+site_url+'purchase/mrn"><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount1+'</div><br>';
          
          
          
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
          $("#mrn_material_type_Amount").css("display","block");
          $(".emptyMrnCompleteCountMaterialDiv").css("display","none"); 
            
            
            
          var dataObjectt = [];       
          $.each(result.MRNCountData, function(name, value) { 
            var dd = {
               label: value.material_type_name,
               value: parseInt(value.count),
               material_type_id: parseInt(value.material_type_id)
            };
            dataObjectt.push(dd);
          }); 
          
          console.log(dataObjectt);
            $("#mrn_material_type_Amount").css("display","block");  
            Morris.Donut({
              element: 'mrn_material_type_Amount',
              data: dataObjectt,
              colors: ["#1ABB9C" , "#E74C3C","#F39C12","#F39C17","#F39C15","#F39C13","#F39C19","#F39C16" ],
              resize: true,
            }).on('click', function(i, row){
                console.log('row====>>>>',row);
                    var url = site_url+'purchase/mrn';
                    var startEndDate = $('.dashboardFilter').val();
                    var items = startEndDate.split(' - ');
                    var startDate = items[0];
                    var endDate = items[1];
                    var datakey = $(this).attr('data-key');
                    var startParts = startDate.split('-');
                    startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
                    var endParts = endDate.split('-');
                    endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
                    var data = {start:startDate,end:endDate , material_type_id:row.material_type_id, dashboard:'dashboard'};
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data, 
                        success: function(data){
                          var myWindow = window.open(url,'_self');
                          myWindow.document.write(data);
                         }
                      }); 
                });             
        }else{
          $("#mrn_material_type_Amount").css("display","none");
          $(".emptyMrnCompleteCountMaterialDiv").css("display","block");
        }
        
        /********** Complete incomplete MRN pie chart*********/
  
        if ($('#mrn_complete_incomplete_pie_chart').length ){
           var ctx = document.getElementById("mrn_complete_incomplete_pie_chart");
          if(result.mrn_complete == 0 && result.mrn_incomplete ==0){ // if both converted and non converted pi are zero than show empty message
            $("#mrn_complete_incomplete_pie_chart").css("display","none");
            $(".emptyMRNCompleteIncompleteDiv").css("display","block");
          }else{// if both converted and non converted pi are not zero
              $("#mrn_complete_incomplete_pie_chart").css("display","block");
              $(".emptyMRNCompleteIncompleteDiv").css("display","none");        
              var data = {
              datasets: [{
               data: [result.mrn_complete , result.mrn_incomplete ] ,
                backgroundColor: [            
                "#CE5454",
                "#455C73",
                ],
                label: 'My dataset' // for legend
              }],
              labels: [
                "Complete GRN",
                "Incomplete GRN",
              ]
              };
              var pieChart = new Chart(ctx, {
              data: data,
              type: 'pie',
              otpions: {
                legend: false
              } 
              });
              
            var url = site_url+'purchase/mrn';
            pieChartClick('mrn_complete_incomplete_pie_chart' , url , pieChart);
          }
          
        }
      }     
     });    
  }  
  
  
  
  
  
}

/********** For adding account according to ledger start here **********/
function Get_Ledger_accodingTo_Parent(){
$(document).ready(function(){
  var login_id = $('#getlogin_ids').val();
  //alert(login_id);
  $.ajax({
       type: "POST",
       url: site_url+'account/Get_Ledgers_according_toParent/',
       data: {login_id:login_id}, 
       success: function(htmlStr) {
        var  obj = JSON.parse(htmlStr);
        var len = obj.length;
        
        for(var i=0; i<len; i++){
          var id = obj[i].id;
          var name = obj[i].name;
          var parent_group_id = obj[i].parent_group_id;
          var sel_data = '<option value="'+id+'" parent_id = "'+ parent_group_id +'">'+name+'</option>';
          $(".opt_Data").append(sel_data); 
        } 
        //alert(len);
      }
    });
  });
  } 
function Get_account_group_or_parent_group_id(){
  $('.cls_add_select2').change(function(){
    var parent_id = $(this).find(':selected').attr('parent_id');
    $('#parent_group_id').val(parent_id);
  }); 
}

 /*********** Function to show the dashboard in main dashboard **********/
$('.graphCheckbox').click(function(e){
  var show = 0;
  if ($(this).is(":checked")) show = 1;
  else show = 0;
  var graph_id = $(this).attr('id');
  var ajaxData = {'graph_id':graph_id , 'show':show};
  $.ajax({
    url: site_url +'purchase/showDashboardOnRequirement/',
    dataType: 'json',
    type: 'POST',
    data: ajaxData,
    success: function(response){
      console.log('response===>>>>',response);
    }
  });
  });
  
  
  /********** Quick add in indent **********/ 
  
  
//Add More Matrial On the spot
function init_select221() {
  
  //$('#material_name').select2({
    
  $('.materialNameId').select2({
  
    allowClear: true,
        placeholder: 'Material Name',
        ajax: {
      url: site_url+'Ajaxrequest/ajaxSelect2search',
      dataType: 'json',
      delay: 250,
      data: function (params) {
      
      return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },      
        processResults: function (data) {
            return {
              results: data
            };
        },
      cache: true,
    },language: {
      noResults: function() {
        
        var searched_value =  $('.select2-search__field').val();
        $('#serchd_val').val(searched_value);
        $('#material_name').val(searched_value);
        var matID = $('.material_type_id').val();                
                $('#material_type_id').val(matID);
        return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_material_cls_name'>Add Material</span>";
        }
      },escapeMarkup: function (markup) {
         return markup;
      }
  });

  
}
$(document).on("click",".add_material_cls_name",function(){
  //alert('therer');
  var searched_text_val = $('#serchd_val').val();
  var searched_text_val1 = $('#material_name').val();
  var materialId = $('#material_type_id').val();
    setTimeout(function(){    
    $('#material_name').val(searched_text_val);
    $('#material_name').val(searched_text_val1);
    $('#material_name_id').val(materialId);
  }, 2000);
  setTimeout(function(){  
      $('#serchd_val').val();
  }, 1000);
});

$(document).on("change",".add_material_cls",function(){
  var mat_type_id = $('#material_type').val();
  $.ajax({
      type: "POST",
      url: site_url+'purchase/Get_matrial_type/',
      data: {mat_id:mat_type_id}, 
        success: function(result) {
           if(result != '') {
            var  objss = JSON.parse(result);
            
              var len = objss.length;
            for(var i=0; i<len; i++){
              var id = objss[i].id;
              var name = objss[i].name;
              var prefix = objss[i].prefix;
              console.log(prefix);
              $('#matrial_Iddd').val(id);
              $('#matrial_name').val(name);
              $('#prefix').val(prefix);
              //var str_prefix = '<input type="hidden" value="'+prefix+'" >';*/
              
            }
           }
        }
    }); 
});
$(document).on("click",".add_material_cls_name",function(){ 
 //To get Matrieal Type Ajax  
 
   $('#myModal_Add_matrial_details').modal('show');
   var btn_html = $(this).html();
   $('#add_matrial_Data_onthe_spot').val(btn_html);
  // alert(btn_html);Add Sale Ledger

 
});         

$(document).on("click",".close_sec_model",function(){
   $('#myModal_Add_matrial_details').modal('hide');
   
});



$(document).on("click","#Add_matrial_details_on_button_click_purchase",function(){
  
  $('#mssg34').empty();
  var material_name  = $('#material_name').val();
  var hsn_code  = $('#hsn_code').val();
  //var uom  = $('#uom').val();
  var uom  = $("select#uom option").filter(":selected").val();
  var specification  = $('#specification').val();
  //var closing_balance  = $('#closing_balance').val();
  var opening_balance  = $('#opening_balance_Sec').val();
  var material_type_id  = $('#material_type_id').val();
  //var material_type_id  = $('#matrial_Iddd').val();
  
  var prefix  = $('#prefix').val();
  var error = 0;
    if(material_name == ''){
        $('#material_name').css('border', '1px solid #b94a48');
        $('#material_name').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#material_name').css('border', '1px solid #dedede');
        $('#material_name').closest(".form-group").find("span").text('');
      }   
    // if(uom == ''){
        // $('#uom_id').css('border', '1px solid #b94a48');
        // $('#uom_id').closest(".form-group").find("span").text('This field is required');
        // var error = 1;
      // }else{
        // $('#uom_id').css('border', '1px solid #dedede');
        // $('#uom_id').closest(".form-group").find("span").text('');
      // }
    // if(hsn_code == ''){
        // $('#hsn_code').css('border', '1px solid #b94a48');
        // $('#hsn_code').closest(".form-group").find("span").text('This field is required');
        // var error = 1;
      // }else{
        // $('#hsn_code').css('border', '1px solid #dedede');
        // $('#hsn_code').closest(".form-group").find("span").text('');
      // }  
      
  /*  if(opening_balance_Sec == ''){
        $('#opening_balance_Sec').css('border', '1px solid #b94a48');
        $('#opening_balance_Sec').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#opening_balance_Sec').css('border', '1px solid #dedede');
        $('#opening_balance_Sec').closest(".form-group").find("span").text('');
      }*/ 
        
    
    if(error == 1) { 
      return false;
    } else {
      
    $.ajax({
         type: "POST",
         url: site_url+'purchase/add_matrial_Details_onthe_spot/',
         data: {material_name:material_name,hsn_code:hsn_code,uom:uom,specification:specification,material_type_id:material_type_id,prefix:prefix,opening_balance:opening_balance},
        success: function(htmlStr) {
          //alert(htmlStr);
             
           if(htmlStr == 'true'){
            
            $('#mssg34').html('<span style="color:green;">Material Added Successfully.</span>');
            $("#insert_Matrial_data_id").trigger('reset');
            setTimeout(function(){
              
              $('#myModal_Add_matrial_details').modal('hide');
              $('#myModal_Add_matrial_details_purchse').modal('hide');
            }, 1000);
            setTimeout(function(){
              $('.nav-md').addClass('modal-open'); 
            }, 1500);           
          }else{
            $('#mssg34').html('<span style="color:red;">Not Added.</span>');
          }
          setTimeout(function(){
          $('#mssg34').html('<span> </span>');
          }, 3000); 
          
          
        }
       });
    }
});

//Add Suplier On The SpotSpot
function init_select_forAdd_suplier() {
    $('.add_more_Supplier').select2({
    //dropdownCssClass: 'custom-dropdown'
    allowClear: true,
       // placeholder: 'Material Name',
        ajax: {
      url: site_url+'Ajaxrequest/ajaxSelect2search',
      dataType: 'json',
      delay: 250,
      data: function (params) {
            return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },      
        processResults: function (data) {
            return {
              results: data
            };
        },
      cache: true,
         },language: {
       noResults: function() {
        
        var searched_value =  $('.select2-search__field').val();
        //console.log('===>' + searched_value);
         $('#preff_supp').val(searched_value);
         $('#suppliername').val(searched_value);
        // var matID = $('.materialTypeId').val();                
                // $('#material_type_id').val(matID);
        return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
        }
      //noResults: function() {
        //return "<span style='float:right;color:Green;font-weight:bold;cursor: pointer;' class='add_more_supliers'>Add </span>";
      //}
      },escapeMarkup: function (markup) {
         return markup;
      }
    });
  
}

$(document).on("click",".add_more_supliers",function(){
  $('#myModal_Add_supplier').modal('show');
  
  var searched_text_val = $('#preff_supp').val();
  var searched_text_val1 = $('#suppliername').val();
  
  // alert(searched_text_val);
  setTimeout(function(){  
      $('#suppliername').val(searched_text_val);
      $('#suppliername').val(searched_text_val1);
  }, 1000);
  
  
});
//To close Add supplier Popup Model
$(document).on("click",".close_sec_model",function(){
   $('#myModal_Add_supplier').modal('hide');
}); 

//Supplier Add Function
$(document).on("click","#add_suplier_btn_id",function(){
  $('#mssg').html('');
  var suppliername  = $('#suppliername').val();
  var supplieraddress  = $('#supplieraddress').val();
  var suppgstin  = $('#suppgstin').val();
  var country  = $('#cntry').val();
  var state  = $('.state_id').val();
  var city_id  = $('.city_id').val();
  var acc_group_id  = $('.acc_group_id').val();
  
  var error = 0;
    if(suppliername == ''){
        $('#suppliername').css('border', '1px solid #b94a48');
        $('#suppliername').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#suppliername').css('border', '1px solid #dedede');
        $('#suppliername').closest(".form-group").find("span").text('');
      }
    if(supplieraddress == ''){
        $('#supplieraddress').css('border', '1px solid #b94a48');
        $('#supplieraddress').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#supplieraddress').css('border', '1px solid #dedede');
        $('#supplieraddress').closest(".form-group").find("span").text('');
      }
    /*if(suppgstin == ''){
        $('#suppgstin').css('border', '1px solid #b94a48');
        $('#suppgstin').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#suppgstin').css('border', '1px solid #dedede');
        $('#suppgstin').closest(".form-group").find("span").text('');
      }*/ 
      
    if(country == null){
        $('#cntry').css('border', '1px solid #b94a48');
        $('#contry').text('This field is required');
        $('#contry').css('color','red');
        var error = 1;
        // alert('if');
      }else{
        $('#cntry').css('border', '1px solid #dedede');
        $('#contry').text('');
        // alert('else');
      }
      if(state == null){
        $('.state').css('border', '1px solid #b94a48');
        $('#state1').text('This field is required');
        $('#state1').css('color','red');
        var error = 1;
        // alert('if');
      }else{
        $('.state').css('border', '1px solid #dedede');
        $('#state1').text('');
        // alert('else');
      }
      if(city_id == null){
        $('.city_id').css('border', '1px solid #b94a48');
        $('#city1').text('This field is required');
        $('#city1').css('color','red');
        var error = 1;
        // alert('if');
      }else{
        $('.city_id').css('border', '1px solid #dedede');
        $('#city1').text('');
        // alert('else');
      }
      if(acc_group_id == null){
        $('.acc_group_id').css('border', '1px solid #b94a48!important');
        $('#acc_grp_id').text('This field is required');
        $('#acc_grp_id').css('color','red');
        var error = 1;
        // alert('if');
      }else{
        $('.acc_group_id').css('border', '1px solid #dedede');
        $('#acc_grp_id').text('');
        // alert('else');
      }
    
    if(error == 1) {  
      return false;
    } else {
    $.ajax({
           type: "POST",
           url: site_url+'purchase/add_suppliers_detials_on_the_spot/',
           data: {name:suppliername,address:supplieraddress,gstin:suppgstin,country:country,state:state,city_id:city_id,acc_group_id:acc_group_id}, 
           success: function(htmlStr) {
            if(htmlStr == 'true'){
            $('#mssg').html('<span style="color:green;">Added Successfully.</span>');
            $("#insert_supplier_data_id").trigger('reset');
              setTimeout(function(){
                $('#myModal_Add_supplier').modal('hide');
              }, 1000);
            setTimeout(function(){
              $('.nav-md').addClass('modal-open'); 
            }, 1500);             
          }else{
            //$('#mssg').html('<span style="color:red;">Not Added.</span>');
            $('#mssg').html('<span style="color:green;">Added Successfully.</span>');
            $("#insert_supplier_data_id").trigger('reset');
              setTimeout(function(){
                $('#myModal_Add_supplier').modal('hide');
              }, 1000);
          setTimeout(function(){
              $('.nav-md').addClass('modal-open'); 
            }, 1500);               
          }
          setTimeout(function(){
          $('#mssg').html('<span> </span>');
          }, 3000);
        }
       });
    }
  
});
//Add Suplier On The SpotSpot
//Print Function
function printData(){
    $('.pagination').hide();
    $('.dataTables_info').hide();
    $('.dataTables_length').hide();
    $('.dataTables_filter').hide();
    $('.hidde').hide();
    $('.btn-group').hide();
   var divToPrint=document.getElementById("print_div_content");
  // newWin= window.open("");
    // newWin.document.write(divToPrint.outerHTML);
    // newWin.print();
    // newWin.close();
    // location.reload(); 
  var newWin=window.open('','Print-Window');
     newWin.document.open();
     newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
     newWin.document.close();
     setTimeout(function(){newWin.close();},10);
     location.reload();
}
$('#bbtn').on('click',function(){
  printData(); 
})

function printData_div(){
    $('.pagination').hide();
    $('.dataTables_info').hide();
    $('.dataTables_length').hide();
    $('.dataTables_filter').hide();
    $('.hidde').hide();
    $('.btn-group').hide();
    var divToPrint=document.getElementById("print_div_content_div");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    location.reload(); 
}


$('#bbtn22').on('click',function(){
  printData_div(); 
})

//Print Function


/* Check if the MRN quantity is ok or not and accordingly show hide reason of not ok */
function checkDefectedMaterialsofMrn(){
  $('.defected').change(function(event) {
    if(this.checked) {  // if material is not ok  
    //alert('there');
      //$(this).find('input[name="received_quantity[]"]').removeAttr('required');​​​​​
      $(this).closest('.well').find("input[name='received_quantity[]']").removeAttr('required');      
      $(this).parent().siblings('div').removeClass("hideDiv"); // Show defected comment box
      $(this).siblings('input[name="defected[]"]').val(1); 
    }else{ // material is ok  
      $(this).parent().next('.defected_reason_div').addClass("hideDiv"); // Remove defected comment box
    }
  });
}


function count(string,char) {
  console.log(string);
  console.log(char);
 var re = new RegExp(char,"gi");
  return string.match(re).length;
}

/*Script for active Class*/
$(document).on("click","#myTab li a",function(){ 
   // window.location=window.location;
  //setTimeout(function(){  
    // var value = $(this).attr("data-select");
      // $('.activeTab_val').val(value);
  //}, 1000);
  
  //$("form[name='tab_form']").submit(); 
});




/*Script for active Class*/

/* For Table Grand Total*/

$(document).ready(function() {
    $('#example').dataTable({
    "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(),data;
        // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
        // computing column Total of the complete result
      var tttl = api
                .column( 7 , { page: 'current'}  )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                },0);
        var total_for_progress = tttl.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        //alert(total_for_progress);
        
        $('.totlamt').html(total_for_progress);
    },
    responsive: true,
    destroy: true
        //searching: false
    });
  
  
  
  
  
  
  
  
      $('#example_tab').dataTable({
      "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(),data;
        // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
        // computing column Total of the complete result
      var tttl = api
                .column( 7 , { page: 'current'}  )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                },0);
        var total_for_progress = tttl.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      
      $('.totlamt_tab').html(total_for_progress);
    },
    responsive: true,
    destroy: true
    });
  
});

/* For Table Grand Total*/


/************** script For charges Open  Modal *********************/
$(document).on("click",".add_charges_tabs",function(){
    var id = $(this).attr('id');
    var tab = $(this).attr('data-id');
    //alert(tab);
    var url = '';
    switch (tab) {  
      case 'add_charges':
        url = 'purchase/editcharges';
        break;  
      // case 'voucher_view':
        // url = 'account/viewVoucher';
        // break;         
    } 
    $.ajax({
      type: "POST",
      url: site_url + url,
      data: {id:id}, 
      success: function(data){        
        if(data != '') {
          $('#charges_add_modal').modal('toggle');
          $('#charges_add_modal .modal-body-content').html(data);   
          init_select2();
          $('form')
              .on('blur', 'input[required], input.optional, select.required', validator.checkField)
              .on('change', 'select.required', validator.checkField)
              .on('keypress', 'input[required][pattern]', validator.keypress);
                $('form').submit(function(e) {
                  e.preventDefault();
                  var submit = true;
                  // evaluate the form using generic validaing
                  if (!validator.checkAll($(this))) {
                    submit = false;
                  }
                  if (submit)
                    this.submit();
                    return false;
                });
        }
      }
    }); 
  });
/************** script For charges Open  Modal *********************/

/************** script For Add Charges During *********************/
function add_more_charges_details(){
  var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_charges_details"); //Fields wrapper
    var add_button      = $(".add_charges_detail_button"); //Add button ID
    var x = 1; //initlal text box count
  
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
      
      $('.ad_rm_readonly').prop('disabled', true);
      var company_login_id = $('#loggedUser').val();      
        if(x < max_fields){ //max input box allowed
            x++;        
        //$(wrapper).append('<div class="col-md-12 input_charges_details charges_form" ><div class="testDh"><div class="col-md-2 item form-group"><select class="itemName form-control selectAjaxOption select2 Add_charges_id"  required="required" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid='+ company_login_id +' AND charges_for = 1" width="100%"><option value="">Select</option></select></div><div class="col-md-1 item form-group"><input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" onkeypress="return float_validation(event, this.value)"><span class="aply_btn"></span><input type="hidden" value="" id="total_tax_slab"></div><div class="col-md-1 item form-group sgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt" name="sgst_amt[]" value="" readonly></div><div class="col-md-1 item form-group cgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" readonly ></div><div class="col-md-1 item form-group igst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]" value="" readonly ></div><div class="col-md-2 item form-group"><input type="text" class="form-control col-md-2 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="" readonly></div><button class="btn btn-danger remove_charges_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
        
        $(wrapper).append('<div class="col-md-12 input_charges_details charges_form" ><div class="testDh"><div class="col-md-2 item form-group"><select class="itemName form-control selectAjaxOption select2 Add_charges_id" name="particular_charges[]" data-id="charges_lead" data-key="id" data-fieldname="particular_charges" data-where="created_by_cid='+ company_login_id +'" width="100%"><option value="">Select</option></select></div><div class="col-md-1 item form-group"><input type="text" class="form-control col-md-1 ad_rm_readonly charges_added" name="charges_added[]" value="" onkeypress="return float_validation(event, this.value)"><span class="aply_btn"></span><input type="hidden" value="" id="total_tax_slab"></div><div class="col-md-1 item form-group sgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly sgst_amt" name="sgst_amt[]" value="" readonly></div><div class="col-md-1 item form-group cgst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly cgst_amt" name="cgst_amt[]" value="" readonly ></div><div class="col-md-1 item form-group igst_amt1"><input type="text" class="form-control col-md-1 ad_rm_readonly igst_amt" name="igst_amt[]" value="" readonly ></div><div class="col-md-2 item form-group"><input type="text" class="form-control col-md-2 amt_with_tax ad_rm_readonly" name="amt_with_tax[]" value="" readonly></div><button class="btn btn-danger remove_charges_field" type="button"><i class="fa fa-minus"></i></button></div></div>');
        
        
        
        init_select2();
        
        get_state_id_onselect();
        add_charges_on_purchase();
        
        var sale_company_state_idd = $('#sale_company_state_id').val();
        var party_billing_state = $('#party_billing_state_id').val();
        
        if(party_billing_state != sale_company_state_idd){   
           $('.cgst_amt1').hide();
           $('.sgst_amt1').hide();
           $('.igst_amt1').show();
         }else{
            $('.cgst_amt1').show();
            $('.sgst_amt1').show();
            $('.igst_amt1').hide();
         }
    }
    });
    
    $(wrapper).on("click",".remove_charges_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    }); 
}


function add_charges_on_purchase(){
  
  $('.Add_charges_id').on('change',function(){
  //alert('11');  
      var charge_ldger_id = $(this).val();
      
      var matrial_select_this_val =  $(this);
      $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val(''); 
    setTimeout(function(){
      $('.ad_rm_readonly').prop('disabled', false);
        $.ajax({
             type: "POST",
             url: site_url+'account/get_charges_details/',
             data: { id:charge_ldger_id}, 
             success: function(result) {
               var obj = jQuery.parseJSON(result);
               if(obj.type_charges == 'minus'){
                    $(matrial_select_this_val).closest('.testDh').find(".aply_btn").html('<input type="button"  class="add_dis" value="Apply Discount">');
                    $(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").hide();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").hide();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").hide();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").hide();
                    
                      var sale_basic_amount = 0;
                      var total_basic_amount = 0;
                          var amount_after_each_calcu = 0;
                      var total_amt = 0;
                      var total_tax_amount = 0;
                      var grand_total_sum = 0;
                      
                      
                      $('.add_dis').on('click', function() {  
                        var get_cahrges_added = $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
                        if(get_cahrges_added == ''){
                          $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid red");  
                          return false;
                        }
                        $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").css("border", "1px solid #ddd");  
                        //$(this).attr('disabled','disabled');
                          $(".SSubtotal").each(function(){
                          total_basic_amount += parseFloat($(this).val());                          
                        }); 
                        
                        
                        $(".SSubtotal").each(function(){
                          sale_basic_amount = parseFloat($(this).val());
                          var discount_amt =  $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
                          amount_after_each_calcu = sale_basic_amount * discount_amt/total_basic_amount;
                          var amount_after_discount = sale_basic_amount - amount_after_each_calcu;
                          $(this).val(amount_after_discount);
                          total_amt += amount_after_discount;
                          
                        }); 
                        $("input[name='subtotal[]']").each(function(){
                          sale_basic_amount = parseFloat($(this).val());
                          var discount_amt =  $(matrial_select_this_val).closest('.testDh').find("input[name='charges_added[]']").val();
                          amount_after_each_calcu = sale_basic_amount * discount_amt/total_basic_amount;
                          var amount_after_discount = sale_basic_amount - amount_after_each_calcu;
                          $(this).val(amount_after_discount);
                          total_amt += amount_after_discount;
                          
                        }); 
                        //For Tax Calculation
                        var added_tax11 = 0;
                        var amount_with_tax_amt = 0;
                        $(".tax").each(function(){
                          added_tax11 = parseFloat($(this).val());
                          var get_basic_amt =  $(this);
                          var basic_amt = $(get_basic_amt).closest('.input_descr_wrap').find(".SSubtotal").val();
                          var tax_amt = added_tax11 * basic_amt/100;
                          $(get_basic_amt).closest('.input_descr_wrap').find('.tax_amount2').val(tax_amt);
                          amount_with_tax =  parseFloat(tax_amt) + parseFloat( basic_amt);
                          amount_with_tax_amt += amount_with_tax;
                          $(get_basic_amt).closest('.input_descr_wrap').find("input[name='amount[]']").val(amount_with_tax);
                          
                        });
                        $("input[name='total_tax2[]']").each(function(){
                          total_tax_amount += parseFloat($(this).val());
                          $('.totaltax_total').val(total_tax_amount);
                        }); 
                        $("input[name='amount[]']").each(function() {
                            grand_total_sum += Number($(this).val());
                          });
                          $(".grand_total").val(grand_total_sum);
                        //For Tax Calculation
                        
                      });
                        
               }
              
               if(obj.type_charges == 'plus'){
              // alert('dsfdfs');
                    $('#total_tax_slab').val(obj.tax_slab);//Add total_tax
                var sale_company_state_idd = $('#sale_company_state_id').val();
                var party_billing_state = $('#party_billing_state_id').val();
                  if(party_billing_state != sale_company_state_idd){
                    var taxslabb = obj.tax_slab;
                    $(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").val(taxslabb);
                    
                    $(matrial_select_this_val).closest('.testDh').find("input[name='igst_amt[]']").show();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
                  }else{
                    $(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
                    $(matrial_select_this_val).closest('.testDh').find(".for_discount_hide").show();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").show();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").show();
                    $(matrial_select_this_val).closest('.testDh').find("input[name='amt_with_tax[]']").show();
                    var taxslabb = obj.tax_slab;
                    var tax_divide_state_diff = taxslabb / 2; 
                    $(matrial_select_this_val).closest('.testDh').find("input[name='sgst_amt[]']").val(tax_divide_state_diff);
                    $(matrial_select_this_val).closest('.testDh').find("input[name='cgst_amt[]']").val(tax_divide_state_diff);
                    }
                  } 
              }
            });
          }, 1000); 
        });
}
/******get State id on select address *****/
function get_state_id_onselect(){

$('.get_state_id').on('change',function(){
  //alert('alerttt');
   var seelected_val_Address = $(this).find(":selected").val();
  $.ajax({
      type: "POST",
      url: site_url+'purchase/get_state_on_dilivery_add/',
      data: {seelected_val_Address:seelected_val_Address}, 
      success: function(data){
        var trimStr = $.trim(data);
        $('#state_id22').val(trimStr);
        $('#party_billing_state_id').val(trimStr);
      }
  }); 
  
});
//Tax calculation on during add Charges//
$('.charges_added').on('keyup', function() {
    var added_amount_val = $(this).val();
    
      var matrial_select_this_val33 =  $(this);
    var totl_tax = $('#total_tax_slab').val();
    //alert(totl_tax);
    
    var total_tax_withAmount = totl_tax * added_amount_val/100;
    //console.log('added_amount_val===>>>',added_amount_val);
    //console.log('totl_tax===>>>',totl_tax);
    //console.log('total_tax_withAmount===>>>',total_tax_withAmount);
  
  setTimeout(function(){
    var addition_add = (+total_tax_withAmount) +  (+added_amount_val);
    //console.log('addition_add===>>>',addition_add);
      $(matrial_select_this_val33).closest('.testDh').find("input[name='amt_with_tax[]']").val(addition_add);
  }, 1000);
});

//Tax calculation on during add Charges//


}






/******get State id on select address *****/

/************** script For Add Charges During *********************/



/********* Doughnut chart for material display from PI complete and amount total ************/
function piCompleteStatusAmountTotalWithMaterial(startDate = '' , endDate = '', status_value2 = ''){
  
  if ($('#pi_material_type_Amount').length){
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
          table += '<div class="PIcls filterUrl" data-id="'+ value.id +'" data-table="purchase_indent" data-key="material_type" data-url="'+site_url+'purchase/purchase_indent"><i class="fa fa-square aero"></i>'+value.material_type_name+'</div><div>'+amount+'</div><br>';
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
        
          $("#pi_material_type_Amount").css("display","block");
          $(".emptyPoCountMaterialDiv").css("display","none");  


          
          
          var dataObjectt = [];       
            $.each(result.piCountData, function(name, value) {  
              var dd = {
                 label: value.material_type_name,
                 value: parseInt(value.count),
                 material_type_id: parseInt(value.material_type_id)
              };
              dataObjectt.push(dd);
            }); 
            
            console.log(dataObjectt);
              $("#pi_material_type_Amount").css("display","block"); 
              Morris.Donut({
                element: 'pi_material_type_Amount',
                data: dataObjectt,
                colors: ["#1ABB9C" , "#E74C3C","#F39C12","#F39C17","#F39C15","#F39C13","#F39C19","#F39C16" ],
                resize: true,
              }).on('click', function(i, row){
                console.log('row====>>>>',row);
                    var url = site_url+'purchase/purchase_indent';
                    var startEndDate = $('.dashboardFilter').val();
                    var items = startEndDate.split(' - ');
                    var startDate = items[0];
                    var endDate = items[1];
                    var datakey = $(this).attr('data-key');
                    var startParts = startDate.split('-');
                    startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
                    var endParts = endDate.split('-');
                    endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
                    var data = {start:startDate,end:endDate , material_type_id:row.material_type_id, dashboard:'dashboard'};
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data, 
                        success: function(data){
                          var myWindow = window.open(url,'_self');
                          myWindow.document.write(data);
                         }
                      }); 
                }); 



          
        }else{
          $("#pi_material_type_Amount").css("display","none");
          $(".emptyPoCountMaterialDiv").css("display","block");
        } 
        
    
        
        
        
              /********** Complete incomplete PI pie chart*********/
  
        if ($('#pi_complete_incomplete_pie_chart').length ){
           var ctx = document.getElementById("pi_complete_incomplete_pie_chart");
          if(result.pi_complete == 0 && result.pi_incomplete ==0){ // if both converted and non converted pi are zero than show empty message
            $("#pi_complete_incomplete_pie_chart").css("display","none");
            $(".emptyPICompleteIncompleteDiv").css("display","block");
          }else{// if both converted and non converted pi are not zero
              $("#pI_complete_incomplete_pie_chart").css("display","block");
              $(".emptyPICompleteIncompleteDiv").css("display","none");       
              var data = {
              datasets: [{
               data: [result.pi_complete , result.pi_incomplete ] ,
                backgroundColor: [            
                "#CE5454",
                "#455C73",
                ],
                label: 'My dataset' // for legend
              }],
              labels: [
                "Complete PI",
                "Incomplete PI",
              ]
              };
              var pieChart = new Chart(ctx, {
              data: data,
              type: 'pie',
              otpions: {
                legend: false
              } 
              });
              
            var url = site_url+'purchase/purchase_indent';
            pieChartClick('pi_complete_incomplete_pie_chart' , url , pieChart);
          }
          
        } 
        
          
      }     
     });    
  } 

}
  /*$(document).on("click",".PIcls",function(){ 
    window.location.replace(site_url+'purchase/purchase_indent/');
     setTimeout(function(){
    //window.open(site_url+'purchase/purchase_indent/', '_blank');
     $(".PIcls").bind("click", (function () {
       var mat_idd = $(this).attr('data-id');
       $(".filterBtn").removeAttr("disabled");
      $(".filterBtn").trigger("click");
      
          
      }));
      
     }, 6000);  
  });*/

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
  
  /* SELECT Material For Purchase ORDER DD*/
  $(".select_mat").select2({
    allowClear: true,
    placeholder: "Select Material",
     ajax: {
      url: site_url+'Ajaxrequest/ajaxSelect2search',
      dataType: 'json',
      delay: 250,
      data: function (params) {
      
      return {
                q: params.term,
                table: $(this).attr("data-id"),
                field: $(this).attr("data-key"),
                fieldname: $(this).attr("data-fieldname"),
                fieldwhere: $(this).attr("data-where")
            };
        },      
        processResults: function (data) {
            return {
              results: data
            };
        },
      cache: true,
    }
 });
 /* SELECT Material For Purchase ORDER DD*/
 
 /* SELECT Material For Purchase Indent ORDER DD*/
    $(".select_supplier").select2({
        allowClear: true,
        placeholder: "Select Supplier",
         ajax: {
          url: site_url+'Ajaxrequest/ajaxSelect2search',
          dataType: 'json',
          delay: 250,
          data: function (params) {
          
          return {
            q: params.term,
            table: $(this).attr("data-id"),
            field: $(this).attr("data-key"),
            fieldname: $(this).attr("data-fieldname"),
            fieldwhere: $(this).attr("data-where")
          };
        },      
        processResults: function (data) {
          return {
            results: data
          };
        },
          cache: true,
      }
    });
 /* SELECT Material For Purchase Indent ORDER DD*/
 
});

/*********************toggle on apporve dissaprove And bar graph *************************/
$('.collapsePieGraph').click(function() {
  $('#indentApprove').slideToggle('fast');
  
});

$('.collapseBarGraph').click(function() {
  $('#monthWiseGraph').slideToggle('fast');
  
});

/*  dashboard filter on click on new page */
 $(document).on("click",".filterUrl",function(){ 
  var tableName = $(this).attr('data-table');
  var url = $(this).attr('data-url');
  var startEndDate = $('.dashboardFilter').val();
  var items = startEndDate.split(' - ');
  var startDate = items[0];
  var endDate = items[1];
  var datakey = $(this).attr('data-key');
  var material_type = $(this).attr('data-id');
    var startParts = startDate.split('-');
  startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
  var endParts = endDate.split('-');
  endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
  //$("#date_range").submit();
  if(material_type !='' ){
    var data = {start:startDate,end:endDate , material_type:material_type};
  }else{
    var data = {start:startDate,end:endDate};
  };
   $.ajax({
        type: "POST",
        url: url,
        data: data, 
        success: function(data){  
        //$("#date_range").submit();
        var myWindow = window.open(url,'_self');        
      //  var row = $(data).find('#tabbingFilters').val(startEndDate);            
        $('#tabbingFilters').datepicker();
        
        myWindow.document.write(data);
        console.log('aaaa==>>>',data); 
        $('#tabbingFilters').datepicker();
        // $(data).find('#tabbingFilters').val(startEndDate);
            
            
            
       }
     });  
}); 

function pieChartClick(id , url , pieChart){
    //document.getElementById("pi_complete_incomplete_pie_chart").onclick = function(evt){   
    document.getElementById(id).onclick = function(evt){   
    var activePoints = pieChart.getElementsAtEvent(evt);
    if(activePoints.length > 0) {
      //get the internal index of slice in pie chart
      var clickedElementindex = activePoints[0]["_index"];
      console.log('clickedElementindex==>>>',clickedElementindex);
      //get specific label by index 
      var label = pieChart.data.labels[clickedElementindex];
      console.log('label==>>>',label);
      //get value by index      
      var value = pieChart.data.datasets[0].data[clickedElementindex];
      console.log('value==>>>',value);
      /* other stuff that requires slice's label and value */
      
      //var url = site_url+'purchase/purchase_indent';
      var startEndDate = $('.dashboardFilter').val();
      var items = startEndDate.split(' - ');
      var startDate = items[0];
      var endDate = items[1];
      var datakey = $(this).attr('data-key');
      var startParts = startDate.split('-');
      startDate = startParts[2] + '-' + startParts[1] + '-' + startParts[0] + ' 00:00:00';
      var endParts = endDate.split('-');
      endDate = endParts[2] + '-' + endParts[1] + '-' + endParts[0] + ' 23:59:59';  
      var data = {start:startDate,end:endDate , label:label, dashboard:'dashboard'};
      $.ajax({
          type: "POST",
          url: url,
          data: data, 
          success: function(data){
            var myWindow = window.open(url,'_self');
            myWindow.document.write(data);
           }
        }); 
     }
  }
}


/* Show modal for share Generated PDF using email */
$(document).on("click",".sharevia_email_cls",function(){
  $('#myModal_share_email').modal('show');
});

$(document).on("click",".close_sec_model",function(){
   $('#myModal_share_email').modal('hide');
});
/* Share Via email Script*/
$(document).on("click","#share_via_Email",function(){ 
    var share_email  = $('#email_name').val();
    var order_id  = $('#order_id').val();
    var email_msg_id  = $('#email_msg_id').val();
    
    var error = 0;
    if(share_email == ''){
        $('#email_name').css('border', '1px solid #b94a48');
        $('#email_name').closest(".form-group").find("span").text('This field is required');
        var error = 1;
      }else{
        $('#email_name').css('border', '1px solid #dedede');
        $('#email_name').closest(".form-group").find("span").text('');
      }
    if(error == 1) { 
      return false;
    } else {  
      $.ajax({
           type: "POST",
           url: site_url+'purchase/share_pdf_using_email/',
           data: {share_email:share_email,order_id:order_id,email_msg_id:email_msg_id}, 
           success: function(htmlStr) {
          if(htmlStr == 'sent'){
            // alert('send Successfully');
            $('#mssg').html('<span style="color:green;">Email Send Successfully.</span>');
            $("#form_share_viaEmail_id").trigger('reset');
            setTimeout(function(){
              $('#myModal_share_email').modal('hide');
            }, 1000);
            setTimeout(function(){
              $('.nav-md').addClass('modal-open'); 
            }, 1500);   
          }else{
            // alert('Not Send Successfully');
            $('#mssg').html('<span style="color:red;">Email Not Send.</span>');
          }
        }
       });
    }
}); 
/* Share Via email Script*/




             
             /************************print in view****************************************/
 function Print_data_new(){
    document.getElementById("btnPrint").onclick = function () {   
      printDiv(document.getElementById("print_divv"));
      var modThis = document.querySelector("#print_divv");      
      function printDiv(div) {      
        // Create and insert new print section
        var elem = document.getElementById('print_divv');
        var domClone = elem.cloneNode(true);
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        $printSection.appendChild(domClone);
        document.body.insertBefore($printSection, document.body.firstChild);
        window.print(); 
        // Clean up print section for future use
        var oldElem = document.getElementById("printSection");
        if (oldElem != null) { oldElem.parentNode.removeChild(oldElem); } 
                    //oldElem.remove() not supported by IE

        return true;
      } 


      }     
  }

/************************Delete on Select****************************************/
  $(document).ready(function() {
                resetcheckbox();
                $('#selecctall').click(function(event) {  //on click
                    if (this.checked){ // check select status
                        $('.checkbox1').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"              
                        });
                    } else {
                        $('.checkbox1').attr("disabled", false).each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                        });
                    }
                });



$("#del_all").on('click', function(e) {

     if(confirm('Are You Sure!') == true){
                    e.preventDefault();
                    //var datamsg = $(this).attr('data-msg'); 
                    var tablename1 = document.getElementById("table");
                    var tablename = document.getElementById("table").value;
                    var datamsg = tablename1.getAttribute('data-msg');
                    var datapath = tablename1.getAttribute('data-path');
                    var checkValues = $('.checkbox1:checked').map(function() {
                        return $(this).val();
                    }).get();
                    console.log(checkValues);                    
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                    });
                    var ai =    $(".checkbox1:checked").map(function () {
                                      return $(this).data('ai')
                                }).get();
                    //  console.log('value if ai====>>>>>',ai);
                    $.ajax({
                        url: site_url+'purchase/deleteall/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsg}
                    }).done(function(data) {
                       window.location.href = site_url+datapath;
                        $('#selecctall').attr('checked', false);
                    });
                    }
                    else
                    {
                $('input:checkbox').each(function() { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                          });
                    }
        });

              function  resetcheckbox(){
                  $('.checkbox1').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
             }
    

 }); 


/*******************************FAVOURITES IN PURCHASE ***************************/
$(".star-1").on('change', function(e) {
          var tablename1 = document.getElementById("favr");
                    var tablename = document.getElementById("favr").value;

                    var datamsg = tablename1.getAttribute('data-msg');

                  //  var favourite = tablename1.getAttribute('favour-sts');;

                    var datapath = tablename1.getAttribute('data-path');

          if ($(this).is(':checked')) {
                      var  favourite = 1;

                      var datamsgq = 'Marked'
                    } else { 
                     var   favourite = 0;

                     var datamsgq = 'Unmarked'
                    } 
                  var datamsgs = datamsg +''+ datamsgq;

                    var checkValues = $(this).val();
                    $.ajax({
                        url: site_url+'purchase/markfavourite/',
                        type: 'post',
                        data: {tablename:tablename, checkValues:checkValues , datamsg:datamsgs , favourite:favourite}
                    }).done(function(data) {
                      //  window.location.href = site_url+datapath;
                        $('.star-1').attr('checked', false);
                    });


  });

  /*******************************FAVOURITES IN PURCHASE ***************************/
  
  $(document).ready(function(){
  $(".filter-1").click(function(){
    $(".nav-md").addClass("intro");
  });
});


  function getDept(evt,t){ 
  $('.department').empty('');
  //alert("fff");
  var logged_user = $('#loggedUser').val();
  
  if(window.location.href == site_url+'production/production_planning' ){
      $(".app_div_planing").html('');
  }else if(window.location.href == site_url+'production/production_data'){
    $(".app_div").html('');
  }
  var selected_unit_name = $(t).find('option:selected').val();
  $('.department').attr('data-where',' created_by_cid='+logged_user+' AND unit_name = "'+selected_unit_name+'"');
  $('.department').attr('data-id','department');
  $('.department').attr('data-key','id');
  $('.department').attr('data-fieldname','name');
}



/**********************multiple machine group in poroduction setting************************/
function addPurchaseBudgetLimit(){
  var maxInput      = 20; //maximum input boxes allowed
  var inputField         = $(".addPurchaseBudgetLimit"); //Fields wrapper
  var addMorePurchaseBudgetLimitBtn       = $(".addMorePurchaseBudgetLimitBtn"); //Add button ID
  var y = 1; //initlal text box count
  $(addMorePurchaseBudgetLimitBtn ).click(function(e){ //on add input button click
    e.preventDefault();
    if(y < maxInput){ //max input box allowed
      y++;
      $(inputField).append('<div><div class="col-md-7 col-sm-6 col-xs-12 "><input type="text"  class="form-control col-md-7 col-xs-12" name="budget_limit[]" required value=""></div><button class="btn btn-danger remove_PurchaseBudgetLimitBtn" type="button"><i class="fa fa-minus"></i></button></div>');
    }
  });
  $(inputField).on("click",".remove_PurchaseBudgetLimitBtn", function(e){ 
    e.preventDefault(); $(this).parent('div').remove(); y--;
  });
}

/**************************************************************************************************************************************************/
    
function get_order(){
 $('#orderby').submit();  
}

$( document ).ready(function() {
var numOfVisibleRows = $('tr:visible').length;
    $('#visible_row').val(numOfVisibleRows);
if($('#visible_row').val()<10)
{
  $('.pagination').hide();
}
});
  $('#search').on('keyup', function() {
    var blank_val = $(this).val();
    if(blank_val == ''){
      var ctroller_name = $(this).attr('data-ctrl');
       window.location.href = site_url+ctroller_name;
      } 
  });
