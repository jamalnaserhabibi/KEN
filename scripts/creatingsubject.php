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
    <link rel="stylesheet" href="../css/creatingsubject.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Subject</title>
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
            <h4>Create a new Subject</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <input class="ttt" type="text" name="subname" placeholder="Subject Name" required=""><br>
                <!-- filling select from department table -->
                <select name="subdepart" required="">
                    <option value="" disabled selected hidden>Select Related Department</option>
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select * from tbldepartment";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    }
                    ?>
                </select><br>
                <select name="subgradeid" required="">
                    <option value="" disabled selected hidden>Select Related Grade</option>
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
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'st Grade</option>';
                            } elseif ($row[1] == 2) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'nd Grade</option>';
                            } elseif ($row[1] == 3) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'rd Grade</option>';
                            } elseif ($row[1] > 3) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'th Grade</option>';
                            } else {
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                        }
                    }
                    ?>
                </select><br>
                <!-- fill end -->
                <input class="ttt" type="ttt" name="subremarks" placeholder="Describtion"><br>
                <?php
                if (isset($_POST['subname'])) { // checking existince of subject
                    require("connection.php");
                    try {
                        $subname = $_POST['subname'];
                        $stmt = $connect->prepare("SELECT `subname`FROM `tblsubject` WHERE  `subname`=:subname");
                        $stmt->bindValue(':subname', $subname);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if ($stmt->rowCount() != 0) {
                        echo '<h6 style="color: red;">' . $subname . ' is already exist!</h6>';
                    } else {
                        try {
                            if (isset($_POST['subdepart']) && isset($_POST['subgradeid'])) {
                                if (isset($_POST['btn-submit'])) {
                                    try {
                                        $query = "INSERT INTO `tblsubject`(`subname`, `subdepid`, `subgradeid`, `subremarks`) VALUES(:nam,:dep,:subgradeid,:rem)";
                                        $stm = $connect->prepare($query);
                                        $stm->bindValue(':nam', $subname);
                                        $stm->bindValue(':dep', $_POST['subdepart']);
                                        $stm->bindValue(':subgradeid', $_POST['subgradeid']);
                                        $stm->bindValue(':rem', $_POST['subremarks']);
                                        $stm->execute();
                                        header('location: subject_list.php');
                                        echo '<h6 style="color: blue;">' . $subname . ' Successfully Inserted!</h6>';
                                    } catch (PDOException $e) {
                                        $e->getMessage();
                                    }
                                }
                            } else {
                                echo '<h6 style="color: red;">Select Related Department or Grade </h6>';
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Create Subject"><br>

        </form>
        <!-- </center>               -->
        <div class="controls">
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="subject_list.php">
                <button class="bbb">Subject List</button>
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