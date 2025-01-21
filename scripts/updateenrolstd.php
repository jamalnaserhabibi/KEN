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
    $stdclassid = $_GET['stdclassid'];
    $stdname = $_GET['stdname'];
    $stdfname = $_GET['stdfname'];
    $stdid = $_GET['stdid'];
    $stdrootid = $_GET['stdrootid'];
    $stdclass = $_GET['stdclass'];
    $stdclassremark = $_GET['stdclassremark'];
    $classname = $_GET['classname'];

} else {
    echo "Couldnt get Data";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updateenrolstd.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $stdname ?> Class</title>
</head>
<body>
<script type="text/javascript">
    function delete_id(id) //delete confirmatation
    {
        if (confirm('Do you want to delete (' + id + ') id?')) {
            window.location.href = 'deletestdclass.php?stdclassid=' + id;
        }
    }
</script>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4 class="headtitle">Update <?php echo $stdname ?> Class</h4>
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
                            echo '<option value="' . $row['classname'] . '" ';
                            if ($row['classname'] == $classname) {
                                echo 'disabled selected hidden';
                            }
                            echo '>' . $row['classname'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <!-- fill end -->
                <input class="ttt des" value="<?php echo $stdclassremark ?>" name="stdremark" type="text"
                       placeholder="Describtion" maxlength="50">

            </div>
        </div>

        <?php
        try {
            if (isset($_POST['classname'])) {
                if (isset($_POST['btn-submit'])) {
                    try {
                        $query = 'UPDATE `tblstdclass` SET `classid`=:classid,`stdclasspromotiondate`=:stdclasspromotiondate,`stdclassremark`=:stdclassremark WHERE stdclassid=:stdclassid';
                        $stm = $connect->prepare($query);
                        $date = date("Y-m-d");
                        $stm->bindValue(':stdclassid', $stdclassid);
                        $stm->bindValue(':classid', $_POST['classname']);
                        $stm->bindValue(':stdclasspromotiondate', $date);
                        $stm->bindValue(':stdclassremark', $_POST['stdremark']);
                        $stm->execute();
                        header('location: stdclasssearch.php');
                    } catch (PDOException $e) {
                        $e->getMessage();
                    }
                }
            } else {
                echo '<h6 style="color: red; ">Select Class to be Update!</h6>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
        <div style="display: flex; justify-content: center; align-items: center">
            <input style="width:500px;height: 50px" class="bbb signin" type="submit" name="btn-submit"
                   value="Update!"><br>
            <a style="width:500px;height: 50px; text-decoration:none" class="bbb"
               href="javascript:delete_id(<?php echo $stdclassid ?>)">Delete</a>
        </div>
        </form>
        <!-- </center>               -->
        <div class="controls">
            <a href="unenrloledstd.php">
                <button class="bbb">Student Out Of Class</button>
            </a>
            <button class="bbb" onclick="window.history.back()"> < Back</button>

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