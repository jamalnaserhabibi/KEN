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
$msg = '';
if (isset($_POST['btn-submit'])) {
    if (isset($_POST['classid']) and isset($_POST['scoretype']) and isset($_POST['subjectid'])) {
        try {
            $classid = $_POST['classid'];
            $subjectid = $_POST['subjectid'];
            $scoretype = $_POST['scoretype'];
            $chance = $_POST['chance'];

            if ($scoretype == 1) {//written exam only
                header('Location: insertresult_written.php?classid=' . $classid . '&&subjectid=' . $subjectid . '&&chance=' . $chance . '&&scoretype=Mid Term');
            } elseif ($scoretype == 2) {//written and oral exam
                header('Location: insertresult_written_oral.php?classid=' . $classid . '&&subjectid=' . $subjectid . '&&chance=' . $chance . '&&scoretype=Mid Term');
            } elseif ($scoretype == 3) {//written and practical exam
                header('Location: insertresult_written_practical.php?classid=' . $classid . '&&subjectid=' . $subjectid . '&&chance=' . $chance . '&&scoretype=Mid Term');
            }

        } catch (PDOException $e) {
            $e->getMessage();
        }
    } else {
        $msg = '<h4> Please Select All Above Options</h4>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/entermedresultselect.css">
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
        <h4>Mark Entrance For Mid Term Examination</h4>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <h4 style="color: #f31a14">Attention!</h4>
                <div class="contain">
                    <?php
                    require_once("loginPHP.php");

                    date_default_timezone_set('Asia/kabul');
                    ?>
                    <label style="color: #008820;    margin: 10px;">Tracking Activation was Successful !</label>
                    <label style="color: #008820">Name: <?php echo strtoupper($_SESSION['thename']) ?>          
                        Date: <?php echo date("Y/m/d") ?>          Time: <?php echo date('h:i:s A') ?> </label>
                    <label style="color: #D93935">● Notice: Results are Sensitive data, Every single change will be
                        recorded for future inspection by Administrator! </label>
                </div>
                <div>

                    <div class="contain">
                        <label>Select Class</label>
                        <select class="ttt" name="classid" required="">
                            echo '
                            <option value="" disabled selected hidden>Select Class</option>
                            ';

                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select * from selectstdclass where gname !='0' group by cid order by ccreatedate desc ";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    $year = explode("-", $row[9]);
                                    if ($row['gname'] == 1) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'st ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] == 2) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'nd ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] == 3) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'rd ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] > 3) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'th ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } else {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . ' ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="contain">
                        <label>Select Subject</label>
                        <select class="ttt" name="subjectid" required="">
                            <option value="" disabled selected hidden>Select Subject</option>
                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select * from selectsubject";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    if ($row[3] == 1) {
                                        echo '<option value="' . $row[0] . ' ">' . $row[1] . ' - ' . $row[3] . 'st Grade</option>';
                                    } elseif ($row[3] == 2) {
                                        echo '<option value="' . $row[0] . ' ">' . $row[1] . ' - ' . $row[3] . 'nd Grade</option>';
                                    } elseif ($row[3] == 3) {
                                        echo '<option value="' . $row[0] . ' ">' . $row[1] . ' - ' . $row[3] . 'rd Grade</option>';
                                    } elseif ($row[3] > 3) {
                                        echo '<option value="' . $row[0] . ' ">' . $row[1] . ' - ' . $row[3] . 'th Grade</option>';
                                    } else {
                                        echo '<option value="' . $row[0] . '">' . $row[1] . ' - ' . $row[3] . 'Grade</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="contain">
                        <label>Select Score Type</label>
                        <select class="ttt" name="scoretype" required="">
                            <option value="" disabled selected hidden>Select Score Types</option>
                            <option value="1">Only Written Exam</option>
                            <option value="2">Written & Oral Exams</option>
                            <option value="3">Written & Practical Exams</option>
                        </select>
                    </div>
                    <div class="contain">
                        <label>Select Chance</label>
                        <select class="ttt" name="chance" required="">
                            <option value="1">First Chance</option>
                            <option value="2">Second Chance</option>
                            <option value="3">Third Chance</option>
                        </select>
                    </div>
                </div>
                <?php echo $msg ?>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Start !">
        </form>
</div>
</body>
</html>

