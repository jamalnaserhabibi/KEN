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
    $query = "SELECT * FROM `messages` order by `mid` desc limit 1";
    $result = $connect->query($query);
    if (isset($result)) {
        while ($row = $result->fetch()) {
            // echo "<nobr><h4 style='margin:0px 0px 0px 120px;color:gray';>".$row[1].": </h4></nobr>";
            echo "<img style='box-shadow: 1px 0px 20px 2px rgba(36, 36, 36, 0.281);height:60px;width:60px;object-fit: cover; border-radius: 50px;margin:-10px 0px -10px 10px' src=../userimages/" . $row[5] . " alt=''>";
            echo '<div style="height:32px;overflow:hidden;">';
            echo "<h5 style='line-height:20px;margin:11px 10px 0px 20px;color:black;text-align: left;font-family:arial;'>" . $row[2] . "</h5>";
            echo '</div>';
            echo "<nobr><h4 style='width:100px;margin:10px;color:gray;text-align:right;'> |" . $row[3] . "</h4></nobr>";
        }
    } else {
        echo 'Wrong info';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
