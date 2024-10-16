<?php
session_start();
include("includes/header.php");
require '../model/DbConnector.php';
require 'classes/Admin.php';

// Instantiate the DbConnector class
$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());
?>

<div class="row">
    <div class="col-md-12">

        <?php if (isset($_SESSION['message'])) : ?>
            <h6 class="alert alert-success"><?= $_SESSION['message']; ?></h6>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>
                    Users List
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM user";

                        // Use the instance of DbConnector
                        $statement = $dbConnector->getConnection()->prepare($query);
                        $statement->execute();

                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        if ($result) {
                            foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?= $row['userid']; ?></td>
                                    <td><?= $row['firstname']; ?></td>
                                    <td><?= $row['lastname']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['phonenum']; ?></td>
                                    <td><?= $row['status'] == 1 ? 'Banned' : 'Active'; ?></td>
                                    <td>
                                        <a href="users-edit.php?id=<?= $row['userid']; ?>" style="background-color:#897062; color:white;" class="btn btn-sm" onclick="return confirm('Are you sure you want to ban this user?')">Ban user</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">No record found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>