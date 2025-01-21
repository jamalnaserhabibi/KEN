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

$message = "";
if (isset($_POST['btn-submit'])) {
    require_once('connection.php');
    if (isset($_POST['stdgender'])) {
        $qqq = ('select * from tblstudent where  stdnationid=' . $_POST['stdnationid']);
        $q = $connect->prepare($qqq);
        $q->execute();
        if ($q->rowCount() == 0) {
            require("connection.php");
            try {
                $queryy = "INSERT INTO `tblstudent`(`stdfullname`, `stdfname`, `stdgfname`, `dstdfullname`, `dstdfname`, `dstdgfname`, `stdgender`, `stddob`, 
                `stdenrolid`, `stdenroldate`,`stdnationid`, `stdaddress`, `stdcontact`, `stdparentcontact`, `stdphoto`, `stdremark`)
                VALUES (:stdfullname,:stdfname,:stdgfname,:dstdfullname,:dstdfname,:dstdgfname,:stdgender,:stddob,:stdenrolid,:stdenroldate,
                :stdnationid,:stdaddress,:stdcontact,:stdparentcontact,:stdphoto,:stdremark)";
                $stmt = $connect->prepare($queryy);
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
                $stmt->bindValue(':stdphoto', 'temp');
                $stmt->bindValue(':stdremark', $_POST['stdremark']);
                $stmt->execute();
                $stdid = $connect->lastInsertId();
                $q_img_name = "UPDATE `tblstudent` SET `stdphoto`=" . $stdid . " WHERE stdid=" . $stdid;
                $q_img_name = $connect->prepare($q_img_name);
                $q_img_name->execute();
                $uimage = $_FILES['imageupload']['tmp_name'];
                move_uploaded_file($uimage, "../stdimages/" . $stdid);
//                    $message = '<h6 style="color:blue">' . $_POST['stdfullname'] . ' Successfully Saved!</h6>';
                header('location:enrolstudent.php?stdname=' . $_POST['stdfullname'] . '&&stdfname=' . $_POST['stdfname'] . '&&stdid=' . $stdid . '&&stdrootid=' . $_POST['stdenrolid'] . '');
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        } else {
            $message = '<h6 style="color:red">Student with This National ID Number is Already exist!</h6>';
        }
    } else {
        $message = '<h6 style="color:red">Please Select Student Gender!</h6>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/createstudent.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
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
            <h4>Add a new Student</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input class="inpt" type="text" name="stdfullname" maxlength="30" placeholder="Full Name"
                               required="">
                        <input class="inpt" type="text" name="stdfname" maxlength="30" placeholder="Father Name"
                               required="">
                        <input class="inpt" type="text" name="stdgfname" maxlength="30" placeholder="Grand Father Name"
                               required="">
                        <input class="inpt" type="text" name="dstdfullname" maxlength="30" placeholder="نام" required=""
                               style="text-align: right">
                        <input class="inpt" type="text" name="dstdfname" maxlength="30" placeholder="نام پدر"
                               required="" style="text-align: right">
                        <input class="inpt" type="text" name="dstdgfname" maxlength="30" placeholder="نام پدر کلان"
                               required="" style="text-align: right">
                        <select class="inpt" name="stdgender" required="">
                            <option value="" disabled selected hidden> Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <input class="inpt" type="text" name="stddob" placeholder="Date of birth"
                               onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 2">
                        <h6>Other Information</h6>
                        <input class="inpt" type="number" name="stdnationid" placeholder="Nation ID Number" required="">
                        <input class="inpt" type="number" name="stdenrolid" placeholder="Root ID Number" required="">
                        <input class="inpt" type="text" name="stdenroldate" placeholder="Enrol Date"
                               onfocus="(this.type='date')" required="">
                        <input class="inpt" type="text" name="stdaddress" maxlength="40" placeholder="Address"
                               required="">
                        <input class="inpt" type="number" name="stdcontact" min="100000000" max="1000000000"
                               placeholder="Contact" required="">
                        <input class="inpt" type="number" name="stdparentcontact" min="100000000" max="1000000000"
                               placeholder="Parent Contact" required="">
                        <textarea class="inpt note" maxlength="160" name="stdremark" cols="30" rows="10"
                                  placeholder="Note:"></textarea>
                    </div>
                    <div class="data 3">
                        <h6>Student Profile</h6>
                        <img style="height: 288px;width:288px; object-fit: cover; border-radius:10%" id="output"
                             src="../userimages/user.png" alt=""><br>
                        <input type="file" name="imageupload" required="" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                    </div>
                </div>
                <?php echo $message ?>
        </div>
        <input class="bbb" type="Submit" name="btn-submit" value="Create!">
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