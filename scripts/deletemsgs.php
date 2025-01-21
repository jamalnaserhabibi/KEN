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
try {
    $query = "TRUNCATE messages";
    $result = $connect->query($query);
    if ($result) {
        header("Location: chatting.php");
    } else {
        echo 'Couldnt Delete!';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>