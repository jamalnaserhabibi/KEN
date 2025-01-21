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
if (isset($_GET['classid'])) {
    $classid = $_GET['classid'];
    $subjectid = $_GET['subjectid'];
    $scoretype = $_GET['scoretype'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/insertresult_written.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserting Result</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Written and Practical Exam</h4>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <div>
                    <div class="contain">
                        <label>Student Name</label>
                        <input class="ttt" type="text" name="stdname" placeholder="All Students">
                    </div>

                    <div class="contain">
                        <label>Grade</label>
                        <select class="ttt" name="gname">
                            <option value="">All Grades</option>
                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select distinct gname from selectstdclass";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    if ($row[0] === '1') {
                                        echo '<option value=' . $row[0] . '>' . $row[0] . 'st ' . '</option>';
                                    } elseif ($row[0] === '2') {
                                        echo '<option value=' . $row[0] . '>' . $row[0] . 'nd ' . '</option>';
                                    } elseif ($row[0] === '3') {
                                        echo '<option value=' . $row[0] . '>' . $row[0] . 'rd ' . '</option>';
                                    } elseif ($row[0] === '0') {
//                                        echo '<option value='.$row[0].'>Change School Students</option>';
                                    } elseif ($row[0] > 3) {
                                        echo '<option value=' . $row[0] . '>' . $row[0] . 'th ' . '</option>';
                                    } else {
                                        echo '<option value=' . $row[0] . '>' . $row[0] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="contain">
                        <label>Class Name</label>
                        <select class="ttt" name="cname">
                            <option value="all except change school">All Except Change School</option>
                            <option value="">All Classes</option>
                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select distinct cname from selectstdclass";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    echo '<option>' . $row[0] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="contain">
                        <label>Student Root ID</label>
                        <input class="ttt" type="number" name="rootid" placeholder="All Students">
                    </div>

                    <div class="contain">
                        <label>Class Create Year</label>
                        <select class="ttt" name="cyear">
                            <option value="">All Years</option>
                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select distinct ccreatedate from selectstdclass";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            if (isset($result)) {
                                while ($row = $result->fetch()) {

                                    $date = date('Y');
                                    $year = explode('-', $row[0]);

                                    echo '<option';
                                    if ($date == $year[0]) {
                                        echo ' selected ';
                                    }
                                    echo ' value=' . $row[0] . '>' . $year[0] . '</option>';
                                }

                            }
                            ?>
                        </select>
                    </div>

                    <div class="contain">
                        <label>Gender</label>
                        <select class="ttt" name="cgender">
                            <option value="">All Genders</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Undefined</option>
                        </select>
                    </div>
                </div>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search">

            <?php
            if (isset($_POST['btn-submit'])) {
                try {
                    $stdname = $_POST['stdname'];
                    $rootid = $_POST['rootid'];
                    $cname = $_POST['cname'];
                    $cgender = $_POST['cgender'];
                    $gname = $_POST['gname'];
                    $cyear = $_POST['cyear'];
                    header('Location: stdclass_list.php?stdname=' . $stdname . '&&rootid=' . $rootid . '&&cname=' . $cname . '&&cgender=' . $cgender . '&&gname=' . $gname . '&&cyear=' . $cyear . '');
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

