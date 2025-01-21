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
if (isset($_GET['depid'])) {
    $did = $_GET['depid'];
    $dname = $_GET['depname'];
    $dcurri = $_GET['depcurri'];
    $dremarks = $_GET['depremarks'];
} else {
    echo 'Cant Get Data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatedepartment.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $dname ?></title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="inputs">
            <h4>Update Department</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <input value="<?php echo $dname ?>" class="ttt" type="text" name="depname" placeholder="Department Name"
                       required=""><br>
                <select name="depcurri" required="">
                    <option> <?php echo $dcurri ?></option>
                    <option>Cambridge</option>
                    <option>Maaref</option>
                    <option>Other</option>
                </select><br>
                <input value="<?php echo $dremarks ?>" class="ttt" type="ttt" name="depremarks"
                       placeholder="Describtion"><br>
                <?php
                try {
                    if (isset($_POST['btn-submit'])) {
                        if (isset($_POST['depcurri'])) {
                            try {
                                $query = "UPDATE `tbldepartment` SET `depname`=:depname, `depcurriculum`=:depcurri,`depremarks`=:depremarks  WHERE depid=" . $did . "";
                                $stm = $connect->prepare($query);
                                $stm->bindValue(":depname", $_POST["depname"]);
                                $stm->bindValue(":depcurri", $_POST["depcurri"]);
                                $stm->bindValue(":depremarks", $_POST["depremarks"]);
                                $stm->execute();
                                header("location: dep_list.php");
                            } catch (PDOException $e) {
                                $e->getMessage();
                            }
                        } else {
                            echo '<h6 style="color: red;">Select Department Curriculum</h6>';
                        }
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
                <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit"
                       value="Update Department"><br>

            </form>
        </div>
        <div class="controls">
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="dep_list.php">
                <button class="bbb">Department List</button>
            </a>
            <a href="">
                <button class="bbb">Delete Account</button>
            </a>
            <a href="login.php">
                <button class="bbb">Log Out</button>
            </a>
        </div>
    </center>
</div>
</body>
</html>