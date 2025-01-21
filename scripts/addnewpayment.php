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


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/addnewpayment.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Search</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Select Student Class</h4>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">

                <h3>Class Name</h3>
                <select class="ttt" name="cname">
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select cid, classname from selectstdclass where gname!='0' group by cid order by ccreatedate desc ";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            echo '<option value="' . $row[1] . '" >' . $row[1] . '</option>';
                        }
                    }
                    ?>
                </select>


            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search">

            <?php
            if (isset($_POST['btn-submit'])) {
                try {
                    $classid = $_POST['cname'];
                    header('Location: classsearchforpayment.php?cname=' . $classid . '');
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }
            ?>

        </form>
        <!-- </center>               -->
        <!--        <div class="controls">-->
        <!--            <a href="admindashboard.php">-->
        <!--                <button class="bbb">Dashboard</button>-->
        <!--            </a>-->
        <!--            <a href="subject_list.php">-->
        <!--                <button class="bbb">Subject List</button>-->
        <!--            </a>-->
        <!--            <a href="">-->
        <!--                <button class="bbb">Sample</button>-->
        <!--            </a>-->
        <!--            <a href="login.php">-->
        <!--                <button class="bbb">Log Out</button>-->
        <!--            </a>-->
        <!---->
        <!--        </div>-->
        <!--    </center>-->
</div>
</body>
</html>

