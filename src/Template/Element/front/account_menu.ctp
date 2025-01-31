<?php

use Cake\Routing\Router;

$session = $this->request->getSession();
$session = $this->request->getSession();
$cardData = $session->read('cart');
if (empty($cardData)) {
    $cart_count = 0;
} else {
    $cart_count = count($cardData);
}
$authUser = $session->read('Auth');
$action = $this->request->getParam('action');
$slug = $this->request->getParam('slug');
$controller = $this->request->getParam('controller');
?>
<div class="col-md-3">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link<?= $action == 'myaccount' ? ' active' : '' ?>" id="v-pills-one-tab" href="<?php echo Router::url('/', true); ?>users/myaccount">Dashboard</a>
        <a class="nav-link<?= $action == 'myorder' || $action == 'orderDetail' ? ' active' : '' ?>" id="v-pills-two-tab" href="<?php echo Router::url('/', true); ?>users/myorder">Orders</a>
        <!-- <button class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-three" type="button" role="tab" aria-controls="v-pills-three" aria-selected="false">Download</button> -->
        <a class="nav-link<?= $action == 'myaccountDetails' ? ' active' : '' ?>" id="v-pills-four-tab" href="<?php echo Router::url('/', true); ?>users/myaccount_details">Address</a>
        <!-- <button class="nav-link" id="v-pills-five-tab" data-bs-toggle="pill" data-bs-target="#v-pills-five" type="button" role="tab" aria-controls="v-pills-five" aria-selected="false">Payment Methods</button> -->
        <!-- <button class="nav-link" id="v-pills-six-tab" >Account Details</button> -->
        <a class="nav-link<?= $action == 'changepassword' ? ' active' : '' ?>" id="v-pills-six-tab" href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a>
        <a class="nav-link<?= $action == 'wishlist' ? ' active' : '' ?>" id="v-pills-seven-tab" href="<?php echo Router::url('/', true); ?>users/wishlist">Wishlist</a>
        <button class="nav-link" id="logoutButton" href="<?php //echo Router::url('/', true); 
                                                            ?>users/logout">Logout</button>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #881C06; color: white;">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#logoutButton').on('click', function() {
            $('#logoutModal').modal('show');
        });
    });
</script>