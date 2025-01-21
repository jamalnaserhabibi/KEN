<?php
// TODO: think about user account update and password recovery
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
require_once('connection.php');
if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    $uuname = $_GET['uuname'];
    $uupassword = $_GET['uupassword'];
    $uuauthority = $_GET['uuauthority'];
    $uuphoto = $_GET['uuphoto'];
} else {
    echo 'Cant get data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatesignup.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $uuname ?></title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Create a new account</h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <input value="<?php echo $uuname ?>" class="ttt" type="text" name="user" placeholder="User Name"
                       required=""><br>
                <select name="usertype" id="utype" required="">
                    <option><?php echo $uuauthority ?></option>
                    <option>Administrator</option>
                    <option>Head Master</option>
                    <option>Finance</option>
                    <option>Human Resource</option>
                    <option>Book Shop</option>
                </select><br>
                <input class="ttt" type="password" minlength="8" name="password" placeholder="Password" required=""><br>
                <input class="ttt" type="password" minlength="8" name="cpassword" placeholder="Confirm Password"
                       required=""><br>
                <input type="file" name="imageupload" class="filebtn" accept=".jpg,.jpeg,.png"
                       onchange="loadFile(event)"><br>
                <img style="height: 250px;width:250px; object-fit: cover;" id="output"
                     src="../userimages/<?php echo $uuphoto ?>" alt=""><br>
                <?php
                try {
                    if (isset($_POST['btn-submit'])) {
                        if ($_POST["usertype"] != "") {
                            if ($_POST['password'] == $_POST['cpassword']) {
                                try {

 $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

                                    $query = "UPDATE `tbluser` SET `username`=:username,`userpassword`=:password,`usertype`=:usertype,`photo`=:photo,`createdate`=:date WHERE userid=" . $uuid . "";
                                    $stm = $connect->prepare($query);
                                    $stm->bindValue(":username", $_POST["user"]);
                                    $stm->bindValue(":password", $hashed_password);
                                    $stm->bindValue(":usertype", $_POST["usertype"]);
                                    $stm->bindValue(':photo', 'temp');
                                    $date = date("d/m/Y");
                                    $stm->bindValue(":date", $date);
                                    $stm->execute();
                                    // $uid = $connect->lastInsertId();
                                    $q_img_name = "UPDATE `tbluser` SET `photo`=" . $uuid . " WHERE userid=" . $uuid;
                                    $q_img_name = $connect->prepare($q_img_name);
                                    $q_img_name->execute();
                                    // echo '<script>alert('.$_POST['imageupload'].')</script>';
                                    if ($_FILES['imageupload']['tmp_name'] != "") {
                                        if (file_exists("../userimages/$uuid")) {
                                            unlink("../userimages/$uuid");
                                            $temp = $_FILES['imageupload']['tmp_name'];
                                            move_uploaded_file($temp, "../userimages/" . $uuid);
                                        };
                                    }
                                    if ($_SESSION['Thid'] == $uuid) {
                                        header("Location: logout.php");
                                    } else {
                                        header("location: user_list.php");
                                    }
                                } catch (PDOException $e) {
                                    $e->getMessage();
                                }
                            } else {
                                echo '<h6 style="margin-left:13%;">Password Did not match!</h6>';
                            }
                        } else {
                            echo '<h6 style="margin-left:13%;">Select User Authority!</h6>';
                        }
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Update"><br>
        </form>
        <script> //load file-image to img tag
            var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };
        </script>

        <div class="controls">
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="user_list.php">
                <button class="bbb">User Accounts</button>
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