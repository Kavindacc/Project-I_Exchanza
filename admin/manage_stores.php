<?php
session_start();
require '../model/DbConnector.php';
require 'classes/Admin.php';
include("includes/header.php");

/*if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}*/
$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());
$sellers = $admin->getSellers();
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <h4>Manage Stores</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        <th>Userid</th>
                        <th>Store Id</th>
                        <th>Store Name</th>
                        <th>Created date and time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sellers as $seller) : ?>
                        <tr>
                            <td><?php echo $seller['user_id']; ?></td>
                            <td><?php echo $seller['store_id']; ?></td>
                            <td><?php echo $seller['store_name']; ?></td>
                            <td><?php echo $seller['created_at']; ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>