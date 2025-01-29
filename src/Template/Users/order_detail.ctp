<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 no_padding">
                <div class="inr_bnr">
                    <div class="col-md-12 no_padding">
                        <div class="inr_bnr">
                            <?php
                            $image = WWW_ROOT . 'img' . DS . 'conact_us_banner.jpg';
                            if (file_exists($image)) {
                                echo $this->Html->image('/img/' . "conact_us_banner.jpg", ['alt' => "conact_us_banner"]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Cart Page Area Start-->
<section class="dshbrd">
    <div class="container">
        <div class="row">
            <?php echo $this->element('front/account_menu'); ?>

            <div class="col-sm-9 my-order account-main">
                <div class="about_status" style="padding: 20px;">
                    <strong>Payment Status : <?= ($OrderStatus->payment_status == 1) ? "Completed" : "Pending"; ?> </strong><br />
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-two" role="tabpanel" aria-labelledby="v-pills-two-tab">
                        <div class="table-responsive crt_tbl">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="headding-color">

                                        <th>Order ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Total Quantity</th>
                                        <th>Total Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($OrderDetail as $key => $value) {

                                    ?>
                                        <tr class="order-list">
                                            <td>
                                                <?= "#" . $value->order_id; ?>
                                            </td>
                                            <td>
                                                <a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'productView']) ?>/<?= base64_encode($value->product_sku); ?>">
                                                    <?php
                                                    $img_src = 'https://shrugs.com/rug_pictures/';

                                                    $img_no = str_replace("GOR", " ", $value->product_sku);
                                                    $img_name = "sh" . $img_no / 7;
                                                    $inFolder = $this->General->__get_picture_folder($img_name);


                                                    $imgName =  $img_name . " 001.jpg";

                                                    $fileUrl = $img_src . "overstock_rugs/" . $inFolder . "/" . $imgName;
                                                    $thumb_imgName =      $img_name . " 001.jpg";
                                                    $thumbArr = explode('_', $pimg['ProductImage']['image']);
                                                    $fileUrlThumb = $img_src . $inFolder . '/thumbs/thumb_' . $thumb_imgName;

                                                    if ($this->General->remote_file_exists($fileUrl)) {
                                                    ?>
                                                        <img src="<?php echo $fileUrl; ?>" alt="<?php echo $value->title; ?>" width="70" height="90" />

                                                    <?php } else {
                                                    ?>
                                                        <img src="<?php echo $this->General->getProductSingleImages($value->id)->image; ?>" alt="<?php echo $value->title; ?>" width="70" height="90" />
                                                    <?php
                                                    } ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'productView']) ?>/<?= base64_encode($value->product_sku); ?>"> <?= $value->product_name; ?></a>
                                            </td>
                                            <td>
                                                <?= $value->qty; ?>
                                            </td>
                                            <td>
                                                <?= "$" . $value->price; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
<!--Cart Page Area End-->