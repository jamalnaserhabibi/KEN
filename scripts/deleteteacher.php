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
if (isset($_GET['tid'])) {
    $id = $_GET['tid'];
    $tname = $_GET['tname'];
    try {
        $query1 = "DELETE FROM `tblteacher` where tid=" . $id . "";
        $result1 = $connect->query($query1);
        $query = "DELETE FROM `tbluser` where username='" . $tname . "'";
        $result = $connect->query($query);
        if (file_exists("../teacherimages/$id")) {
            unlink("../teacherimages/$id");
        };
        header("Location: teacher_list.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo '<script type="text/javascript">Deletion Failed!</script>';
    }
}
