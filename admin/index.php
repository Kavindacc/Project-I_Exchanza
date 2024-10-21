<?php 
session_start();
require '../model/DbConnector.php';
require 'classes/Admin.php';
include("includes/header.php");

// Instantiate the Admin class
$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());
// Get counts from the database
$totalUsers = $admin->getTotalUsers();
$totalSales = $admin->getTotalSales();
$totalEnquiries = $admin->getTotalEnquiries();
$totalEarnings = $admin->getTotalStores();
?>
<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #4E3B30;">Dashboard Overview</h2>
    <div class="row text-white">
        <div class="col-md-6 mb-4">
            <div class="card" style="background: #B89A8D; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-body text-center">
                    <h5 class="card-title font-weight-bold">Total Users</h5>
                    <h2 class="font-weight-bolder mb-0"><?php echo $totalUsers; ?></h2>
                    <p class="card-text">Engaged Users</p>
                </div>
                <div class="card-footer" style="background: #A17C6C; border-radius: 0 0 15px 15px;">
                    <img src="../img/user1.png" alt="User Icon" style="width: 50px;">
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card" style="background: #D6B7A8; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-body text-center">
                    <h5 class="card-title font-weight-bold">Total Enquiries and Feedbacks</h5>
                    <h2 class="font-weight-bolder mb-0"><?php echo $totalEnquiries; ?></h2>
                    <p class="card-text">User Enquireies Received</p>
                </div>
                <div class="card-footer" style="background: #C99B88; border-radius: 0 0 15px 15px;">
                    <img src="../img/enquiry.png" alt="Feedback Icon" style="width: 50px;">
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card" style="background: #D6B7A8; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);"> <!-- Light brown color -->
                <div class="card-body text-center">
                    <h5 class="card-title font-weight-bold">Total Orders</h5>
                    <h2 class="font-weight-bolder mb-0"><?php echo $totalSales; ?></h2>
                    <p class="card-text">Orders Received</p>
                </div>
                <div class="card-footer" style="background: #A17C6C; border-radius: 0 0 15px 15px;">
                    <img src="../img/orders.png" alt="Sales Icon" style="width: 50px;">
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card" style="background: #B89A8D; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-body text-center">
                    <h5 class="card-title font-weight-bold">Total Stores</h5>
                    <h2 class="font-weight-bolder mb-0"><?php echo $totalEarnings; ?></h2>
                    <p class="card-text">Store Available</p>
                </div>
                <div class="card-footer" style="background: #A17C6C; border-radius: 0 0 15px 15px;">
                    <img src="../img/shop.png" alt="Earnings Icon" style="width: 50px;">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
