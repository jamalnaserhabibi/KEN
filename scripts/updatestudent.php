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

if (isset($_GET['stdid'])) {
    $stdid = $_GET['stdid'];
    require_once("connection.php");
    try {
        $query = "select * from tblstudent where stdid=" . $stdid;
        $result = $connect->query($query);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    while ($row = $result->fetch()) {
        $stdfullname = $row['1'];
        $stdfname = $row['2'];
        $stdgfname = $row['3'];
        $dstdfullname = $row['4'];
        $dstdfname = $row['5'];
        $dstdgfname = $row['6'];
        $stdgender = $row['7'];
        $stddob = $row['8'];
        $stdenrolid = $row['9'];
        $stdenroldate = $row['10'];
        $stdnationid = $row['11'];
        $stdaddress = $row['12'];
        $stdcontact = $row['13'];
        $stdparentcontact = $row['14'];
        $stdphoto = $row['15'];
        $stdremark = $row['16'];
    }
}
?>
<?php
///update///
$message = "";
if (isset($_POST['btn-submit'])) {
    require_once('connection.php');
    $qqq = ('select * from tblstudent where  stdnationid=:stdnationid and stdid!=:stdid');
    $q = $connect->prepare($qqq);
    $q->bindValue(':stdnationid', $_POST['stdnationid']);
    $q->bindValue(':stdid', $stdid);
    $q->execute();
    if ($q->rowCount() == 0) {
        require("connection.php");
        try {
            $queryy = "UPDATE `tblstudent` SET `stdfullname`=:stdfullname,`stdfname`=:stdfname,`stdgfname`=:stdgfname,`dstdfullname`=:dstdfullname,`dstdfname`=:dstdfname,`dstdgfname`=:dstdgfname,
                `stdgender`=:stdgender,`stddob`=:stddob,`stdenrolid`=:stdenrolid,`stdenroldate`=:stdenroldate,`stdnationid`=:stdnationid,`stdaddress`=:stdaddress,`stdcontact`=:stdcontact,
                `stdparentcontact`=:stdparentcontact,`stdphoto`=:stdphoto,`stdremark`=:stdremark WHERE `stdid` =:stdid";
            $stmt = $connect->prepare($queryy);
            $stmt->bindValue(':stdid', $stdid);
            $stmt->bindValue(':stdfullname', $_POST['stdfullname']);
            $stmt->bindValue(':stdfname', $_POST['stdfname']);
            $stmt->bindValue(':stdgfname', $_POST['stdgfname']);
            $stmt->bindValue(':dstdfullname', $_POST['dstdfullname']);
            $stmt->bindValue(':dstdfname', $_POST['dstdfname']);
            $stmt->bindValue(':dstdgfname', $_POST['dstdgfname']);
            $stmt->bindValue(':stdgender', $_POST['stdgender']);
            $stmt->bindValue(':stddob', $_POST['stddob']);
            $stmt->bindValue(':stdenrolid', $_POST['stdenrolid']);
            $stmt->bindValue(':stdenroldate', $_POST['stdenroldate']);
            $stmt->bindValue(':stdnationid', $_POST['stdnationid']);
            $stmt->bindValue(':stdaddress', $_POST['stdaddress']);
            $stmt->bindValue(':stdcontact', $_POST['stdcontact']);
            $stmt->bindValue(':stdparentcontact', $_POST['stdparentcontact']);
            $stmt->bindValue(':stdphoto', $stdid);
            $stmt->bindValue(':stdremark', $_POST['stdremark']);
            $stmt->execute();

            if ($_FILES['imageupload']['tmp_name'] != "") {
                if (file_exists("../stdimages/$stdid")) {
                    unlink("../stdimages/$stdid");
                    $temp = $_FILES['imageupload']['tmp_name'];
                    move_uploaded_file($temp, "../stdimages/" . $stdid);
                };
            }
//                    $message = '<h6 style="color:blue">' . $_POST['stdfullname'] . ' Successfully Saved!</h6>';
            header("location:student_list.php");
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = '<h6 style="color:red">Student with ' . $_POST['stdnationid'] . ' National ID Number is Already exist!</h6>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatestudent.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update <?php echo $stdfullname ?></title>
</head>
<body>
<div class="maincontaner">
    <div style="text-align: center">
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="inputs">
            <h4>Update Student information</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input value="<?php echo $stdfullname ?>" class="inpt" type="text" name="stdfullname"
                               maxlength="30" placeholder="Full Name" required="">
                        <input value="<?php echo $stdfname ?>" class="inpt" type="text" name="stdfname" maxlength="30"
                               placeholder="Father Name" required="">
                        <input value="<?php echo $stdgfname ?>" class="inpt" type="text" name="stdgfname" maxlength="30"
                               placeholder="Grand Father Name" required="">
                        <input value="<?php echo $dstdfullname ?>" class="inpt" type="text" name="dstdfullname"
                               maxlength="30" placeholder="نام" required="" style="text-align: right">
                        <input value="<?php echo $dstdfname ?>" class="inpt" type="text" name="dstdfname" maxlength="30"
                               placeholder="نام پدر" required="" style="text-align: right">
                        <input value="<?php echo $dstdgfname ?>" class="inpt" type="text" name="dstdgfname"
                               maxlength="30" placeholder="نام پدر کلان" required="" style="text-align: right">
                        <select class="inpt" name="stdgender" required="">
                            <option>Male</option>
                            <option <?php if ($stdgender == 'Female') echo 'selected' ?>>Female</option>
                        </select>
                        <input value="<?php echo $stddob ?>" class="inpt" type="text" name="stddob"
                               placeholder="Date of birth" onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 2">
                        <h6>Other Information</h6>
                        <input value="<?php echo $stdnationid ?>" class="inpt" type="number" name="stdnationid"
                               placeholder="Nation ID Numner" required="">
                        <input value="<?php echo $stdenrolid ?>" class="inpt" type="number" name="stdenrolid"
                               placeholder="Root ID Numner" required="">
                        <input value="<?php echo $stdenroldate ?>" class="inpt" type="text" name="stdenroldate"
                               placeholder="Enrol Date" onfocus="(this.type='date')" required="">
                        <input value="<?php echo $stdaddress ?>" class="inpt" type="text" name="stdaddress"
                               maxlength="40" placeholder="Address" required="">
                        <input value="<?php echo $stdcontact ?>" class="inpt" type="number" name="stdcontact"
                               min="100000000" max="1000000000" placeholder="Contact" required="">
                        <input value="<?php echo $stdparentcontact ?>" class="inpt" type="number"
                               name="stdparentcontact" min="100000000" max="1000000000" placeholder="Parent Contact"
                               required="">
                        <textarea class="inpt note" maxlength="160" name="stdremark" cols="30" rows="10"
                                  placeholder="Note:"><?php echo $stdremark ?></textarea>
                    </div>
                    <div class="data 3">
                        <h6>Student Profile</h6>
                        <img style="height: 288px;width:288px; object-fit: cover; border-radius:10%" id="output"
                             src="../stdimages/<?php echo $stdphoto ?>" alt=""><br>
                        <input type="file" name="imageupload" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                    </div>
                </div>
                <?php echo $message ?>
        </div>
        <input class="bbb" type="Submit" name="btn-submit" value="Update!">
        </form>
    </div>
    <script>
        //load file-image to img tag
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
</div>
</body>

</html>