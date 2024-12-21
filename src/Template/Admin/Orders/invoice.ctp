<?php 
	  use Cake\Routing\Router;
	  use Cake\Core\Configure;
	 
	// pr();
	$productd_charges  = $this->General->Get_charge_products($OrderData->order_number,$OrderData->user_id);
	$charge_additional = $this->General->Get_charge_additional($OrderData->order_number,$OrderData->user_id);
	$charge_tax 	   = $this->General->Get_charge_tax($OrderData->order_number,$OrderData->user_id);
					
						
?> 

    <section class="content-header">
      <h1>
        Invoice
        <small>#<?= $OrderData->order_number?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Orders</a></li>
        <li class="active">Invoice</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
			<span class="logo-lg"><img src="<?php echo Router::url('/', true); ?>img/CLlogo3.png" alt="<?php echo Configure::read('App.meta'); ?>" class="logo-default" style="margin-top:0px; max-height:60px; line-height:60px;"></span>
            <!--i class="fa fa-globe"></i--> <?php //echo Configure::read('App.meta'); ?>
			<small class="pull-right">Date: <?= $OrderData->created?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?php echo Configure::read('App.meta'); ?></strong><br>
            <?php echo Configure::read('App.Address'); ?><br>
            Phone: (+91) <?php echo Configure::read('App.phone'); ?><br>
            Email: <?php echo Configure::read('App.ConfigEmail'); ?><br>
            GSTN: <?php echo Configure::read('App.GSTN'); ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?= $OrderData->user->full_name ?></strong><br>
            <?= $OrderData->user->address ?><br>
            Phone: (+91) <?= $OrderData->user->phone ?><br>
            Email: <?= $OrderData->user->email ?><br>
            GSTN: <?= $OrderData->user->gstn_number ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
		<br>
          <b>Invoice #<?= $OrderData->order_number?></b><br>
          <b>Invoice Date:</b> <?= $OrderData->created?><br>
          <b>Payment Status:</b> <?= 'Panding' ?><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Vehicle Description</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
				<tr>
					<td>
						<?php 
						    $sub_charges = 0.00;
							$charges  = $OrderData->vehicle->charges;
							$sub_type = $OrderData->vehicle->sub_type;
							if($sub_type==1){
								$type = 'Per Km Charge';
							}
							else if($sub_type==2){
								$type = 'Per Hour Charge';
							}
							else{
								$type = 'Per Day Charge';
							}
							
							echo $OrderData->vehicle->name.' &nbsp; [ '.$type.' $ '.number_format($charges,2).' ] ';
							
							$sub_charges += $OrderData->vehcles_amount;
						?>
					</td>
					<td>$ <?= number_format($OrderData->vehcles_amount,2)  ?></td>
				</tr>
      <?php if(!empty($productd_charges)){ ?>
				<tr> <td> <strong><?php echo 'Food Products'; ?></strong> </td> <td></td> </tr> 
		<?php
				$pro_chrg = 0.00;
				foreach($productd_charges as $keys =>$proData){
	  ?>		
					<tr> 
						<td><?= ucfirst($proData->product->title)  ?></td>
						<td>$ <?= number_format($proData->amount,2)  ?></td>
					</tr>
					
	  <?php 	
					$pro_chrg += $proData->amount;
				} 	
					$sub_charges += $pro_chrg;
			}
	  ?>
	<?php   if(!empty($charge_additional)){ 
				$add_chrg = 0.00;
	?>
				<tr> <td> <strong><?php echo 'Additional Charges'; ?></strong> </td> <td></td> </tr> 
	<?php 			
				foreach($charge_additional as $keys =>$additionalData){ //pr($additionalData);
	  ?>		
					<tr> 
						<td><?= ucfirst($additionalData->additional_charge->title)  ?></td>
						<td>$ <?= number_format($additionalData->amount,2)  ?></td>
					</tr>
	  <?php 	
					$add_chrg += $additionalData->amount;
				}

				$sub_charges += $add_chrg;	
			}
	  ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
          <!--img src="../../dist/img/credit/visa.png" alt="Visa">
          <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="../../dist/img/credit/american-express.png" alt="American Express">
          <img src="../../dist/img/credit/paypal2.png" alt="Paypal"-->

        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead"></p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:42%">Subtotal :</th>
                <td>$ <?= number_format($sub_charges,2) ?></td>
              </tr>
			  
	  <?php if(!empty($charge_tax)){  
				foreach($charge_tax as $key =>$taxData){ //pr($taxData);
					$type = $taxData->tax->type; 
						if($type ==1){
							$tt = '%';
						}
						else{
							$tt = 'Fixed';
						}
		?>
					<tr>
						<th><?= ucfirst($taxData->tax->title).'  ( '.$taxData->tax->amount.' '.$tt.' )' ?></th>
						<td>$ <?= number_format($taxData->cal_tax,2)?></td>
					</tr>
	  <?php 	} 
			}	
	  ?>
              <tr>
                <th>Total:</th>
                <td>$ <?= number_format($OrderData->order_amount,2)?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <!--a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a-->
          <!--button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button-->
		  <button type="button" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Send Mail
          </button>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  <!-- /.content-wrapper -->