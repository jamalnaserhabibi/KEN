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
    <link rel="stylesheet" href="../css/createclass.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
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
            <h4>Create a new Class</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <input class="ttt" type="ttt" name="cname"
                       placeholder=" Name (only keyword, not grade fullname, Ex: A )"><br>
                <select class="ttt" name="cgender" required="">
                    <option value="" disabled selected hidden>Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Undefined">Undefined</option>
                </select><br>
                <select class="ttt" name="cgradeid" required="">
                    <option values="" disabled selected hidden>Select Related Grade</option>
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select * from tblgrade where gname !=0";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            if ($row[1] == 1) {
                                echo '<option value="';
                                echo $row[0] . '" >1st Grade</option>';
                            } elseif ($row[1] == 2) {
                                echo '<option value="';
                                echo $row[0] . '" >2nd Grade</option>';
                            } elseif ($row[1] == 3) {
                                echo '<option value="';
                                echo $row[0] . '" >3rd Grade</option>';
                            } elseif ($row[1] > 3) {
                                echo '<option value="';
                                echo $row[0] . '" >' . $row[1] . 'th Grade</option>';
                            } else {
                                echo '<option value="';
                                echo $row[0] . '" >' . $row[1] . '</option>';
                            }
                        }
                    }
                    ?>
                </select><br>
                <input class="ttt" type="text" required="" name="clocation" placeholder=" Location"><br>
                <input class="ttt" type="number" max="100" min="5" required="" name="ccapacity" required=""
                       placeholder=" Capacity"><br>
                <input class="ttt" type="text" name="cremark" placeholder="Class Year" onfocus="(this.type='date')"
                       required=""><br>
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
                        $stmt->bindValue(':cname', $cname);
                        $stmt->bindValue(':cgradeid', $cgradeid);
                        $stmt->bindValue(':cgender', $cgender);
                        $stmt->bindValue(':ccreateyear', $ccreateyear);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if ($stmt->rowCount() != 0) {
                        echo '<h6 style="color: red;">This Class is already exist!</h6>';
                    } else {
                        try {
                            if ($_POST['cname'] != "") {
                                if (isset($_POST['btn-submit'])) {
                                    try {
                                        $stmt = $connect->prepare("INSERT INTO `tblclass` (`cname`, `cgender`, `cgradeid`,clocation,ccapacity, ccreatedate) VALUES (:cname,:cgender,:cgradeid,:clocation,:ccapacity,:cremark)");
                                        $stmt->bindValue(':cname', $cname);
                                        $stmt->bindValue(':cgender', $cgender);
                                        $stmt->bindValue(':cgradeid', $cgradeid);
                                        $stmt->bindValue(':clocation', $_POST['clocation']);
                                        $stmt->bindValue(':ccapacity', $_POST['ccapacity']);
                                        $stmt->bindValue(':cremark', $ccreateyear);
                                        $stmt->execute();
                                        header("Location: class_list.php");
//                               echo '<h6 style="color: blue;">Class Successfully Inserted!</h6>';
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
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Create Class"><br>
        </form>
        <!-- </center>               -->
        <div class="controls">
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="class_list.php">
                <button class="bbb">Class List</button>
            </a>
            <a href="">
                <button class="bbb">Sample</button>
            </a>
            <a href="login.php">
                <button class="bbb">Log Out</button>
            </a>

        </div>
    </center>
</div>
</body>
</html>