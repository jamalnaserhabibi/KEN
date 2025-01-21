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
if (isset($_GET['gid'])) {
    $gid = $_GET['gid'];
    $gname = $_GET['gname'];
    $gcapacity = $_GET['gcapacity'];
    $gremark = $_GET['gremark'];
} else {
    echo 'Cant get data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updategrade.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Grade</title>
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
            <!-- <center> -->
            <h4>Update Grade</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <select class="ttt" type="text" name="gname" required="">
                    <?php
                    if ($gname == 1) {
                        echo '<option value="';
                        echo $gname . '" >1st Grade</option>';
                    } elseif ($gname == 2) {
                        echo '<option value="';
                        echo $gname . '" >2nd Grade</option>';
                    } elseif ($gname == 3) {
                        echo '<option value="';
                        echo $gname . '" >3rd Grade</option>';
                    } elseif ($gname > 3) {
                        echo '<option value="';
                        echo $gname . '" >' . $gname . 'th Grade</option>';
                    } else {
                        echo '<option value="';
                        echo $gname . '" >' . $gname . '</option>';
                    }
                    ?>
                    <option value="K - 1">K - 1</option>
                    <option value="K - 2">K - 2</option>
                    <option value="K - 3">K - 3</option>
                    <option value="1">1st Grade</option>
                    <option value="2">2nd Grade</option>
                    <option value="3">3rd Grade</option>
                    <option value="4">4th Grade</option>
                    <option value="5">5th Grade</option>
                    <option value="6">6th Grade</option>
                    <option value="7">7th Grade</option>
                    <option value="8">8th Grade</option>
                    <option value="9">9th Grade</option>
                    <option value="10">10th Grade</option>
                    <option value="11">11th Grade</option>
                    <option value="12">12th Grade</option>
                </select><br>
                <input value="<?php echo $gcapacity ?>" class="ttt" type="ttt" name="gcapicity"
                       placeholder="Grade Capacity"><br>
                <input value="<?php echo $gremark ?>" class="ttt" min="100" max="100000" type="number" name="gfee"
                       placeholder="Grade Fee"><br>
                <?php
                if (isset($_POST['gname'])) { // checking existince of subject
                    require("connection.php");
                    try {
                        $gname = $_POST['gname'];
                        $stmt = $connect->prepare("SELECT `gname`FROM `tblgrade` WHERE  `gname`=:gname and gid!=:gid");
                        $stmt->bindValue(':gid', $_GET['gid']);
                        $stmt->bindValue(':gname', $gname);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if ($stmt->rowCount() != 0) {
                        echo '<h6 style="color: red;">' . $gname . ' Grade is already exist!</h6>';
                    } else {
                        try {
                            if (isset($_POST['btn-submit'])) {
                                try {
                                    $query = "UPDATE `tblgrade` SET `gname`=:gname,`gcapicity`=:gcapicity,`gfee`=:gfee WHERE gid =" . $gid . "";
                                    $stm = $connect->prepare($query);
                                    $stm->bindValue(':gname', $gname);
                                    $stm->bindValue(':gcapicity', $_POST['gcapicity']);
                                    $stm->bindValue(':gfee', $_POST['gfee']);
                                    $stm->execute();
                                    header('location: grade_list.php');
                                    // echo '<h6 style="color: blue;">'.$gname.' Successfully Updated!</h6>';
                                } catch (PDOException $e) {
                                    $e->getMessage();
                                }
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                ?>
                <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Update Grade"><br>
            </form>
            <!-- </center>               -->
        </div>
        <div class="controls">
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="grade_list.php">
                <button class="bbb">Grade List</button>
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