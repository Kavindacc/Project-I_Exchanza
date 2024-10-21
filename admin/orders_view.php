<?php
session_start();
include("includes/header.php");
require '../model/DbConnector.php';
require 'classes/Admin.php';

/*if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}*/

$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());
$orders = $admin->getOrders(); // Changed the variable name for clarity
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Orders</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Tracking Number</th>
                                
                                <th>Confirm Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['user_id']; ?></td>
                                    <td><?php echo $order['order_status'] == 1 ? 'Received' : 'Pending'; ?></td>
                                    <td><?php echo $order['order_date']; ?></td>
                                    <td><?php echo $order['trackingnum']; ?></td>
                                    
                                    <td><?php echo $order['confirm'] == 1 ? 'Confirmed' : 'Not Confirmed'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>