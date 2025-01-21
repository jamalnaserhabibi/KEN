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
if (isset($_GET['stdname'])) {
    $stdname = $_GET['stdname'];
    $stdfname = $_GET['stdfname'];
    $stdid = $_GET['stdid'];
    $stdrootid = $_GET['stdrootid'];
} else {
    echo "Couldnt get Data";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/enrolstudent.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrol <?php echo $stdname ?></title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Select Class to Enrol <?php echo $stdname ?> </h4>
        <div class="inputs">
            <div>
                <form method="post" action="" enctype="multipart/form-data">
                    <input class="ttt filled" disabled="" type="text" value="<?php echo 'ID:           ' . $stdid ?>">
                    <input class="ttt filled" disabled="" type="text" value="<?php echo 'Root ID   ' . $stdrootid ?>">
                    <input class="ttt filled" disabled="" type="text" value="<?php echo 'Name:    ' . $stdname ?>">
                    <input class="ttt filled" disabled="" type="text" value="<?php echo 'F/Name: ' . $stdfname ?>">

            </div>
            <div><img src="../stdimages/<?php echo $stdid ?>" alt=""></div>
            <div>
                <!-- filling select from class table -->
                <select class="ttt" name="classname" required="">
                    <option value="" disabled selected hidden>Select Class</option>
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select * from selectclass order by gname";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            $year = explode("-", $row[6]);
                            if ($row[3] == 1) {
                                echo '<option value="' . $row[0] . '">' . $row[3] . 'st ' . $row[1] . ' - ' . $row[2] . ' - ' . $year[0] . '</option>';
                            } elseif ($row[3] == 2) {
                                echo '<option value="' . $row[0] . '">' . $row[3] . 'nd ' . $row[1] . ' - ' . $row[2] . ' - ' . $year[0] . '</option>';
                            } elseif ($row[3] == 3) {
                                echo '<option value="' . $row[0] . '">' . $row[3] . 'rd ' . $row[1] . ' - ' . $row[2] . ' - ' . $year[0] . '</option>';
                            } elseif ($row[3] > 3) {
                                echo '<option value="' . $row[0] . '">' . $row[3] . 'th ' . $row[1] . ' - ' . $row[2] . ' - ' . $year[0] . '</option>';
                            } else {
                                echo '<option value="' . $row[0] . '">' . $row[3] . ' ' . $row[1] . ' - ' . $row[2] . ' - ' . $year[0] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <!-- fill end -->
                <input class="ttt des" name="stdremark" type="text" placeholder="Describtion" maxlength="50">


            </div>
        </div>

        <?php
        try {
            if (isset($_POST['classname'])) {
                if (isset($_POST['btn-submit'])) {
                    try {
                        $query = "INSERT INTO `tblstdclass`(`stdid`,`classid`,`stdclassenroldate`,stdclasspromotiondate,`stdclassremark`) VALUES(:stdid,:classid,:stdclassenroldate,:stdclasspromotiondate,:stdclassremark)";
                        $stm = $connect->prepare($query);
                        $date = date("Y-m-d");
                        $stm->bindValue(':stdid', $stdid);
                        $stm->bindValue(':classid', $_POST['classname']);
                        $stm->bindValue(':stdclassenroldate', $date);
                        $stm->bindValue(':stdclasspromotiondate', $date);
                        $stm->bindValue(':stdclassremark', $_POST['stdremark']);
                        $stm->execute();
                        header('location: student_list.php');
                    } catch (PDOException $e) {
                        $e->getMessage();
                    }
                }
            } else {
                echo '<h6 style="color: red;">Select Class to be Enroled!</h6>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>

        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Enrol!"><br>
        </form>
        <!-- </center>               -->
        <div class="controls">
            <a href="unenrloledstd.php">
                <button class="bbb">< Back</button>
            </a>
            <a href="stdclasssearch.php">
                <button class="bbb">Student Class</button>
            </a>
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="student_list.php">
                <button class="bbb">All Students</button>
            </a>

        </div>
    </center>
</div>
</body>
</html>