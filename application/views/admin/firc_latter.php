<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
?>
 <div class="main-container">
			<?php $this->view('lib/sidebar'); ?>
			 <div class="main-content">
				<div class="container">
					 <div class="row">
						<div class="col-sm-12">
						  <ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									FIRC Letter
								</li>
								 
							</ol>
							<div class="page-header">
							
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									FIRC Details
									
								</div>
								<div class="panel-body" >
									 
									<?php
									 // print_r('<pre>');
									 // print_r($payment_record);

									?>
										   
									
									<div class="table-responsive">
                                    <table width="100%"  style="border-collapse: collapse;"  >
			<tr>
				<td colspan="8" align="center"><strong>REQUEST LETTER FOR PROCESING OF EXPORT BILL AGAINST ADVANCE REMITTANCE RECEIVED</strong></td>
			</tr>

			<tr>
				<td colspan="8">TO</td>
			</tr>
			<tr>
				<td colspan="4" align="left">The Branch Manager</td>
				<td colspan="4" align="left">Dated:	<strong>25/05/2020</strong></td>
			</tr>
			<tr>
				<td colspan="8">HDFC Bank Ltd.</td>
			</tr>
			<tr>
				<td colspan="8">Ravapar Road</td>
			</tr>
			<tr>
				<td colspan="8">Morbi</td>
			</tr>


			<tr>
				<td colspan="8" align="center"><strong>Sub: Submission of Export documents against advance remittance received for release of<br>GR/Shipping Bill/Softex form.</strong></td>
			</tr>
			<tr>
				<td colspan="8">We enclose herewith the following Export Documents:</td>
			</tr>

			<tr>
				<th align="center" style="border:1px solid black;">Documents</th>
				<th align="center" style="border:1px solid black;" >Invoice</th>
				<th align="center" style="border:1px solid black;" >Transport Doc.<br>(B/L /AWB/LR)</th>
				<th align="center" style="border:1px solid black;" >FIRC</th>
				<th align="center" style="border:1px solid black;" >GR / S.B. /<br>SOFTEX FORM	</th>
				<th align="center" style="border:1px solid black;" >Other</th>
				<th align="center" style="border:1px solid black;"  colspan="2">If any documents are<br>original, Please specify</th>

			</tr>


			<tr>
				<td align="center"  style="border:1px solid black;">Dublicate</td>
				<td  align="center" style="border:1px solid black;">1</td>
				<td  align="center" style="border:1px solid black;">1</td>
				<td  align="center" style="border:1px solid black;">1</td>
				<td  align="center" style="border:1px solid black;">1</td>
				<td  align="center" style="border:1px solid black;">1</td>
				<td  align="center" style="border:1px solid black;" colspan="2"> -</td>

			</tr>

			<tr>
				<td colspan="2"><br><br></td>
			</tr>
<?php
 $grand_total = $invoice_record[0]->grand_total;
 $grand_total += $invoice_record[0]->certification_charge;
 $grand_total += $invoice_record[0]->insurance_charge;
 $grand_total += $invoice_record[0]->seafright_charge;
?>
			<tr>
				<th align="center" colspan="1" style="border:1px solid black;">FIRC No</th>
				<th align="center" style="border:1px solid black;">CCY</th>
				<th align="center" style="border:1px solid black;">Amount</th>
				<th align="center" style="border:1px solid black;">Utilisation</th>
				<th align="center"></th>
				<th  colspan="2" style="border:1px solid black;">Bill Amount : <strong><?=$invoice_record[0]->currency_name?> <?=$grand_total?></strong></th>

			</tr>
            <?php 
           
                $m=1;
                for($i=0; $i<count($payment_record);$i++)
                {
                ?>
			<tr>
				<td align="center" colspan="1" style="border:1px solid black;"><?=$payment_record[$i]->refernace_no?></td>
				<td align="center" style="border:1px solid black;"><?=$invoice_record[0]->currency_name?></td>
				<td align="center" style="border:1px solid black;"><?=$grand_total?></td>
				<td align="center" style="border:1px solid black;"><?php echo $payment_record[$i]->paid_amount; ?></td>
				<td align="center" ></td>
				<td  colspan="2" style="border:1px solid black;">Invoice No. :<strong> <?=$invoice_record[0]->export_invoice_no?></strong></td>
			</tr>
            <?php
                }
            ?>
			<!-- <tr>
				<td align="center" colspan="1" style="border:1px solid black;">080120104990xxxx</td>
				<td align="center" style="border:1px solid black;">USD	</td>
				<td align="center"style="border:1px solid black;">3884.60</td>
				<td align="center" style="border:1px solid black;">3884.60</td>
				<td align="center"></td>
				<td  colspan="2" style="border:1px solid black;">GR / <strong>Shipping Bill</strong> / Sofex Form No : <strong>1072xxx </strong></td>
			</tr> -->
			<tr>
				<td align="center" colspan="1" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center"></td>
				<td  colspan="2" style="border:1px solid black;">Date of Transport doc (AWB /BL / LR): <strong> 11/02/2020</strong></td>
			</tr>
			<tr>
				<td align="center" colspan="1" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"><br></td>
				<td align="center" style="border:1px solid black;"><br></td>
				<td align="center" style="border:1px solid black;"><br></td>
				<td align="center"></td>
				<td  colspan="2" rowspan="5" valign="top" style="border:1px solid black;"><i>If the above mentioned documents are being submitted after <br>expiry of 21 days from date of shipment, than please briefly <br>describe the reason for delay in submission of document…….</i></td>
			</tr>
			<tr>
				<td colspan="1" style="border:1px solid black;"></td>
				<td style="border:1px solid black;"><br></td>
				<td style="border:1px solid black;"><br></td>
				<td style="border:1px solid black;"><br></td>
				<td></td>
				
			</tr>
			<tr>
				<td align="center" colspan="1" style="border:1px solid black;">Discount</td>
				<td align="center" style="border:1px solid black;"><?=$invoice_record[0]->currency_name?></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;">0.00</td>
				<td align="center" ></td>
				
			</tr>
			<tr>
				<td align="center" colspan="1" style="border:1px solid black;">Foreign Bank Charge	</td>
				<td align="center"style="border:1px solid black;"><?=$invoice_record[0]->currency_name?></td>
				<td align="center"style="border:1px solid black;"></td>
				<td align="center"style="border:1px solid black;"><?=$invoice_record[0]->total_bank_charges?></td>
				<td align="center"></td>
				
			</tr>
			<tr >
				<td align="center" colspan="1" style="border:1px solid black;"><strong>Total</strong></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"></td>
				<td align="center" style="border:1px solid black;"><?=$invoice_record[0]->total_paid?></td>
				<td align="center" ></td>
			</tr>

			<tr >
				<td colspan="2" style="border-top: 0px;"><br><br></td>
			</tr>

			<tr>
				<td colspan="8">Debit all charges for processing of above-mentioned documents from account no. <strong>5020000xxxxx</strong> with your <strong>Morbi</strong> branch</td>
			</tr>
			<tr>
				<td colspan="8"><br><br></td>
			</tr>
			<tr>
				<td colspan="8">We are eligible to export the above mentioned goods under the current Foreign Trade policy in place. And our Importer Exporter Code is<strong> 24xxxx</strong></td>
			</tr>
			<tr>
				<td colspan="8"><br><br></td>
			</tr>

			<tr>
				<td colspan="8">
					I / We hereby declare that the above transaction does not involve, and is not designed for the purpose of any contravention or evasion of the provisions of the FEMA 1999 or of any rule, regulation, notification, direction or order made there under. I/ We also hereby agree and undertake to give such information/ documents as will reasonably satisfy you about this transaction in terms of the above declaration. I/ We also undertake that if I/ We refuse to comply with any such requirements or make only unsatisfactory compliance therewith, the bank shall refuse in writing to undertake the transaction and shall if it has reason to believe that any contravention /evasion is contemplated by me /us report the matter to Reserve Bank Of India. *I / We further declare that the undersigned has/have the authority to give this declaration and undertaking on behalf of the firm/company.
				</td>
			</tr>

			<tr>
				<td colspan="8"><br><br><br></td>
			</tr>
			<tr>
				<td colspan="8"><strong>For, Zuku Pvt Ltd</strong></td>
			</tr>
			<tr>
				<td colspan="8"><br></td>
			</tr>
			<tr>
				<td colspan="8"><strong>AUTHORISED SIGNATORY</strong></td>
			</tr>
			
    </table>
									</div>		
								
								</div>
								
								
							</div>
						 
						</div>
					</div>
	
    <?php $this->view('lib/footer'); ?>