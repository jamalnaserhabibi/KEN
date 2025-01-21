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
if (isset($_POST['btn-submit'])) {
    try {
        $stdname = $_POST['stdname'];
        $rootid = $_POST['rootid'];
        $cname = $_POST['cname'];
        $cgender = $_POST['cgender'];
        $gname = $_POST['gname'];
        $cyear = $_POST['cyear'];
        $examtype = $_POST['examtype'];
        $scoreresult = $_POST['scoreresult'];
        $scoreresult2 = $_POST['scoreresult2'];
        header('Location: result_list.php?stdname=' . $stdname . '&&rootid=' . $rootid . '&&cname=' . $cname . '&&cgender=' . $cgender . '&&gname=' . $gname . '&&cyear=' . $cyear . '&&examtype=' . $examtype . '&&scoreresult=' . $scoreresult . '&&scoreresult2=' . $scoreresult2 . '');
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/resultsearch.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Search</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Khana-e-Noor Result's Bank!</h4>
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
                                $query = "select distinct gname from selectresult";
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
                                $query = "select distinct cname from selectresult";
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
                    <div class="contain">
                        <label>Exam Type</label>
                        <select class="ttt" name="examtype">
                            <option value="">All</option>
                            <option value="Med">Med</option>
                            <option value="Final">Final</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="contain">
                        <label>Student Root ID</label>
                        <input class="ttt" type="number" name="rootid" placeholder="All Students">
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
                    <div class="contain">
                        <label>Class Create Year</label>
                        <select class="ttt" name="cyear">
                            <option value="">All Years</option>
                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select distinct ccreatedate from selectresult";
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
                        <label>Results Range</label>
                        <div style="display: flex; flex-direction: row; padding: 0px ; margin: 0px;">
                            <input class="ttt score" type="number" max="100" step="1" min="0" name="scoreresult"
                                   value="0">
                            <h1 style="padding: 0px ; margin: -5px">   </h1>
                            <input class="ttt score" type="number" max="100" step="1" min="0" name="scoreresult2"
                                   value="100">
                        </div>
                    </div>
                </div>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search">
        </form>
</div>
</body>
</html>

