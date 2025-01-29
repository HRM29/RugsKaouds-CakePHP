<?php

use Cake\Routing\Router;

?>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

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
            <div class="col-md-9">
                <div class="about_status" style="padding: 20px;">
                    <strong>Total Orders : <?= count($totalOrders); ?> </strong><br />
                    <strong>Payment Status (Pending) : <?= count($PendingListing); ?> </strong><br />
                    <strong>Payment Status (Completed) : <?= count($CompleteListing); ?> </strong>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-two" role="tabpanel" aria-labelledby="v-pills-two-tab">
                        <div class="table-responsive crt_tbl">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Payment Status</th>
                                        <th>Total Price</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($OrderListing as $key => $value) {
                                    ?>
                                        <tr class="order-list" style="height: 50px;">
                                            <td>
                                                <?= "#" . $value->id; ?>
                                            </td>
                                            <td>
                                                <?php if ($value->payment_status == 1) {
                                                    echo "Completed";
                                                } else if ($value->payment_status == 2) {
                                                    echo "Cancelled";
                                                } else {
                                                    echo "Pending";
                                                }; ?>
                                            </td>
                                            <td>
                                                <?= "$" . $value->total_price; ?>
                                            </td>
                                            <td>
                                                <?= $value->created; ?>
                                            </td>
                                            <td>
                                                <?= $this->General->getOrderstatus($value->order_status) ?>
                                            </td>
                                            <td>
                                                <a href="<?= Router::url(['controller' => 'Users', 'action' => 'orderDetail', $value->id]); ?>" title="View Order">View More</a>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="shop-head shop-head-bottom">
                    <h2><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></h2>
                    <div class="shop-bottom-section">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?= $this->Paginator->first(('First')) ?>
                                <?= $this->Paginator->prev(('Previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(('Next')) ?>
                                <?= $this->Paginator->last(('Last')) ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Cart Page Area End-->