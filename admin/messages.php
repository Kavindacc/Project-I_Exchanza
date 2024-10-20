<?php
session_start();
ob_start(); 
include("includes/header.php");
require '../model/DbConnector.php';
require 'classes/Admin.php';

$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());
$enquiries = $admin->getEnquiries(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_enquiry'])) {
        
        $enquiry_id = $_POST['enquiry_id'];
        $admin->deleteEnquiry($enquiry_id);
        header("Location: messages.php");
        exit(); 
    } elseif (isset($_POST['update_status'])) {
        
        $enquiry_id = $_POST['enquiry_id'];
        $status = $_POST['status'];
        $admin->updateEnquiryStatus($enquiry_id, $status);
        header("Location: messages.php");
        exit(); 
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>User Enquiries</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enquiries as $enquiry) : ?>
                            <tr>
                                <td><?php echo $enquiry['id']; ?></td> 
                                <td><?php echo $enquiry['name']; ?></td>
                                <td><?php echo $enquiry['email']; ?></td>
                                <td><?php echo $enquiry['subject']; ?></td>
                                <td><?php echo $enquiry['status']; ?></td>
                                <td>
                                    <form method="post" style="display:inline-block;">
                                        <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>">
                                        <button type="submit" name="view_enquiry" class="btn btn-sm" style="background-color:#897062; color:white;">View</button>
                                    </form>
                                    <form method="post" style="display:inline-block;" onsubmit="return confirmDelete();">
                                        <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>">
                                        <button type="submit" name="delete_enquiry" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['view_enquiry'])) {
    $enquiry_id = $_POST['enquiry_id'];
    $enquiry = $admin->getEnquiryById($enquiry_id); 
?>
    <div class="modal fade" id="viewEnquiryModal" tabindex="-1" aria-labelledby="viewEnquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEnquiryModalLabel">View Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <?php echo $enquiry['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $enquiry['email']; ?></p>
                    <p><strong>Subject:</strong> <?php echo $enquiry['subject']; ?></p>
                    <p><strong>Message:</strong> <?php echo $enquiry['message']; ?></p>
                    
                    <form method="post">
                        <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>"> 
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="pending" <?php echo ($enquiry['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo ($enquiry['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <button type="submit" name="update_status" class="btn btn-success">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<?php include("includes/footer.php"); ?>


<script>
    // Confirm before deleting
    function confirmDelete() {
        return confirm("Are you sure you want to delete this enquiry?");
    }

    <?php if (isset($_POST['view_enquiry'])): ?>
        var myModal = new bootstrap.Modal(document.getElementById('viewEnquiryModal'), {});
        myModal.show();
    <?php endif; ?>
</script>
