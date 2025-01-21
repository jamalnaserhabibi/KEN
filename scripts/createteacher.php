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
    if (isset($_POST['tgender']) && isset($_POST['tcontractduration']) && isset($_POST['teducation']) && isset($_POST['tdepartment']) && isset($_POST['tfaculty'])) {
        $qqq = ('select * from tblteacher where  tnationID=' . $_POST['tnationid']);
        $q = $connect->prepare($qqq);
        $q->execute();
        if ($q->rowCount() == 0) {
            require("connection.php");
            try {
                //user creation
                $query = "insert into tbluser(username,userpassword,usertype,photo,createdate)values(:username,:password,:usertype,:photo,:date)";
                $stm = $connect->prepare($query);
                $stm->bindValue(":username", $_POST["tfullname"]);
                $stm->bindValue(":password", $_POST["tcontact"]);
                $stm->bindValue(":usertype", 'Teacher');
                $stm->bindValue(':photo', 'temp');
                $date = date("d/m/Y");
                $stm->bindValue(":date", $date);
                $stm->execute();
                $uid = $connect->lastInsertId();
                $q_img_name = "UPDATE `tbluser` SET `photo`=" . $uid . " WHERE userid=" . $uid;
                $q_img_name = $connect->prepare($q_img_name);
                $q_img_name->execute();
                $uimage = $_FILES['imageupload']['tmp_name'];
                copy($uimage, "../userimages/" . $uid);
                //
            } catch (PDOException $e) {
                $e->getMessage();
            }
            try {
                $queryy = "INSERT INTO `tblteacher`(`tfullname`, `tfname`, `tgender`, `tdob`, 
                  `tcontractduration`, `tcontractdate`, `tsalary`, `tdepartment`, `teducation`, `tgratuateyear`,
                   `tuniversity`, `tfaculty`, `taddress`, `temail`, `tcontact`, `tnationID`, `tphoto`, `tremarks`, `example2`)VALUES 
                   (:tfullname,:tfname,:tgender,:tdob,:tcontractduration,:tcontractdate,:tsalary,:tdepartment,:teducation,:tgratuateyear,:tuniversity,:tfaculty,:taddress,:temail,:tcontact,:tnationid,:tphoto,:tremarks,:example2)";
                $stmt = $connect->prepare($queryy);
                $stmt->bindValue(':tfullname', $_POST['tfullname']);
                $stmt->bindValue(':tfname', $_POST['tfname']);
                $stmt->bindValue(':tgender', $_POST['tgender']);
                $stmt->bindValue(':tdob', $_POST['tdob']);
                $stmt->bindValue(':taddress', $_POST['taddress']);
                $stmt->bindValue(':tcontact', $_POST['tcontact']);
                $stmt->bindValue(':temail', $_POST['temail']);
                $stmt->bindValue(':tnationid', $_POST['tnationid']);
                $stmt->bindValue(':tcontractduration', $_POST['tcontractduration']);
                $stmt->bindValue(':tcontractdate', $_POST['tcontractdate']);
                $stmt->bindValue(':tsalary', $_POST['tsalary']);
                $stmt->bindValue(':tdepartment', $_POST['tdepartment']);
                $stmt->bindValue(':teducation', $_POST['teducation']);
                $stmt->bindValue(':tgratuateyear', $_POST['tgratuateyear']);
                $stmt->bindValue(':tuniversity', $_POST['tuniversity']);
                $stmt->bindValue(':tfaculty', $_POST['tfaculty']);
                $stmt->bindValue(':tphoto', 'temp');
                $stmt->bindValue(':tremarks', $_POST['tremarks']);
                $stmt->bindValue(':example2', $_POST['tremarks']);
                $stmt->execute();
                $tid = $connect->lastInsertId();
                $q_img_name = "UPDATE `tblteacher` SET `tphoto`=" . $tid . " WHERE tid=" . $tid;
                $q_img_name = $connect->prepare($q_img_name);
                $q_img_name->execute();
                move_uploaded_file($uimage, "../teacherimages/" . $tid);
                // echo '<h6 style="color:blue">Teacher ' . $_POST['tfullname'] . ' Successfully Hired!</h6>';
                header("location:teacher_list.php");
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        } else {
            $message = '<h6 style="color:red">Teacher with This National ID Number is Already exist!</h6>';
        }
    } else {
        $message = '<h6 style="color:red">Some Fields may left empty!</h6>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/createteacher.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Teacher</title>
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
            <h4>Create a new Teacher</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input class="inpt" type="text" name="tfullname" maxlength="30" placeholder="Full Name"
                               required="">
                        <input class="inpt" type="text" name="tfname" maxlength="30" placeholder="Father Name"
                               required="">
                        <select class="inpt" name="tgender" required="">
                            <option value="" disabled selected hidden> Select Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <input class="inpt" type="text" name="tdob" placeholder="Date of birth"
                               onfocus="(this.type='date')" required="">
                        <input class="inpt" type="text" name="taddress" maxlength="40" placeholder="Address"
                               required="">
                        <input class="inpt" type="number" name="tcontact" min="99999999" max="999999999999999"
                               placeholder="Contact" required="">
                        <input class="inpt" type="Email" name="temail" maxlength="50" placeholder="Email">
                        <input class="inpt" type="number" name="tnationid" min="99999"
                               max="999999999999999999999999999999" placeholder="National ID number" required="">
                    </div>
                    <div class="data 2">
                        <h6>Contraction Information</h6>
                        <select class="inpt" name="tcontractduration" required="">
                            <option value="" disabled selected hidden>Select Contraction Duration</option>
                            <option value="1">1 Month</option>
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
                        <input class="inpt" type="text" name="tcontractdate" placeholder="Hire Date"
                               onfocus="(this.type='date')" required="">
                        <select class="inpt" name="tdepartment" required="">
                            <option value="" disabled selected hidden> Department</option>
                            <?php //fill combo box from db
                            require_once("connection.php");
                            try {
                                $query = "select * from tbldepartment";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                }
                            } ?>
                        </select>
                        <input class="inpt" type="number" min="1000" step="500" max="1000000" name="tsalary"
                               placeholder="Salary" required="">
                        <select class="inpt" name="teducation" required="">
                            <option value="" disabled selected hidden>Education</option>
                            <option>High School</option>
                            <option>Bachular' Degree</option>
                            <option>Master's Degree</option>
                            <option>Doctoral's Degree</option>
                        </select>
                        <select class="inpt" name="tfaculty" required="">
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
                        <input class="inpt" type="text" name="tuniversity" maxlength="40" placeholder="University"
                               required="">
                        <input class="inpt" type="text" name="tgratuateyear" placeholder="Bachular's Gratuation Year"
                               onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 3">
                        <h6>Teacher Profile</h6>
                        <img style="height: 200px;width:200px; object-fit: cover; border-radius:50%" id="output"
                             src="../userimages/user.png" alt=""><br>
                        <input type="file" name="imageupload" required="" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                        <textarea class="inpt note" maxlength="150" name="tremarks" id="" cols="30" rows="10"
                                  placeholder="Note:"></textarea>
                    </div>
                </div>
                <?php echo $message ?>
        </div>
        <input class="bbb" type="Submit" name="btn-submit" value="Hire!">
        </form>
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