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
if (isset($_GET['stfid'])) {
    $stfid = $_GET['stfid'];
    $stfname = $_GET['stfname'];
    try {
        $query1 = "DELETE FROM `tblstaff` where stfid=" . $stfid . "";
        $result1 = $connect->query($query1);
        if (file_exists("../staffimages/$stfid")) {
            unlink("../staffimages/$stfid");
        };
        $query = "DELETE FROM `tbluser` where username='" . $stfname . "'";
        $result = $connect->query($query);
        header("Location: staff_list.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo '<script type="text/javascript">Deletion Failed!</script>';
    }
} else {
    echo '<h1 style="color: red;">ID not Found</h1>';

}
?>