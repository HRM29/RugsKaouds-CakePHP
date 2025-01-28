<?php

use Cake\Routing\Router;

?>
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
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-pills-one-tab" href="<?php echo Router::url('/', true); ?>users/myaccount">Dashboard</a>
                    <a class="nav-link active" id="v-pills-two-tab" href="<?php echo Router::url('/', true); ?>users/myorder">Orders</a>
                    <!-- <button class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-three" type="button" role="tab" aria-controls="v-pills-three" aria-selected="false">Download</button> -->
                    <a class="nav-link" id="v-pills-four-tab" href="<?php echo Router::url('/', true); ?>users/myorder">Address</a>
                    <!-- <button class="nav-link" id="v-pills-five-tab" data-bs-toggle="pill" data-bs-target="#v-pills-five" type="button" role="tab" aria-controls="v-pills-five" aria-selected="false">Payment Methods</button> -->
                    <!-- <button class="nav-link" id="v-pills-six-tab" >Account Details</button> -->
                    <a class="nav-link" id="v-pills-six-tab" href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a>
                    <a class="nav-link" id="v-pills-seven-tab" href="<?php echo Router::url('/', true); ?>users/wishlist">Wishlist</a>
                    <button class="nav-link" id="v-pills-eight-tab" href="<?php echo Router::url('/', true); ?>users/logout">Logout</button>
                </div>
            </div>
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
                                        <th>View More</th>
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
                                                <!-- <a href="<?= Router::url(['controller' => 'Users', 'action' => 'orderDetail', $value->id]); ?>" title="View Order">View More</a> -->
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