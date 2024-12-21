<?php use Cake\Routing\Router; ?>
<?php use Cake\Core\Configure;?>

<p>Dear <?=$user_info->billing_first_name." ".$user_info->billing_last_name ?></p>
<p>Thank you for purchasing on <a href="http://rugsnc.com/">www.rugsnc.com</a>. Here are the details of your order.</p>
<p>Order#: <?=$order_id?></p>
<!--p>Date: <?=$date; ?></p-->

<table class="m_-3166822651416627521MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="500" style="width:250.0pt" id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40276">
   <tbody>
      <tr style="height:.5pt" id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40274">
         <td width="62" valign="top" style="width:31.0pt;border:none;border-right:solid white 1.0pt;background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt">
            <div>
               <p class="MsoNormal"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">ID</span></b><u></u><u></u></p>
            </div>
         </td>
         <td width="80" valign="top" style="width:40.0pt;border:none;border-right:solid white 1.0pt;background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt" id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40284">
            <div id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40283">
               <p class="MsoNormal"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">Picture</span></b><u></u><u></u></p>
            </div>
         </td>
         <td width="102" valign="top" style="width:51.0pt;border:none;border-right:solid white 1.0pt;background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt">
            <div>
               <p class="MsoNormal"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">Product Name</span></b><u></u><u></u></p>
            </div>
         </td>
        
         <td width="50" nowrap="" valign="top" style="width:25.0pt;border:none;border-right:solid white 1.0pt;background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt" id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40282">
            <div id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40281">
               <p class="MsoNormal"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">Qty.</span></b><u></u><u></u></p>
            </div>
         </td>
         <td width="52" nowrap="" valign="top" style="width:26.0pt;border:none;border-right:solid white 1.0pt;background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt" id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40273">
            <div id="m_-3166822651416627521ydpd4265244yiv4647367218yui_3_16_0_ym19_1_1558676002541_40272">
               <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">Price</span></b><u></u><u></u></p>
            </div>
         </td>
         <td nowrap="" valign="top" style="background:#23201e;padding:2.0pt 2.0pt 2.0pt 2.0pt;height:.5pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:white">Amount</span></b><u></u><u></u></p>
            </div>
         </td>
      </tr>
     <?php
	 $ttl_qty = 0;
	 $i=1;
	 foreach($content as $key => $data){ ?>
      <tr>
         <td width="102" style="width:51.0pt;border:solid #23201e 1.0pt;border-top:none;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?=$i?></span><u></u><u></u></p>
            </div>
         </td>
         <td width="102" style="width:51.0pt;border:solid #23201e 1.0pt;border-top:none;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">
			   <?php 
								$img_src = 'https://shrugs.com/rug_pictures/';	
								
								$img_no = str_replace("GOR"," ",$data['sku_no'] );
								$img_name = "sh".$img_no/7;
								$inFolder = $this->General->__get_picture_folder($img_name);
								 
								$imgName =  $img_name." 001.jpg";
									 
								$fileUrl = $img_src."overstock_rugs/".$inFolder."/".$imgName;
								$fileUrl = str_replace(" ","%20",$fileUrl);
								$thumb_imgName =  	$img_name." 001.jpg";
								$thumbArr = explode('_',$pimg['ProductImage']['image']);	
								$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
								 
								if($this->General->remote_file_exists($fileUrl))
									{
								?> 
									<img src="<?php echo $fileUrl; ?>" alt="<?php echo $data['title']; ?>" style="height:100px;" />
								<?php }?>
			   </span><u></u><u></u></p>
            </div>
         </td>
         <td width="102" style="width:51.0pt;border:solid #23201e 1.0pt;border-top:none;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?= $data['title']?></span><u></u><u></u>
               </p>
            </div>
         </td>
        
         <td nowrap="" style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?= $data['product_qty']?></span><u></u><u></u></p>
            </div>
         </td>
         <td nowrap="" style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?="$".$data['selling_price'];?></span><u></u><u></u></p>
            </div>
         </td>
         <td nowrap="" style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?="$".$data['selling_price'];?> </span><u></u><u></u></p>
            </div>
         </td>
      </tr>
	 <?php
	 $ttl_qty += $data['product_qty'];
	 $sub_total += $data['selling_price'];
	 $i++;
	 } ?>
	 
      <tr>
         <td colspan="3" style="border:solid #23201e 1.0pt;border-top:none;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">Total Qty. : </span></b><u></u><u></u></p>
         </td>
         <td style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?=$ttl_qty;?></span><u></u><u></u></p>
         </td>
         <td style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">SubTotal</span></b><u></u><u></u></p>
         </td>
         <td nowrap="" style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?="$".$sub_total;?></span><u></u><u></u></p>
            </div>
         </td>
      </tr>
      
      <tr>
         <td colspan="5" style="border:solid #23201e 1.0pt;border-top:none;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <p class="MsoNormal" align="right" style="text-align:right"><b><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;">Total</span></b><u></u><u></u></p>
         </td>
         <td nowrap="" style="border-top:none;border-left:none;border-bottom:solid #23201e 1.0pt;border-right:solid #23201e 1.0pt;padding:2.0pt 2.0pt 2.0pt 2.0pt">
            <div>
               <p class="MsoNormal" align="right" style="text-align:right"><span style="font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;"><?="$".$sub_total;?></span><u></u><u></u></p>
            </div>
         </td>
      </tr>
   </tbody>
</table>
<p>If you have any questions, contact us at : <a href="mailto:info@rugsnc.com">info@rugsnc.com</a> </p>

<p>Thanks & Regards</p>
<p>Team, Rugsnc.</p>
		
		

