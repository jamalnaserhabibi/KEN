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
/////////cash removal////////////////////
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
////////////////////////////////
if ($_GET['cid']) {
    $cid = $_GET['cid'];
    $cname = $_GET['cname'];
    $cgender = $_GET['cgender'];
    $cgradeid = $_GET['cgradeid'];
    $clocation = $_GET['clocation'];
    $ccapacity = $_GET['ccapacity'];
    $ccreateyear = $_GET['ccreateyear'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updateclass.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Class</title>
</head>
<body>
<div class="../icons/maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="inputs">
            <!-- <center> -->
            <h4>Update Class</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <input value="<?php echo $cname ?>" class="ttt" type="ttt" name="cname"
                       placeholder="Class Name (only keyword, not grade fullname, Ex: A )"><br>
                <select class="ttt" name="cgender">
                    <?php
                    if ($cgender == "Male") {
                        echo '<option value="Male" >Male</option> ';
                        echo '<option value="Female" >Female</option> ';
                        echo '<option value="Undefined" >Undefined</option> ';
                    } elseif ($cgender == "Female") {
                        echo '<option value="Female" >Female</option> ';
                        echo '<option value="Male" >Male</option> ';
                        echo '<option value="Undefined" >Undefined</option> ';
                    } else {
                        echo '<option value="Undefined" >Undefined</option> ';
                        echo '<option value="Male" >Male</option> ';
                        echo '<option value="Female" >Female</option> ';
                    }
                    ?>
                </select><br>
                <select class="ttt" name="cgradeid" required="">
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select * from tblgrade";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            if ($row[1] == 1) {
                                echo '<option value="' . $row[0] . '">1st Grade</option>';
                                if ($row[1] == $cgradeid) echo '<option value="' . $row[0] . '" selected>1st Grade</option>';;
                            } elseif ($row[1] == 2) {
                                echo '<option value="' . $row[0] . '">2nd Grade</option>';
                                if ($row[1] == $cgradeid) echo '<option value="' . $row[0] . '" selected>2nd Grade</option>';;
                            } elseif ($row[1] == 3) {
                                echo '<option value="' . $row[0] . '">3rd Grade</option>';
                                if ($row[1] == $cgradeid) echo '<option value="' . $row[0] . '" selected>3rd Grade</option>';;
                            } elseif ($row[1] > 3) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'th Grade</option>';
                                if ($row[1] == $cgradeid) echo '<option value="' . $row[0] . '" selected>' . $row[1] . 'th Grade</option>';;
                            } else {
                                echo '<option value="' . $row[0] . '">' . $row[1] . ' </option>';
                                if ($row[1] == $cgradeid) echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';;
                            }
                        }
                    }
                    ?>
                </select><br>
                <input value="<?php echo $clocation ?>" class="ttt" type="text" required="" name="clocation"
                       placeholder="Class Location"><br>
                <input value="<?php echo $ccapacity ?>" class="ttt" type="number" required="" name="ccapacity"
                       placeholder="Class Capacity"><br>
                <input value="<?php echo $ccreateyear ?>"" class="ttt" type="text" name="cremark" placeholder="Class
                Year" onfocus="(this.type='date')" required=""><br>
                <?php
                if (isset($_POST['cname']) and isset($_POST['cgradeid'])) {
                    // checking existince of subject
                    require("connection.php");
                    try {
                        $cname = $_POST['cname'];
                        $cgradeid = $_POST['cgradeid'];
                        $cgender = $_POST['cgender'];
                        $ccreateyear = $_POST['cremark'];
                        $stmt = $connect->prepare("select * from tblclass where cname=:cname and cgradeid=:cgradeid and cgender=:cgender and ccreatedate =:ccreateyear");
                        $stmt->bindValue(':cid', $cid);
                        $stmt->bindValue(':cname', $cname);
                        $stmt->bindValue(':cgradeid', $cgradeid);
                        $stmt->bindValue(':cgender', $cgender);
                        $stmt->bindValue(':cgender', $cgender);
                        $stmt->bindValue(':cremark', $ccreateyear);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if ($stmt->rowCount() != 0) {
                        echo '<h6 style="color: red;">This Class Name is already exist!</h6>';
                    } else {
                        try {
                            if ($_POST['cname'] != "") {
                                if (isset($_POST['btn-submit'])) {
                                    try {
                                        $stmt = $connect->prepare("UPDATE `tblclass` SET `cname`=:cname,`cgender`=:cgender,`cgradeid`=:cgradeid,`clocation`=:clocation,`ccapacity`=:ccapacity,`ccreatedate`=:cremark WHERE cid=:cid");
                                        $stmt->bindValue(':cid', $cid);
                                        $stmt->bindValue(':cname', $cname);
                                        $stmt->bindValue(':cgender', $cgender);
                                        $stmt->bindValue(':cgradeid', $cgradeid);
                                        $stmt->bindValue(':clocation', $_POST['clocation']);
                                        $stmt->bindValue(':ccapacity', $_POST['ccapacity']);
                                        $stmt->bindValue(':cremark', $_POST['cremark']);
                                        $stmt->execute();
                                        // print_r($stmt);
                                        header("Location: class_list.php");
                                        // echo '<h6 style="color: blue;">Class Successfully Updated!</h6>';
                                    } catch (PDOException $e) {
                                        $e->getMessage();
                                    }
                                }
                            } else {
                                echo '<h6 style="color: red;">Any field Left Empty!</h6>';
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Update Class">
        <a href="class_list.php">Cancel</a>
        </form>
        <!-- </center>               -->
    </center>
</div>
</body>
</html>