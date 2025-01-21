<?php
include_once("authentication.php");
// check if user is logged in
user_logged_in();

// list of allowed users types
$allowed_users = [
    "Administrator",
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
    <link rel="stylesheet" href="../css/signUp.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New User</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
            <span id="record-count"></span>
        </div>
        <h4>Create a new account</h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <input class="ttt" type="text" name="user" placeholder="User Name" required=""><br>
                <select name="usertype" id="utype" required="">
                    <option value="" disabled selected hidden>User Authority</option>
                    <option>Administrator</option>
                    <option>Head Master</option>
                    <option>Teacher</option>
                    <option>Finance</option>
                    <option>Human Resource</option>
                    <option>Book Shop</option>
                    <option>Transportation</option>
                </select><br>
                <input class="ttt" type="password" minlength="8" name="password" placeholder="Password" required=""><br>
                <input class="ttt" type="password" minlength="8" name="cpassword" placeholder="Confirm Password"
                       required=""><br>
                <input type="file" name="imageupload" required="" class="filebtn" accept=".jpg,.jpeg,.png"
                       onchange="loadFile(event)"><br>
                <img style="height: 250px;width:250px; object-fit: cover;" id="output" src="../userimages/user.png"
                     alt=""><br>
                <?php
                if (isset($_POST['user'])) {
                    require("connection.php");
                    try {
                        $usern = $_POST['user'];
                        $ustype = $_POST['usertype'];
                        $stmt = $connect->prepare("SELECT `username`, `usertype`FROM `tbluser` WHERE  `username`=:usern And `usertype` = :usertype");
                        $stmt->bindValue(':usern', $usern);
                        $stmt->bindValue(':usertype', $ustype);
                        $stmt->execute();
                        //check existence of data end...
                        if ($stmt->rowCount() == 0) {
                            try {
                                if ($ustype != "") {
                                    if ($_POST['password'] == $_POST['cpassword']) {
                                        if (isset($_POST['btn-submit'])) {
                                            try {
                                                $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

                                                $query = "insert into tbluser(username,userpassword,usertype,photo,createdate)values(:username,:password,:usertype,:photo,:date)";
                                                $stm = $connect->prepare($query);
                                                $stm->bindValue(":username", $_POST["user"]);
                                                $stm->bindValue(":password", $hashed_password);
                                                $stm->bindValue(":usertype", $_POST["usertype"]);
                                                $stm->bindValue(':photo', 'temp');
                                                $date = date("d/m/Y");
                                                $stm->bindValue(":date", $date);
                                                $stm->execute();
                                                $uid = $connect->lastInsertId();
                                                $q_img_name = "UPDATE `tbluser` SET `photo`=" . $uid . " WHERE userid=" . $uid;
                                                $q_img_name = $connect->prepare($q_img_name);
                                                $q_img_name->execute();
                                                $temp = $_FILES['imageupload']['tmp_name'];
                                                move_uploaded_file($temp, "../userimages/" . $uid);
                                                header("location: user_list.php");
                                            } catch (PDOException $e) {
                                                $e->getMessage();
                                            }
                                        }
                                    } else {
                                        echo "<img style='margin-top: -353px;height: 300px;' src='../icons/cross.png'>";
                                        echo '<h6 style="margin-left:13%;">Password Did not match!</h6>';
                                    }
                                } else {
                                    echo "  <img style='margin-top: -353px;height: 300px;' src='../icons/cross.png'>";
                                    echo '<h6 style="margin-left:13%;">Select User Authority!</h6>';
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }

                        } else {
                            echo "  <img style='margin-top: -353px;height: 300px;' src='../icons/cross.png'>";
                            echo '<h6 style="color: red;margin-left:13%;">This user is already registered!</h6>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Create"><br>
        </form>
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
<script> //load file-image to img tag
    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
</body>
</html>