<?php
include_once("authentication.php");
// check if user is logged in
user_logged_in();

// list of allowed users types
$allowed_users = [
    "Administrator",
    "Head Master",
    "Teacher",
    "Finance",
    "Human Resource",
    "Book Shop",
    "Transportation"
];
// check if users have access
user_type_is($allowed_users);
?>

<?php
/////////cash removal////////////////////
header("Cache-Control: no-stor, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
////////////////////////////////
?>


<?php
require_once("connection.php");
if (isset($_GET['stdclassid'])) {
    $id = $_GET['stdclassid'];
    try {
        $query = "DELETE FROM `tblstdclass` where stdclassid=" . $id . "";
        $result = $connect->query($query);
        if ($result) {
            header("Location: unenrloledstd.php");
        } else {
            echo '<h1 style="color: red;">Delete Failed!<br>This Student has referenced (Payment / Bank Bell or...).<br> A Student can be deleted when there is no related item!</h1>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo '<script type="text/javascript">Deletion Failed!</script>';
    }
} else {
    echo '<h1 style="color: red;">ID not Found</h1>';

}
?>