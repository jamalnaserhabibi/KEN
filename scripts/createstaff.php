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
    if (isset($_POST['stfgender']) && isset($_POST['stfcontractionduration']) && isset($_POST['stfeducation']) && isset($_POST['stffaculty']) && isset($_POST['stfusertype'])) {
        $qqq = ('select * from tblstaff where stfnationid=' . $_POST['stfnationid']);
        $q = $connect->prepare($qqq);
        $q->execute();
        if ($q->rowCount() == 0) {
            require("connection.php");
            try {
                $queryy = "INSERT INTO `tblstaff`(`stffullname`, `stffname`, `stfgender`, `stfdob`, `stfcontractionduration`,
                   `stfcontractiondate`, `stfsalary`, `stfdegree`, `stffaculty`, `stfgratuateyear`, `stfuniversity`, `stfposition`,
                   `stfaddress`, `stfcontact`, `stfnationid`, `stfphoto`, `stfremark`, `stfemail`)
                   VALUES (:stffullname,:stffname,:stfgender,:stfdob,:stfcontractionduration,:stfcontractdate,:stfsalary,:stfeducation,:stffaculty,
                   :stfgratuateyear,:stfuniversity,:stfposition,:stfaddress,:stfcontact,:stfnationid,:stfphoto,:stfremarks,:stfemail)";
                $stmt = $connect->prepare($queryy);
                $stmt->bindValue(':stffullname', $_POST['stffullname']);
                $stmt->bindValue(':stffname', $_POST['stffname']);
                $stmt->bindValue(':stfgender', $_POST['stfgender']);
                $stmt->bindValue(':stfdob', $_POST['stfdob']);
                $stmt->bindValue(':stfaddress', $_POST['stfaddress']);
                $stmt->bindValue(':stfcontact', $_POST['stfcontact']);
                $stmt->bindValue(':stfemail', $_POST['stfemail']);
                $stmt->bindValue(':stfnationid', $_POST['stfnationid']);
                $stmt->bindValue(':stfcontractionduration', $_POST['stfcontractionduration']);
                $stmt->bindValue(':stfcontractdate', $_POST['stfcontractdate']);
                $stmt->bindValue(':stfsalary', $_POST['stfsalary']);
                $stmt->bindValue(':stfposition', $_POST['stfposition']);
                $stmt->bindValue(':stfeducation', $_POST['stfeducation']);
                $stmt->bindValue(':stfgratuateyear', $_POST['stfgratuateyear']);
                $stmt->bindValue(':stfuniversity', $_POST['stfuniversity']);
                $stmt->bindValue(':stffaculty', $_POST['stffaculty']);
                $stmt->bindValue(':stfphoto', 'temp');
                $stmt->bindValue(':stfremarks', $_POST['stfremarks']);
                $stmt->execute();
                $stfid = $connect->lastInsertId();
                $q_img_name = "UPDATE `tblstaff` SET `stfphoto`=" . $stfid . " WHERE stfid=" . $stfid;
                $q_img_name = $connect->prepare($q_img_name);
                $q_img_name->execute();
                $img = $_FILES['imageupload']['tmp_name'];
                copy($img, "../staffimages/" . $stfid);
                //user creation//
                $query = "insert into tbluser(username,userpassword,usertype,photo,createdate)values(:username,:password,:usertype,:photo,:date)";
                $stm = $connect->prepare($query);
                $stm->bindValue(":username", $_POST["stffullname"]);
                $stm->bindValue(":password", $_POST["stfcontact"]);
                $stm->bindValue(":usertype", $_POST["stfusertype"]);
                $stm->bindValue(':photo', 'temp');
                $date = date("d/m/Y");
                $stm->bindValue(":date", $date);
                $stm->execute();
                $uid = $connect->lastInsertId();
                $q_img_name1 = "UPDATE `tbluser` SET `photo`=" . $uid . " WHERE userid=" . $uid;
                $q_img_name1 = $connect->prepare($q_img_name1);
                $q_img_name1->execute();
                $uimage = $_FILES['imageupload']['tmp_name'];
                move_uploaded_file($uimage, "../userimages/" . $uid);
                //
                header("location:staff_list.php");
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        } else {
            $message = '<h6 style="color:red">Teacher ' . $_POST['stffullname'] . ' F/N ' . $_POST['stffname'] . ' is Already exist!</h6>';
        }
    } else {
        $message = '<h6 style="color:red">Some Fields may left empty!</h6>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/createstaff.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire A New Employee Form</title>
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
            <h4>Hire A New Employee</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input class="inpt" type="text" name="stffullname" maxlength="30" placeholder="Full Name"
                               required="">
                        <input class="inpt" type="text" name="stffname" maxlength="30" placeholder="Father Name"
                               required="">
                        <select class="inpt" name="stfgender" required="">
                            <option value="" disabled selected hidden> Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <input class="inpt" type="text" name="stfdob" placeholder="Date of birth"
                               onfocus="(this.type='date')" required="">
                        <input class="inpt" type="text" name="stfaddress" maxlength="40" placeholder="Address"
                               required="">
                        <input class="inpt" type="number" name="stfcontact" min="99999999" max="999999999999999"
                               placeholder="Contact" required="">
                        <input class="inpt" type="Email" name="stfemail" maxlength="50" placeholder="Email">
                        <input class="inpt" type="number" name="stfnationid" min="99999"
                               max="999999999999999999999999999999" placeholder="National ID number" required="">
                    </div>
                    <div class="data 2">
                        <h6>Contraction Information</h6>
                        <select class="inpt" name="stfcontractionduration" required="">
                            <option value="" disabled selected hidden>Select Contraction Duration</option>
                            <option value="2">2 Months</option>
                            <option value="3">3 Months</option>
                            <option value="4">4 Months</option>
                            <option value="5">5 Months</option>
                            <option value="6">6 Months</option>
                            <option value="7">7 Months</option>
                            <option value="8">8 Months</option>
                            <option value="9">9 Months</option>
                            <option value="10">10 Months</option>
                            <option value="11">11 Months</option>
                            <option value="12">12 Months</option>
                        </select>
                        <input class="inpt" type="text" name="stfcontractdate" placeholder="Hire Date"
                               onfocus="(this.type='date')" required="">
                        <input class="inpt" type="text" name="stfposition" maxlength="40" placeholder="Position"
                               required="">
                        <input class="inpt" type="number" min="1000" step="500" max="1000000" name="stfsalary"
                               placeholder="Salary" required="">
                        <select class="inpt" name="stfeducation" required="">
                            <option value="" disabled selected hidden>Education</option>
                            <option>High School</option>
                            <option>Bachular' Degree</option>
                            <option>Master's Degree</option>
                            <option>Doctoral's Degree</option>
                        </select>
                        <select class="inpt" name="stffaculty" required="">
                            <option value="" disabled selected hidden>Bachular's Faculty</option>
                            <option>Medical</option>
                            <option>Computer Science</option>
                            <option>Enginerring</option>
                            <option>Law</option>
                            <option>Islamic Studies</option>
                            <option>Fine Arts</option>
                            <option>Economics</option>
                            <option>Agriculture</option>
                            <option>Journalism</option>
                            <option>Language and Literature</option>
                            <option>Pharmacy</option>
                            <option>Psychology</option>
                            <option>Midwifery</option>
                            <option>Science</option>
                            <option>Other</option>
                        </select>
                        <input class="inpt" type="text" name="stfuniversity" maxlength="40" placeholder="University"
                               required="">
                        <input class="inpt" type="text" name="stfgratuateyear" placeholder="Bachular's Gratuation Year"
                               onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 3">
                        <h6>Employee Profile</h6>
                        <img style="height: 250px;width:250px; object-fit: cover; border-radius:20%" id="output"
                             src="../userimages/user.png" alt=""><br>
                        <input type="file" name="imageupload" required="" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                        <select class="inpt" style="width: 95%;" name="stfusertype" required="">
                            <option value="" disabled selected hidden>User Type</option>
                            <option>Administrator</option>
                            <option>Head Master</option>
                            <option>Teacher</option>
                            <option>Finance</option>
                            <option>Human Resource</option>
                            <option>Book Shop</option>
                        </select>
                    </div>
                </div>
                <textarea class="inpt note" maxlength="150" name="stfremarks" id="" cols="30" rows="10"
                          placeholder="Note:"></textarea>
                <?php echo $message ?>
                <input class="bbb" type="Submit" name="btn-submit" value="Hire!">
            </form>
        </div>
    </center>
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
</body>
</html>