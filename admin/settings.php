<?php
ob_start();
session_start();
include("includes/header.php");
require '../model/DbConnector.php';
require 'classes/Admin.php';

$dbConnector = new DbConnector();
$admin = new Admin($dbConnector->getConnection());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $facebook_link = $_POST['facebook'];
    $instagram_link = $_POST['instagram'];
    $youtube_link = $_POST['youtube'];

    // Update the settings in the database
    $admin->updateSettings($email, $phone, $address, $facebook_link, $instagram_link, $youtube_link);

    // Set the session message to display on page reload
    $_SESSION['message'] = 'Settings saved successfully.';

    // Redirect to avoid form resubmission
    header("Location: settings.php");
    exit;
}

$settings = $admin->getSettings();

// Check if the query returned a valid result
if (!$settings) {
    $settings = [
        'email' => '',
        'phone' => '',
        'address' => '',
        'facebook_link' => '',
        'instagram_link' => '',
        'youtube_link' => ''
    ];
}

// Check if there's a session message to display
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Site Settings</h4>
            </div>

            <div class="card-body">
                <!-- Display success message if available with dismiss button -->
                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible" role="alert" style="position: relative;">
                        <?php echo $message; ?>
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($settings['email']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($settings['phone']) ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($settings['address']) ?></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Facebook Link</label>
                            <input type="text" name="facebook" class="form-control" value="<?= htmlspecialchars($settings['facebook_link']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Instagram Link</label>
                            <input type="text" name="instagram" class="form-control" value="<?= htmlspecialchars($settings['instagram_link']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>YouTube Link</label>
                            <input type="text" name="youtube" class="form-control" value="<?= htmlspecialchars($settings['youtube_link']) ?>">
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" style="background-color:#897062; color:white;" class="btn btn-sm">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php");
ob_end_flush();
?>