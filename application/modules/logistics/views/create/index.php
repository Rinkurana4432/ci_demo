<div class="x_content my-table">
<!--searcbar start -->     
<div class="col-md-12 col-xs-12 for-mobile">
   <div class="Filter Filter-btn2">
      <form class="form-search" method="get" action="#">
         <div class="col-md-6">
            <div class="input-group">
               <span class="input-group-addon">
               <i class="ace-icon fa fa-check"></i>
               </span>
               <input type="text" class="form-control search-query" placeholder="Enter Do id, Voucher" name="search" id="search" value="" data-ctrl="logistics/changelisting">
               <span class="input-group-btn">
               <button type="submit" class="btn btn-purple btn-sm">
               <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
               Search
               </button>
               <a href="#"><input type="button" name="submitSearchReset" class="btn btn-outline-secondary" value="Reset"></a>
               </span>
            </div>
         </div>
      </form>
      <form class="form-search" id="orderby" method="get" action="#">
         <input type="hidden" name="order" id="order" value="asc">
      </form>
   </div>
</div>
<!--searcbar End --> 

<!--addbutton start --> 
<div class="row hidde_cls stik">
         <div class="col-md-12 col-xs-12">
            <div class="export_div">
               <div class="btn-group" role="group" aria-label="Basic example">
                  <a type="buttton" href="https://busybanda.com/alfa/logistics/add_saleorder" class="btn btn-info add_purchase_tabs addBtn" id="sup_add" data-toggle="modal" data-id="editSupplier"><i class="fa fa-plus-circle valignmiddle btnTitle-icon"></i>Add DO</a> 
               </div>
           </div>
        </div>
</div>
<!--addbutton start --> 
	 
<!--Tabletab-start--> 
<div role="tabpanel" data-example-id="togglable-tabs">
<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
   <li role="presentation" class="active"><a href="#in_progress_tab" data-select="progress" id="complete_tab" role="tab" data-toggle="tab" aria-expanded="true" onclick="piinprocess_form1()">In Process</a></li>
   <li role="presentation" class="complte "><a href="#Complete_content_tab" role="tab" data-select="complete" id="auto_entery_tab" data-toggle="tab" aria-expanded="false" onclick="picomplete_form1()">Complete</a></li>
</ul>
<div id="myTabContent" class="tab-content">
   <div role="tabpanel" class="tab-pane fade active in" id="in_progress_tab" aria-labelledby="complete_tab">
      <div id="#">
         <table id="" class="table table-striped table-bordered user_index table-responsive" data-id="user" style="width:100%" border="1" cellpadding="3">
            <thead>
               <tr>
                  <th scope="col">Sl.No<span><a href="#" class="up"></a>
                     <a href="#" class="down"></a></span>
                  </th>
                  <th scope="col">Dispatch Order Id<span><a href="#" class="up"></a>
                     <a href="#" class="down"></a></span>
                  </th>
                 <th scope="col">Quantity</th>
                  <th scope="col">Weight<span><a href="#" class="up"></a>
                     <a href="#" class="down"></a></span>
                  </th>
				  <th scope="col">CBF</th>
                  <th scope="col">Status</th>                 
                  <th scope="col">Created Date</th>                 
                  <th scope="col" class="hidde">Action</th>
               </tr>
            </thead>
			<tbody>
                <tr>
				<td>89</td>
				<td>Nots_387563_71</td>
				<td>SOR_387563_71</td>
				<td>chair fabric</td>
				<td>Test</td>
				<td><a href="#" data-id="material_status" class="add_logistics_tabs btn btn-xs btn-Expected">Completed</a></td>
				<td>1/1/2022</td>
				<td class="action">
				  <i class="fa fa-cog" aria-hidden="true"></i>
				  <div class="on-hover-action">
				   <a href="https://busybanda.com/alfa/logistics/add_saleorder" class="btn btn-edit btn-xs add_purchase_tabs" d>Edit</a>
				   <a href="https://busybanda.com/alfa/logistics/saleorder_view" class="btn btn-edit btn-xs add_purchase_tabs" data-toggle="modal" data-id="editSupplier" id="2142">View</a>              
                  <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">Create Label</a>	
				 <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">View Label</a>					  
				  </div>
				</td>
				</tr>
				 <tr>
				<td>90</td>
				<td>Nots_387563_71</td>
				<td>SOR_387563_71</td>
				<td>chair fabric</td>
				<td>Test</td>
				<td><a href="#" data-id="material_status" class="add_logistics_tabs btn btn-xs btn-Expected">Completed</a></td>
				<td>1/1/2022</td>
				<td class="action">
				  <i class="fa fa-cog" aria-hidden="true"></i>
				  <div class="on-hover-action">
				   <a href="https://busybanda.com/alfa/logistics/add_saleorder" class="btn btn-edit btn-xs add_purchase_tabs" d>Edit</a>
				   <a href="https://busybanda.com/alfa/logistics/saleorder_view" class="btn btn-edit btn-xs add_purchase_tabs" data-toggle="modal" data-id="editSupplier" id="2142">View</a>              
                  <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">Create Label</a>	
				 <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">View Label</a>					  
				  </div>
				</td>
				</tr>
				 <tr>
				<td>91</td>
				<td>Nots_387563_71</td>
				<td>SOR_387563_71</td>
				<td>chair fabric</td>
				<td>Test</td>
				<td><a href="#" data-id="material_status" class="add_logistics_tabs btn btn-xs btn-Expected">Completed</a></td>
				<td>1/1/2022</td>
				<td class="action">
				  <i class="fa fa-cog" aria-hidden="true"></i>
				  <div class="on-hover-action">
				   <a href="https://busybanda.com/alfa/logistics/add_saleorder" class="btn btn-edit btn-xs add_purchase_tabs" d>Edit</a>
				   <a href="https://busybanda.com/alfa/logistics/saleorder_view" class="btn btn-edit btn-xs add_purchase_tabs" data-toggle="modal" data-id="editSupplier" id="2142">View</a>              
                  <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">Create Label</a>	
				 <a href="https://busybanda.com/alfa/logistics/Create_Label" class="btn btn-view btn-xs add_purchase_tabs" ata-toggle="modal" data-id="SupplierView" id="2142">View Label</a>					  
				  </div>
				</td>
				</tr>
				<tbody>
         </table>
      </div>
   </div>	
<ul class="pagination"><li class="active"><a href="">1</a></li><li class="page"><a href="#" data-ci-pagination-page="2">2</a></li><li class="page"><a href="#" data-ci-pagination-page="3">3</a></li><li class="next page"><a href="#" data-ci-pagination-page="2" rel="next">Next →</a></li><li class="next page"><a href="#" data-ci-pagination-page="9">Last »</a></li></ul> 
</div>
<!--Tabletab-End --> 
</div>