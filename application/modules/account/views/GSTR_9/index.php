<style>
   table{width:100%;}
   th table th {
   padding: 4px;
   text-align: center;
   border: 1px solid #fff!important;
   }
   td table td {
   padding: 6px;
   }
   div#PYtrans td table td,#TaxPaid td table td,
   #OtherITC td table td,#ITCRev td table td{
   border-right: 1px solid #ddd;
   }
   #OtherITC td table td{text-align:right;}
   #ReadMe td { border: 1px solid #ddd !important;
   white-space: unset;
   }
   #ReadMe p {
   margin-bottom: 3px !important;
   }
   .headings{padding: 7px;background-color: #002060 !important;color: #ffff;margin: 0px;}
   .col-md-12.boxs {
   background-color: #D9D9D9;
   color: #000;
   padding: 10px 10px;
   margin-bottom: 10px;
   }
   .boxs ul {
   list-style: none;
   padding-left: 14px;
   }
</style>
<div class="x_content">
   <div id="print_div_content">
      <div class="container">
         <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li class="active"><a data-toggle="tab" href="#ReadMe">Read Me</a></li>
            <!--<li><a data-toggle="tab" href="#Home">Home</a></li>-->
            <li><a data-toggle="tab" href="#Outward">Outward</a></li>
            <li><a data-toggle="tab" href="#Outward2">Outward2</a></li>
            <li><a data-toggle="tab" href="#ITCavailed">ITC availed</a></li>
            <li><a data-toggle="tab" href="#ITCRev">ITC Rev</a></li>
            <li><a data-toggle="tab" href="#OtherITC">Other ITC</a></li>
            <li><a data-toggle="tab" href="#TaxPaid">Tax Paid</a></li>
            <li><a data-toggle="tab" href="#PYtrans">PY trans in current FY</a></li>
            <li><a data-toggle="tab" href="#Differentialtax">Differential tax</a></li>
            <li><a data-toggle="tab" href="#demand_refund">Demand & Refund</a></li>
            <li><a data-toggle="tab" href="#Comp_Ds">Comp Ds & Goods Sent on Appr</a></li>
            <li><a data-toggle="tab" href="#Hsn_Ountward">Hsn Ountward</a></li>
            <li><a data-toggle="tab" href="#Hasn_Inward">Hasn Inward</a></li>
         </ul>
         <div class="tab-content">
            <div id="ReadMe" class="tab-pane fade in active">
               <div class="col-md-12">
                  <h5 class="headings">Introduction to Excel based GSTR-9 offline tool</h5>
                  <div class="col-md-12 boxs">
                     <p>1. The Excel based GSTR-9 Offline Tool is designed to help taxpayer to prepare his GSTR-9 return offline</p>
                     <p>2. Details for following Tables of GSTR-9 return can be added by taxpayer using the offline Tool. It is not Mandatory to fill data in all worksheets. The worksheet for which no details then need to be declared, it can be left blank.<br> 
                     <ul>
                        <li>4. Outward</li>
                        <li>5. Outward</li>
                        <li>6. ITC Availed</li>
                        <li>7. ITC Rev</li>
                        <li>8. Other ITC</li>
                        <li>9. Tax Paid</li>
                        <li>10. PY trans in current FY</li>
                        <li>14. Differential Tax</li>
                        <li>15. Demand & Refunds</li>
                        <li>16. Comp DS & Goods sent on appr</li>
                        <li>17.  HSN Outward</li>
                        <li>18. HSN Inward"</li>
                     </ul>
                     </p>							
                  </div>
                  <div class="col-md-12 boxs">
                     <p>"3. The Offline tool has following features in 'Home' sheet to help taxpayer in Return Preparation 
                     <ul>
                        <li>a. Open Downloaded GSTR9 JSON File: To import records from downloaded JSON file. The details would be populated to respective table wise              worksheets.Upon successful import of file the details would be 
                           populated to respective table wise worksheets.
                        </li>
                        <li>b. Generate JSON File to Upload : To generate JSON file for upload of GSTR-9 return details prepared offline on GST portal</li>
                        <li>c. Open downloaded error JSON file : To open file downloaded from GST portal from the ‘Processed with error’ link. The downloaded zipped folder consists of two JSON files. Unzip the file and use this button to
                           open both the JSON files together in a single click by selecting both the files. Upon successful import of both the files both the details processed with errors and successfully would be populated to 
                           respective table wise worksheets. Please refer ‘Handling Error’ section for details 
                        </li>
                        <li>d.Validate Sheet: To Validate the data entered in respective worksheet of this offline Tool. Successful validation is notified to Taxpayer via pop-up while on failure of validation the cells that fail 
                           validation would be marked in Red.
                        </li>
                     </ul>
                     <br> 
                     </p>							
                  </div>
                  <div class="col-md-12 boxs">
                     <p>4. The high level process flow for GSTR-9 return preparation is as follows  
                     <ul>
                        <li>a. Validate the details filled in various  tables using 'validate' button at the top of every sheet.</li>
                        <li>b. Generate JSON using 'Generate JSON File to Upload' option</li>
                        <li>c. Upload the generated JSON on GST Portal. Preview the details uploaded and File return on the GST portal</li>
                        <li> d. Open saved version (Yes/No):- If you select 'No' option then previously saved data not visible and if you select 'Yes' then saved data will be available in the respective worksheets</li>
                     </ul>
                     <br> 
                     </p>							
                  </div>
               </div>
               <div class="col-md-12">
                  <h5 class="headings">Preparing GSTR-9 return Using Offline Tool </h5>
                  <div class="col-md-12 boxs">
                     <p>"1. Please ensure you download the latest version of  GSTR-9 Offline Tool from the GST portal. https://www.gst.gov.in/download/returns</p>
                     <p>2. Launch the GSTR-9 Excel based Offline Tool a pop up (Open saved version - Yes/No) would appear and navigate to worksheet named 'Home'
                        <br>a. On click of 'Yes' any previously saved data in the offline tool will be available.<br>    
                        b. On click of 'No' any data previously saved data in the offline tool will be lost and you can't recover the data.
                     </p>
                     <p>3. Enter your GSTIN in home sheet. Entered GSTIN would be validated only for correct structure.</p>
                     <p>4. Select the applicable Financial Year from the drop-down. It is a mandatory field.</p>
                     <p>5. Download GSTR-9 JSON file from GST portal after logging in to the portal from 'Prepare Offline' section of GSTR-9 tile.</p>
                     <p>6. Open downloaded  GSTR-9 JSON file in to the Offline tool. JSON file can't be generated from Offline tool until GSTR-9 JSON file downloaded from the portal has been opened in the Offline tool.</p>
                     <p>7. Auto drafted details shall be populated in respective work sheets.</p>
                     <p>8. Enter additional details/edit auto drafted details as applicable in various worksheets. It is not Mandatory to fill data in all worksheets. The worksheet for which no details need to be declared can be left blank.</p>
                     <p>9. Click Validate Sheet to check the status of validation. In case of validation failure; please check for cells that have failed validation and correct errors as per help text.</p>
                     <p>10.Click on 'Generate JSON File to Upload ' to generate JSON file for upload of GSTR-9 return details prepared offline on GST portal.   "							
                     </p>
                  </div>
               </div>
               <div class="col-md-12">
                  <h5 class="headings">Steps for uploading prepared GSTR-9 JSON file on GST portal</h5>
                  <div class="col-md-12 boxs">
                     <p>"1. Login to GST Portal and select 'Returns Dashboard'.</p>
                     <p>2. Select applicable Financial Year and click on ""Prepare Offline"" option in ""Annual Return"" tile/Box.</p>
                     <p>3. Upload the JSON prepared using offline Tool using upload option in the return dashboard.</p>
                     <p>4. The uploaded JSON file would be validated and processed.</p>
                     <p>5. In case of validation failure upon processing ; errors if any would be shown on portal.</p>
                     <p>6. Post successful upload of data on GST portal ; Taxpayer to Preview the form and file GSTR-9.</p>
                     <p>Notes :
                        You may download the records successfully processed on GST portal anytime by navigating to 'Services > Returns > Annual Return >  Financial Year > Search > Prepare Offline > Download'. On click of download a JSON file would be available for download in about 20 Mins. The downloaded JSON file may be opened in Offline Tool using ‘Open Downloaded GSTR-9 JSON File' to view/ edit/update details. Post update of details create JSON to upload on GST portal."
                     </p>
                  </div>
               </div>
               <div class="col-md-12">
                  <h5 class="headings"> Error File Handling</h5>
                  <div class="col-md-12 boxs">
                     <p>"1. In case of validation failure of one or more details upon processing of uploaded JSON file; the upload status would be updated as 'Processed with Error'.</p>
                     <p>2. A link would be available to download a Zipped Error file beside the ‘Processed with Error’ status.</p>
                     <p>3. Download the Zipped Error File and save on your system.</p>
                     <p>4. Now click on the button ""Open Downloaded Error JSON files"" to open a file dialog box.</p>
                     <p>5. Select both the files from the unzipped folder and click on ""Open"".</p>
                     <p>6. A message saying ""Error Files successfully Opened"" upon successful opening of files in Offline tool. A pop-up message with work sheets name with error would be shown.</p>
                     <p>7. Please navigate to each worksheets and ensure all records from both the files have been successfully opened in Tool.</p>
                     <p>8. Correct errors in records with error text in column ‘GST Portal Validation Errors’ in each worksheet.</p>
                     <p>9. Validate the sheets again post making corrections.</p>
                     <p>10. Click on 'Generate summary' to update the summary post details have been successfully validated for each worksheet.</p>
                     <p>11. Click on 'Generate JSON File to upload' to generate JSON file for upload of GSTR-9 return details prepared offline on GST portal.</p>
                     <p>12. Follow steps mentioned in GSTR-9 JSON upload on GST Portal section to file GSTR-9."							
                     </p>
                  </div>
               </div>
               <div class="col-md-12">
                  <h5 class="headings"> For Issues with Persistent Comments In Cells</h5>
                  <div class="col-md-12 boxs">
                     <p>"1. If the comments in cells are persistent then the following steps are to be followed:</p>
                     <p>a. Go to File -> Options</p>
                     <p>b. Select Advanced from the options pane in the left.</p>
                     <p>c. Here go to ""Display"" tab.</p>
                     <p>d. In the options for ""For cells with comments, show"", select ""Indicators only, and comments on hover""."</p>
                  </div>
               </div>
               <table  class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="4" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4" style="background-color: #002060 !important;color: #ffff;">GSTR 9 Data Entry Instruction</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%; background-color: #002060 !important;color: #ffff;" >Worksheet Name</th>
                                    <th style="width: 20%; background-color: #002060 !important;color: #ffff;">GSTR-9 Table Reference</th>
                                    <th style="width: 20%; background-color: #002060 !important;color: #ffff;">Field Name</th>
                                    <th style="width: 20%; background-color: #002060 !important;color: #ffff;">Help Instruction</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td colspan="4" style="text-align:center;">PT. II Details of Outward and inward supplies made during the financial year</td>
                     </tr>
                     <!---4. Outward-end -->
                     <tr>
                        <td rowspan="13">4. Outward</td>
                        <td colspan="3">Taxpayer has to import the JSON file in to offline tool to check the auto filled details in Table no. 4(A) to 4(G) and Table no. 4(I) to 4(L) of GSTR 9 based on the supplies reported during the relevant financial year in GSTR-1. However, the auto filled details can be edited. If you have edited/modified any auto filled value, then that value shall be considered as final after successful uploading of JSON file on to portal</td>
                     </tr>
                     <tr>
                        <td rowspan="12">4.Details of advances, inward and outward supplies made during the financial year on which tax is payable</td>
                        <td>4A. Supplies made to un-registered persons (B2C)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of supplies made to unregistered persons (B2C supplies) on which tax has been paid shall be declared here. These will include details of supplies made to unregistered persons/consumers through E-Commerce operators, if any.</p>
                              <p>2. Details are to be declared as net of credit notes or debit notes issued during the Financial Year.</p>
                              <p>3. Table 5, Table 7 along with respective amendments in Table 9 and Table 10 of FORM GSTR-1 may be used for filling up these details. This table shall be auto filled based on the outward supplies reported in GSTR-1."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4B. Supplies made to registered persons (B2B)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of supplies made to registered persons on which tax has been paid shall be declared.</p>
                              <p>2. These will include supplies made through E-Commerce operators but shall not include supplies on which tax is to be paid by the recipient on reverse charge basis.</p>
                              <p>3. Details of debit and credit notes are to be mentioned separately. Table 4A of FORM GSTR-1 may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4C. Zero rated supply (Export) on payment of tax (except supplies to SEZs)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of exports (except supplies made to SEZs) on which tax has been paid shall be declared here. Table 6A of FORM GSTR-1 may be used for filling up these details.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4D. Supply made to SEZs on payment of tax</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of supplies made to SEZs on which tax has been paid shall be declared here. Table 6B of GSTR-1 may be used for filling up these details.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4E. Deemed Exports</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of supplies which are in the nature of deemed exports on which tax has been paid shall be declared here. Table 6C of FORM GSTR-1 may be used for filling up these details.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4F. Advances on which tax has been paid but invoice has not been issued (not covered under (A) to (E) above)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Details of all unadjusted advances i.e. advance has been received and tax has been paid but invoice has not been issued in the current year shall be declared here. Table 11A of FORM GSTR-1 may be used for filling up these details."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4G. Inward supplies on which tax is to be paid on reverse charge basis</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of all inward supplies (including advances and net of credit and debit notes) on which tax is to be paid by the recipient (i.e.by the person filing the annual return) on reverse charge basis. </p>
                              <p>2. This shall include supplies received from registered persons and unregistered persons on which tax is levied on reverse charge basis. This shall also include aggregate value of all import of services. Table 3.1(d) of FORM GSTR-3B may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4H. Sub-total (A to G above)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4I. Credit Notes issued in respect of transactions specified in (B) to (E) above (-)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of credit notes issued in respect of B to B supplies (4B), exports (4C), supplies to SEZs (4D) and deemed exports (4E) shall be declared here. Table 9B of FORM GSTR-1 may be used for filling up these details. Taxpayer can report the values in table 4B to 4E as net of credit notes in case of any difficulty in reporting the same separately.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>4J. Debit Notes issued in respect of transactions specified in (B) to (E) above (+)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of debit notes issued in respect of B to B supplies (4B), exports (4C), supplies to SEZs (4D) and deemed exports (4E) shall be declared here. Table 9B of FORM GSTR-1 may be used for filling up these details. Taxpayer can report the values in table 4B to 4E as net of debit notes in case of any difficulty in reporting the same separately.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"4K.  Supplies / tax declared through Amendments (+).
                           4L. Supplies / tax reduced through Amendments (-)"
                        </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Details of amendments made to B to B supplies (4B), exports (4C), supplies to SEZs (4D) and deemed exports (4E), credit notes (4I), debit notes (4J) and refund vouchers shall be declared here. Table 9A and Table 9C of FORM GSTR-1 may be used for filling up these details. Taxpayer can report the values in table 4B to 4E as net of amendments in case of any difficulty in reporting the same separately.		</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"4M. Sub-total (I to L above)4N. Supplies and advances on which tax is to be paid (H + M) above"</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated</p>
                           </div>
                        </td>
                     </tr>
                     <!---4. Outward-end -->
                     <!---5. Outward-end -->
                     <tr>
                        <td rowspan="10">5. Outward</td>
                        <td colspan="3">Taxpayer has to import the JSON file in to offline tool to check the auto filled details in table no 5 of GSTR-9 based on the supplies reported GSTR-1s of  relevant financial year. However, you may edit the auto filled details. If you have edited/modified any auto filled value, then that value shall be considered as final after successful uploading of JSON file on to portal</td>
                     </tr>
                     <tr>
                        <td rowspan="9">5. Details of Outward supplies made during the financial year on which tax is not payable</td>
                        <td>5A. Zero rated supply (Export) without payment of tax</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of exports (except supplies to SEZs) on which tax has not been paid shall be declared here. </p>
                              <p>2. Table 6A of FORM GSTR-1 may be used for filling up these details."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5B. Supply to SEZs without payment of tax</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of supplies made to registered persons on which tax has been paid shall be declared.</p>
                              <p>"1. Aggregate value of supplies to SEZs on which tax has not been paid shall be declared here. 
                              <p>2. Table 6B of GSTR-1 may be used for filling up these details."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5C. Supplies on which tax is to be paid by the recipient on reverse charge basis</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of supplies made to registered persons on which tax is payable by the recipient on reverse charge basis. Details of debit and credit notes are to be mentioned separately.</p>
                              <p>2. Table 4B of FORM GSTR-1 may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5D, 5E & 5F. Exempted, Nil Rated and Non -GST Supplies (including ‘no supply’)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of Exempted, Nil Rated and Non-GST supplies shall be declared here.</p>
                              <p>2. Table 8 of FORM GSTR-1 may be used for filling up these details. The value of “no supply” shall also be declared here."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5G. Sub-total (A to F above)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5H. Credit Notes issued in respect of transactions specified  in A to F above (-)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of credit notes issued in respect of supplies declared in 5A, 5B, 5C, 5D, 5E and 5F shall be declared here.</p>
                              <p>2. Table 9B of FORM GSTR-1 may be used for filling up these details.</p>
                              <p>3. Taxpayer can report the values in table 5A to 5F as net of credit notes in case of any difficulty in reporting the same separately."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>5I. Debit Notes issued in respect of transactions specified  in A to F above (+)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of debit notes issued in respect of supplies declared in 5A, 5B, 5C, 5D, 5E and 5F shall be declared here.</p>
                              <p>2. Table 9B of FORM GSTR-1 may be used for filling up these details.</p>
                              <p>3. Taxpayer can report the values in table 5A to 5F as net of debit notes in case of any difficulty in reporting the same separately."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"5J.  Supplies declared through Amendments (+)5K. Supplies reduced through Amendments (-)"</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Details of amendments made to exports (except supplies to SEZs) and supplies to SEZs on which tax has not been paid shall be declared here. Table 9A and Table 9C of FORM GSTR-1 may be used for filling up these details.</p>
                              <p>2. Taxpayer can report the values in table 5A to 5F as net of amendments in case of any difficulty in reporting the same separately."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"5L. Sub-Total (H to K above)
                           5M. Turnover on which tax is not to be paid  (G + L above).
                           5N. Total Turnover (including advances) (4N + 5M - 4G above)"
                        </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>These fields shall be auto calculated.</p>
                           </div>
                        </td>
                     </tr>
                     <!---5. Outward-end -->
                     <!---6. Outward-end -->
                     <tr>
                        <td colspan="4" style="text-align:center;">Pt. III Details of ITC for the financial year</td>
                     </tr>
                     <tr>
                        <td rowspan="13">6. ITC availed</td>
                        <td rowspan="13">6A. Details of ITC availed during the financial year</td>
                        <td>6A. Total amount of input tax credit availed through FORM GSTR-3B (sum total of Table 4A of FORM GSTR-3B) </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Total input tax credit availed in Table 4A of FORM GSTR-3B by the taxpayer would be auto-populated here.</p>
                              <p>2. This field is Non-editable. Taxpayer shall import the JSON file in to offline tool to check the total amount of input tax credit availed through Form GSTR 3B.</p>
                              <p>3. Taxpayer shall import the JSON file to check the auto filled details in table no 6A."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6B. Inward supplies (other than imports and inward supplies liable to reverse charge but includes services received from SEZs)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of ITC availed on all inward supplies except those on which tax is payable on reverse charge basis but includes supply of services received from SEZs shall be declared here. It may be noted that the total ITC availed may be classified as ITC on inputs, capital goods and input services.</p>
                              <p>2. Table 4(A)(5) of FORM GSTR-3B may be used for filling up these details. This shall not include ITC which was availed, reversed and then reclaimed in the ITC ledger. This is to be declared separately under 6(H)."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6C. Inward supplies received from unregistered persons liable to reverse charge (other than B above) on which tax is paid & ITC availed </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of input tax credit availed on all inward supplies received from unregistered persons (other than import of services) on which tax is payable on reverse charge basis shall be declared here. It may be noted that the total ITC availed may be classified as ITC on inputs, capital goods and input services.</p>
                              <p>2. Table 4(A)(3) of FORM GSTR-3B may be used for filling up these details "				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6D. Inward supplies received from registered persons liable to reverse charge (other than B above) on which tax is paid and ITC availed </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of input tax credit availed on all inward supplies received from registered persons on which tax is payable on reverse charge basis shall be declared here. It may be noted that the total ITC availed may be classified as ITC on inputs, capital goods and input services.</p>
                              <p>2. Table 4(A)(3) of FORM GSTR-3B may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6E. Import of goods (including supplies from SEZs)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Details of input tax credit availed on import of goods including supply of goods received from SEZs shall be declared here. It may be noted that the total ITC availed may be classified as ITC on inputs and capital goods.</p>
                              <p>2. Table 4(A)(1) of FORM GSTR-3B may be used for filling up these details"				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6F. Import of services (excluding inward supplies from SEZs)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Details of input tax credit availed on import of services (excluding inward supplies from SEZs) shall be declared here.</p>
                              <p>2. Table 4(A)(2) of FORM GSTR3B may be used for filling up these details"</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6G. Input Tax credit received from ISD</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of input tax credit received from input service distributor shall be declared here.</p>
                              <p>2. Table 4(A)(4) of FORM GSTR-3B may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6H. Amount of ITC reclaimed (other than B above) under the provisions of the Act</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of input tax credit availed, reversed and reclaimed under the provisions of the Act shall be declared here</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"6I. Sub-total (B to H above)6J. Difference (I - A above)"</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>These fields shall be auto calculated.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6K. Transition Credit through TRAN-I (including revisions if any)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Details of transition credit received in the electronic credit ledger on filing of FORM GST TRAN-I including revision of thereof (whether upwards or downwards), if any shall be declared here. This field shall be auto filled based on the credit availed through Tran 1. However this field is allowed for edit.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6L. Transition Credit through TRAN-II</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Details of transition credit received in the electronic credit ledger after filing of FORM GST TRAN-2 shall be declared here. This field shall be auto filled based on the credit availed through Tran 2. However this field is allowed for edit.				</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>6M. Any other ITC availed but not specified above </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Details of ITC availed but not covered in any of heads specified under 6B to 6L above shall be declared here. Details of ITC availed through FORM ITC-01 and FORM ITC-02 in the financial year shall be declared here.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"6N. Sub-total (K to M  above)6O. Total ITC availed (I +  N above)"</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>These fields shall be auto calculated.</p>
                           </div>
                        </td>
                     </tr>
                     <!---6. Outward-end -->
                     <!---7. Outward-end -->
                     <tr>
                        <td colspan="4" style="text-align:center;">Pt. IV Details of tax paid as declared in returns filed during the financial year	</td>
                     </tr>
                     <tr>
                        <td>7. ITC Rev</td>
                        <td>7. Details of ITC Reversed and Ineligible ITC for the financial year</td>
                        <td>Table no 7A to 7H</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Details of input tax credit reversed due to ineligibility or reversals required under rule 37, 39, 42 and 43 of the CGST/SGST Rules, 2017 shall be declared here.</p>
                              <p>2. This column should also contain details of any input tax credit reversed under section 17(5) of the CGST/SGST Act, 2017 and details of ineligible transition credit claimed through FORM GST TRAN-1 or FORM GST TRAN-2 and then subsequently reversed.</p>
                              <p>3. Table 4(B) of FORM GSTR-3B may be used for filling up these details. Any ITC reversed through FORM GST ITC -03 shall be declared in 7H. If taxpayer wants to specify more reversals then he can click on '+' symbol to add more rows.</p>
                              <p>4. If the amount stated in Table 4D of FORM GSTR-3B was not included in table 4A of FORM GSTR-3B, then no entry should be made in table 7E of FORM GSTR-9. However, if amount mentioned in table 4D of FORM GSTR-3B was included in table 4A of FORM GSTR-3B, then entry will come in 7E of FORM GSTR-9."</p>
                           </div>
                        </td>
                     </tr>
                     <!---7. Outward-end -->
                     <!---8. Outward-end -->
                     <tr>
                        <td rowspan="9">8. Other ITC</td>
                        <td rowspan="9">8. Other ITC related information</td>
                        <td>8A. ITC as per GSTR-2A (Table 3 & 5 thereof)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. The total credit available for inwards supplies (other than imports and inwards supplies liable to reverse charge but includes services received from SEZs) received during the relevant Financial Year and reflected in FORM GSTR-2A (table 3 & 5 only) shall be auto-populated in this table.</p>
                              <p>2. This would be the aggregate of all the input tax credit that has been declared by the corresponding suppliers in their FORM GSTR-1</p>
                              <p>3. This field shall be auto-filled based on your GSTR-2A and the same is not allowed for Edit.</p>
                              <p>4. Taxpayer shall import the JSON file to check the auto filled details in table no 6A."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8C. ITC on inward supplies (other than imports and inward supplies liable to reverse charge but includes services received from SEZs) received during the financial year but availed in the next financial year upto specified period</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of input tax credit availed on all inward supplies (except those on which tax is payable on reverse charge basis but includes supply of services received from SEZs) received during the Financial Year but credit on which was availed in the next financial year upto specified period..</p>
                              <p>2. Table 4(A)(5) of FORM GSTR-3B may be used for filling up these details."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8D. Difference [A-(B+C)] </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>"8E. ITC available but not availed 8F. ITC available but ineligible"</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>1. The credit which was available and not availed in FORM GSTR-3B and the credit was not availed in FORM GSTR-3B as the same was ineligible shall be declared here. Ideally, if 8D is positive, the sum of 8E and 8F shall be equal to 8D.				</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8G. IGST paid on import of goods (including supplies from SEZ) </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of IGST paid at the time of imports (including imports from SEZs) during the financial year shall be declared here</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8H. IGST credit availed on import of goods (as per 6(E) above)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>The input tax credit as declared in Table 6E shall be auto-populated here and the same is not allowed for edit. If taxpayer wants to change the credit availed on import of goods, then he shall make changes in table no 6E.				</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8I. Difference (G-H)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated								
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8J. ITC available but not availed on import of goods (Equal to I) </td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>This field shall be auto calculated. If taxpayer wants to make any change in this field, then he shall make changes in table no 8G and 6E	</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>8K. Total ITC to be lapsed in current financial year (E + F + J)</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>The total input tax credit which shall lapse for the current financial year shall be computed (auto filled) in this row</p>
                           </div>
                        </td>
                     </tr>
                     <!---8. Outward-end -->
                     <!---9. Outward-end -->
                     <tr>
                        <td>9. Tax Paid</td>
                        <td>9. Details of tax paid as declared in returns filed during the financial year</td>
                        <td colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>"1. Actual tax (including Interest, Late fee, Penalty, Others) paid through cash or ITC during the financial year shall be declared year. 
                              <p>2. Payment of tax under Table 6.1 of FORM GSTR-3B may be used for filling up these details.</p>
                              <p>3. Paid through Cash and Paid through ITC columns shall be auto filled based on table no 6.1 of GSTR -3B and the same is non-editable
                                 "					
                              </p>
                           </div>
                        </td>
                     </tr>
                     <!---9. Outward-end -->
                     <!---10. Outward-end -->
                     <tr>
                        <td colspan="4">Pt. V Particulars of the transactions for the financial year declared in returns of the next financial year till the specified period</td>
                     </tr>
                     <tr>
                        <td rowspan="3">"10. PY trans in current FY"</td>
                        <td>"10. Supplies / tax declared through Amendments (+) (net of debit notes)11. Supplies / tax reduced through Amendments (-) (net of credit notes)"</td>
                        <td  colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>Details of additions or amendments to any of the supplies already declared in the returns of the previous financial year but such amendments were furnished in Table 9A, Table 9B and Table 9C of FORM GSTR-1 in the current financial year upto the specified period.</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>12. Reversal of ITC availed during previous financial year</td>
                        <td  colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of reversal of ITC which was availed in the previous financial year but reversed in returns filed in the current financial year upto the specified period shall be declared here.</p>
                              <p>2.  Table 4(B) of FORM GSTR-3B may be used for filling up these details.tails."</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>13. ITC availed for the previous financial year</td>
                        <td  colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>"1. Details of ITC for goods or services received in the previous financial year but ITC for the same was availed in returns filed in the current financial year upto the specified period shall be declared here.</p>
                              <p>2. Table 4(A) of FORM GSTR-3B may be used for filling up these details"</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>14. Differential tax</td>
                        <td>14. Differential tax paid on account of declaration in 10 & 11 above</td>
                        <td colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>Differential tax (including Interest) paid on account of transactions related to the previous financial year but declared in the returns filed in the current financial year shall be reported in this table</p>
                           </div>
                        </td>
                     </tr>
                     <!---10. Outward-end -->
                     <!---11. Outward-end -->
                     <tr>
                        <td colspan="4" style="text-align:center;">Pt. VI Other Information</td>
                     </tr>
                     <tr>
                        <td rowspan="2">15. Demand & Refund</td>
                        <td rowspan="2">15. Particulars of Demands and Refunds </td>
                        <td>15A to 15D</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of refunds claimed, sanctioned, rejected and pending for processing shall be declared here.</p>
                              <p>2. Refund claimed will be the aggregate value of all the refund claims filed in the financial year and will include refunds which have been sanctioned, rejected or are pending for processing.</p>
                              <p>3. Refund sanctioned means the aggregate value of all refund sanction orders.</p>
                              <p>4. Refund pending will be the aggregate amount in all refund application for which acknowledgement has been received and will exclude provisional refunds received. These will not include details of non-GST refund claims.</p>
                              <p>5. This table is optional."</p>
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>15E to 15G</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of demands of taxes for which an order has been issued by the adjudicating authority shall be declared here.</p>
                              <p>2. Aggregate value of taxes paid out of the total value of demand as declared in 15E above shall be declared here.</p>
                              <p>3. Aggregate value of demands pending recovery out of 15E above shall be declared here.</p>
                              <p>4. This table is optional."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td rowspan="2">15. Demand & Refund</td>
                        <td rowspan="2">15. Particulars of Demands and Refunds </td>
                        <td>15A to 15D</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of refunds claimed, sanctioned, rejected and pending for processing shall be declared here.</p>
                              <p>2. Refund claimed will be the aggregate value of all the refund claims filed in the financial year and will include refunds which have been sanctioned, rejected or are pending for processing.</p>
                              <p>3. Refund sanctioned means the aggregate value of all refund sanction orders.</p>
                              <p>4. Refund pending will be the aggregate amount in all refund application for which acknowledgement has been received and will exclude provisional refunds received. These will not include details of non-GST refund claims.</p>
                              <p>5. This table is optional."</p>
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>15E to 15G</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of demands of taxes for which an order has been issued by the adjudicating authority shall be declared here.</p>
                              <p>2. Aggregate value of taxes paid out of the total value of demand as declared in 15E above shall be declared here.</p>
                              <p>3. Aggregate value of demands pending recovery out of 15E above shall be declared here.</p>
                              <p>4. This table is optional."				
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td rowspan="3">16. Comp DS & Goods sent on appr</td>
                        <td rowspan="3">16. Information on supplies received from composition taxpayers, deemed supply under section 143 and goods sent on approval basis</td>
                        <td>16A. Supplies received from Composition taxpayers</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>"1. Aggregate value of supplies received from composition taxpayers shall be declared here</p>
                              <p>2. Table 5 of FORM GSTR-3B may be used for filling up these details"</p>
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>16B. Deemed supply  under Section 14</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of all deemed supplies from the principal to the job-worker in terms of sub-section (3) and sub-section (4) of Section 143 of the CGST Act shall be declared her</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>16C. Goods sent on approval basis but not returned</td>
                        <td>
                           <div style="word-wrap: break-word;">
                              <p>Aggregate value of all deemed supplies for goods which were sent on approval basis but were not returned to the principal supplier within one hundred eighty days of such supply shall be declared here</p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>17. HSN Outward</td>
                        <td>17. HSN Wise Summary of outward supplies </td>
                        <td colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>"1. Summary of outward supplies made against a particular HSN code to be reported in this table.</p>
                              <p>2. Quantity is to be reported net of returns (sold but returned).</p>
                              <p>3. Table 12 of FORM GSTR-1 may be used for filling up details in Table 17.</p>
                              <p>4. HSN code field is always user input in offline tool. However, at the time of clicking on Validate sheet, tool shall validate the HSN code details with Master</p>
                              <p>5. This table is optional."					
                              </p>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>18. HSN Inward</td>
                        <td>18. HSN Wise Summary of Inward supplies </td>
                        <td colspan="2">
                           <div style="word-wrap: break-word;">
                              <p>"1. Summary of supplies received against a particular HSN code to be reported only in this table.</p>
                              <p>2. Quantity is to be reported net of returns (purchased but returned).</p>
                              <p>3.HSN code field is always user input in offline tool. However, at the time of clicking on Validate sheet, tool shall validate the HSN code details with Master</p>
                              <p>4. This table is optional."</p>
                           </div>
                        </td>
                     </tr>
                     <!---11. Outward-end -->
                  </tbody>
               </table>
            </div>
            <!--<div id="Home" class="tab-pane fade">
               <div class="col-md-12">			    
               <div class="col-md-12 boxs">
               <p>"1. Please ensure you download the latest version of  GSTR-9 Offline Tool from the GST portal. https://www.gst.gov.in/download/returns</p>
               <p>2. Launch the GSTR-9 Excel based Offline Tool a pop up (Open saved version - Yes/No) would appear and navigate to worksheet named 'Home'
               <br>a. On click of 'Yes' any previously saved data in the offline tool will be available.<br>    
               b. On click of 'No' any data previously saved data in the offline tool will be lost and you can't recover the data.</p>
               <p>3. Enter your GSTIN in home sheet. Entered GSTIN would be validated only for correct structure.</p>
               <p>4. Select the applicable Financial Year from the drop-down. It is a mandatory field.</p>
               <p>5. Download GSTR-9 JSON file from GST portal after logging in to the portal from 'Prepare Offline' section of GSTR-9 tile.</p>
               <p>6. Open downloaded  GSTR-9 JSON file in to the Offline tool. JSON file can't be generated from Offline tool until GSTR-9 JSON file downloaded from the portal has been opened in the Offline tool.</p> 
               <p>7. Auto drafted details shall be populated in respective work sheets.</p> 
               <p>8. Enter additional details/edit auto drafted details as applicable in various worksheets. It is not Mandatory to fill data in all worksheets. The worksheet for which no details need to be declared can be left blank.</p>
               <p>9. Click Validate Sheet to check the status of validation. In case of validation failure; please check for cells that have failed validation and correct errors as per help text.</p>
               <p>10.Click on 'Generate JSON File to Upload ' to generate JSON file for upload of GSTR-9 return details prepared offline on GST portal.   "							
               </p>							
               </div>
               </div>
               </div>-->
            <div id="Outward" class="tab-pane fade">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2" style="text-align: center;">Nature of Supplies			
                        </th>
                        <th>Taxable Value (₹)
                        </th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">(Amount in ₹ in all tables)</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th colspan="2"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td style="width:20px;">4</td>
                        <td style="border-left: 1px solid #ddd !important;text-align: center;background-color: #78ABE5;color: #fff;" colspan="4">Details of advances, inwards and outward supplies made during the financial year on which tax is payable								
                        </td>
                     </tr>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies made to un-registered persons (B2C) 		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies made to registered persons (B2B)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Zero rated supply (Export) on payment of tax (except supplies to SEZs)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supply to SEZs on payment of tax		
                           Supply to SEZs on payment of tax		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Deemed Exports</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Advances on which tax has been paid but invoice has not been issued (not covered under (A) to (E) above)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Inward supplies on which tax is to be paid on reverse charge basis		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>H</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (A to G above)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>I</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Credit Notes issued in respect of transactions specified in (B) to (E) above (-)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>J</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Debit Notes issued in respect of transactions specified in (B) to (E) above (+)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>K</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies / tax declared through Amendments (+)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>L</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies / tax reduced through Amendments (-)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>M</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (I to L above)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>N</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies and advances on which tax is to be paid (H + M) above		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="Outward2" class="tab-pane fade">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2" style="text-align: center;">Nature of Supplies			
                        </th>
                        <th>Taxable Value (₹)
                        </th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">(Amount in ₹ in all tables)</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th colspan="2"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td style="width:20px;">5</td>
                        <td style="border-left: 1px solid #ddd !important;text-align: center;background-color: #78ABE5;color: #fff;" colspan="4">Details of Outward supplies made during the financial year on which tax is not payable						
                        </td>
                     </tr>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Zero rated supply (Export) without payment of tax
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supply to SEZs without payment of tax
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies on which tax is to be paid by recipient on reverse charge basis
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Exempted 
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Nil Rated 
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Non-GST supply (includes 'no supply' ) 
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (A to F above)
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>H</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Credit Notes issued in respect of transactions specified in A to F above (-)
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>I</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Debit Notes issued in respect of transactions specified in A to F above (+)
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>J</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies / tax declared through Amendments (+)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>K</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies / tax reduced through Amendments (-)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>L</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (I to L above)		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>M</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies and advances on which tax is to be paid (H + M) above		
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="ITCavailed" class="tab-pane fade">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2" style="text-align: center;">Nature of Supplies			
                        </th>
                        <th>Taxable Value (₹)
                        </th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">(Amount in ₹ in all tables)</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th colspan="2"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td style="width:20px;">6</td>
                        <td style="border-left: 1px solid #ddd !important;text-align: center;background-color: #78ABE5;color: #fff;" colspan="4">Details of Outward supplies made during the financial year on which tax is not payable						
                        </td>
                     </tr>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total amount of input tax credit availed through FORM GSTR-3B (Sum total of table 4A of FORM GSTR-3B)	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td rowspan="3">B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;" rowspan="3">Inward supplies (other than imports and inward supplies liable<br> to reverse charge but includes services received from SEZs)
                        </td>
                        <td style="border-right: 1px solid #ddd!important;">Inputs</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Capital Goods</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Input Services</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td rowspan="3">C</td>
                        <td rowspan="3" style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies on which tax is to be paid by recipient on reverse charge basis
                        </td>
                        <td style="border-right: 1px solid #ddd!important;">Inputs</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Capital Goods</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Input Services</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td  rowspan="3">D</td>
                        <td  rowspan="3" style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Exempted 
                        </td>
                        <td style="border-right: 1px solid #ddd!important;">Inputs</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Capital Goods</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td style="border-right: 1px solid #ddd!important;">Input Services</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Nil Rated 
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Import of services (excluding inward supplies from SEZs)	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Input Tax  credit received from ISD	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>H</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Amount of ITC reclaimed (other than B above) under the provisions of the Act	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>I</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (B to H above)	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>J</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Difference (I - A) above	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>K</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Transition Credit through TRAN-1 (including revisions if any)	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>L</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Transition Credit through TRAN-2	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>M</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Any other ITC availed but not specified above	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>N</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Sub-total (K to M above)	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>0</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total ITC availed (I + N) above	
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="ITCRev" class="tab-pane fade">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th></th>
                        <th style="text-align: center;">Details	</th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">(Amount in ₹ in all tables)			</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td style="width:20px;">7</td>
                        <td style="border-left: 1px solid #ddd !important;text-align: center;background-color: #78ABE5;color: #fff;" colspan="3">Details of ITC Reversed and  Ineligible ITC for the financial year</td>
                     </tr>
                     <tr>
                        <td style="width:20px;">A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">As per Rule 37</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">As per Rule 39</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">As per Rule 42</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">As per Rule 43</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">As per section 17(5)</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Reversal of TRAN-I credit</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Reversal of TRAN-II credit</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>H</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Other reversals(specify)</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>I</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total ITC Reversed (Sum of A to H above)</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>j</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Net ITC Available for Utilization (6O - 7I)</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="OtherITC" class="tab-pane fade ">
               <div id="OtherITC" class="tab-pane fade active in">
                  <table class="table table-striped table-bordered" border="1">
                     <thead>
                        <tr>
                           <th></th>
                           <th style="text-align: center;">Details	</th>
                           <th rowspan="2" style="padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <th colspan="4">(Amount in ₹ in all tables)			</th>
                                    </tr>
                                    <tr>
                                       <th style="width: 20%;">Central Tax</th>
                                       <th style="width: 20%;">State Tax / UT Tax</th>
                                       <th style="width: 20%;">Integrated Tax</th>
                                       <th style="width: 20%;">Cess</th>
                                    </tr>
                                 </tbody>
                              </table>
                           </th>
                           <th rowspan="2">Sheet Validation Errors</th>
                        </tr>
                        <tr>
                           <th></th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td style="width:20px;">8</td>
                           <td style="border-left: 1px solid #ddd !important;text-align: center;background-color: #78ABE5;color: #fff;" colspan="3">Other ITC Related Information</td>
                        </tr>
                        <tr>
                           <td style="width:20px;">A</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC as per GSTR-2A (Table 3 &amp; 5 thereof)
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;">Central Tax</td>
                                       <td style="width: 20%;">State Tax / UT Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>B</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC as per sum total 6(B) and 6(H)  above
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;">Central Tax</td>
                                       <td style="width: 20%;">State Tax / UT Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>C</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC on inward supplies (other than imports and inward <br>supplies liable to reverse charge but includes services received<br> from SEZs) received during the financial year but availed in the next financial year upto specified period
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;">Central Tax</td>
                                       <td style="width: 20%;">State Tax / UT Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>D</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Difference [A-(B+C)]
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;">Central Tax</td>
                                       <td style="width: 20%;">State Tax / UT Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                       <td style="width: 20%;">Integrated Tax</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>E</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC available but not availed
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>F</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC available but ineligible
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>G</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">IGST paid  on import of goods (including supplies from SEZ)
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>H</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">IGST credit availed on import of goods (as per 6(E) above)
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>I</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Difference (G-H)
                           </td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>j</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC available but not availed on import of goods (Equal to I)</td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                        <tr>
                           <td>K</td>
                           <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total ITC to be lapsed in current financial year (E + F + J)</td>
                           <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                       <td style="width: 20%;text-align:right;"></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                           <td style="border-right: 1px solid #ddd!important;"></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div id="TaxPaid" class="tab-pane fade ">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th></th>
                        <th style="text-align: center;">Description</th>
                        <th>Taxable Value (₹)</th>
                        <th>Paid through cash (₹)</th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">Paid through ITC (₹)</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Integrated Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Central Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">State/UT Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Cess</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Interest</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Late fee</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Penalty</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>H</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Other</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                    <td style="width: 20%;text-align:right;"></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="PYtrans" class="tab-pane fade ">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2" style="text-align: center;">Description</th>
                        <th>Taxable Value (₹)</th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <th colspan="4">(Amount in ₹ in all tables)</th>
                                 </tr>
                                 <tr>
                                    <th style="width: 20%;">Central Tax</th>
                                    <th style="width: 20%;">State Tax / UT Tax</th>
                                    <th style="width: 20%;">Integrated Tax</th>
                                    <th style="width: 20%;">Cess</th>
                                 </tr>
                              </tbody>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th colspan="2"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>10</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;"> Supplies / tax declared through Amendments (+) (net of debit notes)</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>11</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies / tax reduced through Amendments (-) (net of credit notes)</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>12</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Reversal of ITC availed during previous financial year</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>13</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC availed for the previous financial year</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;">Central Tax</td>
                                    <td style="width: 20%;">State Tax / UT Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                    <td style="width: 20%;">Integrated Tax</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>13</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">ITC availed for the previous financial year</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;">
                           <table>
                              <tbody>
                                 <tr>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                    <td style="width: 20%;text-align:right;">0.00</td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="Differentialtax" class="tab-pane fade">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2">Description</th>
                        <th>Payable (₹)</th>
                        <th>Paid (₹)</th>
                        <th>Sheet Validation Errors</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td style="width: 30px">A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Integrated Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Central Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">State/UT Tax</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Cess</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Interest</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="demand_refund" class="tab-pane fade ">
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th colspan="2"></th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tr>
                                 <th colspan="7">(Amount in ₹)</th>
                              </tr>
                              <tr>
                                 <th style="width: 10%;">Central Tax</th>
                                 <th style="width: 10%;">State Tax / UT Tax</th>
                                 <th style="width: 10%;">Integrated Tax</th>
                                 <th style="width: 10%;">Integrated Tax</th>
                                 <th style="width: 10%;">State Tax / UT Tax</th>
                                 <th style="width: 10%;">Integrated Tax</th>
                                 <th style="width: 10%;">Integrated Tax</th>
                              </tr>
                           </table>
                        </th>
                        <th></th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th colspan="2" style="    text-align: center;">Details</th>
                        <th>Taxable Value (₹)</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total Refund claimed </td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total Refund sanctioned</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total Refund Rejected</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>D</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total Refund Pending</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>E</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total demand of taxes </td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>F</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total taxes paid in respect of E above</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>G</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Total demands pending out of E above</td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 10%;">Central Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">State Tax / UT Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                                 <td style="width: 10%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="Comp_Ds" class="tab-pane fade">
               <!-- id="trial_balance_id" -->
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th rowspan="2" style="padding: 0px;width: 50%;">
                           <table>
                              <tr>
                                 <th colspan="4">(Amount in ₹ in all tables)</th>
                              </tr>
                              <tr>
                                 <th style="width: 20%;">Central Tax</th>
                                 <th style="width: 20%;">State Tax / UT Tax</th>
                                 <th style="width: 20%;">Integrated Tax</th>
                                 <th style="width: 20%;">Cess</th>
                              </tr>
                           </table>
                        </th>
                        <th rowspan="2">Sheet Validation Errors</th>
                     </tr>
                     <tr>
                        <th></th>
                        <th>Details</th>
                        <th>Taxable Value (₹)</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies received from Composition taxpayers</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 20%;">Central Tax</td>
                                 <td style="width: 20%;">State Tax / UT Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>A</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Supplies received from Composition taxpayers</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 20%;">Central Tax</td>
                                 <td style="width: 20%;">State Tax / UT Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>B</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Deemed supply under section 143</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 20%;">Central Tax</td>
                                 <td style="width: 20%;">State Tax / UT Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                     <tr>
                        <td>C</td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;">Goods sent on approval basis but not returned</td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important; padding: 0px;width: 50%;" >
                           <table>
                              <tr>
                                 <td style="width: 20%;">Central Tax</td>
                                 <td style="width: 20%;">State Tax / UT Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                                 <td style="width: 20%;">Integrated Tax</td>
                              </tr>
                           </table>
                        </td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="Hsn_Ountward" class="tab-pane fade">
               <!-- id="trial_balance_id" -->
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th>HSN Code<span style="color: red;font-size: 18px;">*</span></th>
                        <th>Description</th>
                        <th>UQC<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Total quantity<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Total Taxable value (₹)<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Is supply applicable for concessional<br> rate of tax<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Rate of Tax (%)<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Integrated Tax (₹)</th>
                        <th>Central Tax (₹)</th>
                        <th>State/UT Tax (₹)</th>
                        <th>Cess</th>
                        <th>Action<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Sheet Validation errors</th>
                        <th>GST portal Validation Errors</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td></td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div id="Hasn_Inward" class="tab-pane fade">
               <!-- id="trial_balance_id" -->
               <table class="table table-striped table-bordered" border="1">
                  <thead>
                     <tr>
                        <th>HSN Code<span style="color: red;font-size: 18px;">*</span></th>
                        <th>Description</th>
                        <th>UQC<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Total quantity<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Total Taxable value (₹)<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Is supply applicable for concessional<br> rate of tax<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Rate of Tax (%)<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Integrated Tax (₹)</th>
                        <th>Central Tax (₹)</th>
                        <th>State/UT Tax (₹)</th>
                        <th>Cess</th>
                        <th>Action<span style="color: red;font-size: 18px;"> *</span></th>
                        <th>Sheet Validation errors</th>
                        <th>GST portal Validation Errors</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td></td>
                        <td style="border-left: 1px solid #ddd !important;border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                        <td style="border-right: 1px solid #ddd!important;"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>