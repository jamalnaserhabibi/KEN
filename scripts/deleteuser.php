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
if (isset($_GET['userid'])) {
    $id = $_GET['userid'];
    try {
        // TODO: parameters ???
        if ($_SESSION['Thid'] != $id) {
            $query = "DELETE FROM `tbluser` where userid=" . $id . "";
            $result = $connect->query($query);
            if (file_exists("../userimages/$id")) {
                unlink("../userimages/$id");
            };
            header("Location: user_list.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo '<script type="text/javascript">Deletion Failed!</script>';
    }
}
?>