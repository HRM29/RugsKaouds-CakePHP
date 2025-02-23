<?php

use Cake\Routing\Router;

if (count($relatedProducts) > 0) {
?>
    <section class="ltst_arrvls">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Related Products</h2>
                    </div>
                    <div class="arrvls_slide owl-carousel owl-theme">
                        <?php
                        foreach ($relatedProducts as $productkeys => $productData) {
                            if (!empty($productData['product_images'])) {
                                $image_data = $productData['product_images'][0];
                                $imageURL = $image_data->image;
                            }
                        ?>
                            <div class="item">
                                <div class="arrvl_box">
                                    <a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($productData->sku_no)]); ?>">
                                        <?php
                                        $img_src = Router::url('/', true) . 'uploads/product/';

                                        $img_name = isset($productData->product_images[0]->image) ? $productData->product_images[0]->image : '';

                                        // $img_name = $data->sku_no."a.jpg";
                                        $img_name_a = substr($productData->sku_no, 3) . "a.jpg";

                                        $sku = $productData->sku_no;

                                        $inFolder = $this->General->__get_picture_folder($sku);


                                        $filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;
                                        $filePath_A =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name_a;
                                        //echo $filePath ; die(" Check point1");

                                        $filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'JPG', $img_name);

                                        $fileUrl = $img_src . $inFolder . "/" . $img_name;
                                        $fileUrl_A = $img_src . $inFolder . "/" . $img_name_a;

                                        $fileUr2l = $img_src . $inFolder . "/" . str_replace('jpg', 'JPG', $img_name);

                                        if ($img_name != '') {
                                        ?>
                                            <img src="<?php echo $img_name; ?>" alt="<?= $productData->title; ?>" width="400" />

                                        <?php } else { ?>
                                            <img src="<?php echo Router::url('/', true); ?>img/no-image.png" alt="<?php echo $productData->title; ?>" style="height:250px;" />
                                        <?php
                                        } ?>
                                    </a>
									<span class="sale">Sale!</span>
                                    <div class="arrvl_text">
                                        <h3><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($productData->sku_no)]); ?>" style="text-decoration: none; color: #000;"><?php echo $productData->style; ?></a></h3>
                                        <p><?= $productData->title; ?></p>
                                        <span>$<?php echo number_format($productData->selling_price, 2); ?></span>
                                        <span class="nw_price">$<?php echo number_format($productData->everyday_price, 2); ?></span>
                                        <div class="sku-container">
                                            <span class="sku-label">SKU:</span>
                                            <span class="sku-value"><?php echo $productData->sku_no; ?></span>
                                        </div>
                                        <?php
                                        if (in_array($productData->id, $cartItems)) {
                                        ?>
                                            <div class="pdocut-buton cart-button" data-id=<?php echo $productData->id; ?>>
                                                <a class="btn crt_btn cart-button" data-id=<?php echo $productData->id; ?> href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>"><i class="bi bi-bag-plus"></i> Added to Cart</a>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="pdocut-buton cart-button" data-id=<?php echo $productData->id; ?>>
                                                <a class="btn crt_btn cart-button" data-id=<?php echo $productData->id; ?> href="javascript:void(0);"><i class="bi bi-bag-plus"></i> Add to Cart</a>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
} ?>
<script>
    $('.arrvls_slide').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        navText: ['<?php echo $this->Html->image('prev.png', ['alt' => 'prev']); ?>', '<?php echo $this->Html->image('next.png', ['alt' => 'next']); ?>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
</script>