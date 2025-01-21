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
require('loginPHP.php');

try {
    $query = "SELECT * FROM `messages` order by `mid` desc";
    $result = $connect->query($query);
    if (isset($result)) {
        while ($row = $result->fetch()) {
            if ($_SESSION['thename'] == $row[1]) {
                echo '<div style="background-color: rgba(0, 0, 0, 0.048); border-radius: 20px; margin:10px 0px; display: flex;
                        flex-direction: row;">';
                echo "<img style='height:60px; border-radius: 20px;margin:5px' src=../userimages/" . $row[5] . " alt=''>";
                echo '<div style="display: flex;flex-direction: column;">';
                echo "<h5>" . $row[2] . "</h5>";
                if ($_SESSION['thename'] == $row[1]) {
                    echo "<h6 style='color:gray;padding-left:10px'><a class='lbtn' href=deletesinglemsg.php?msgid=" . $row[0] . ">Delete</a>" . $row[3] . " | " . $row[4] . "</h6>";
                } else {
                    echo "<h6 style='color:gray;padding-left:310px'> " . $row[3] . " | " . $row[4] . "</h6>";
                };
                echo "</div>";
                echo "</div>";
            } else {
                echo '<div style="background-color: rgba(0, 0, 0, 0.048); border-radius: 20px; margin:10px 0px; display: flex;
                        flex-direction: row-reverse;">';
                echo "<img style='height:60px;width:60px;object-fit:cover; border-radius: 20px;margin:5px' src=../userimages/" . $row[5] . " alt='User Deleted'>";
                //   echo "<h5>".$row[1].":</h5>";
                echo '<div style="display: flex;flex-direction: column;">';
                echo "<h5>" . $row[2] . "</h5>";
                if ($_SESSION['thename'] == $row[1]) {
                    echo "<h6 style='color:gray;padding-left:10px'><a class='lbtn' href=deletesinglemsg.php?msgid=" . $row[0] . ">Delete</a>" . $row[3] . " | " . $row[4] . "</h6>";
                } else {
                    echo "<h6 style='color:gray;padding-left:310px'> " . $row[3] . " | " . $row[4] . "</h6>";
                };
                echo "</div>";
                echo "</div>";
            }
        }
    } else {
        echo 'Wrong info';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<style>
    .lbtn {
        /* position: absolute; */
        color: red;
        padding: 5px 10px;
        border-radius: 10px;
        padding-right: 247px;
    }

    .lbtn:hover {
        text-decoration: none;
        color: black;
    }
</style>