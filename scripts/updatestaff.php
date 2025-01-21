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

if (isset($_GET['stfid'])) {
    require_once("connection.php");

    $username = $_SESSION['thename'];
    $usertype = $_SESSION['thetype'];
    try {
        $query = "select * from tblstaff where stfid=" . $_GET['stfid'] . "";
        $result = $connect->query($query);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    if (isset($result)) {
        while ($row = $result->fetch()) {
            $stfid = $row[0];
            $stfname = $row[1];
            $stffname = $row[2];
            $stfgender = $row[3];
            $stfdob = $row[4];
            $stfcontractionduration = $row[5];
            $stfcontractiondate = $row[6];
            $stfsalary = $row[7];
            $stfeducation = $row[8];
            $stffaculty = $row[9];
            $stfgratuateyear = $row[10];
            $stfuniversity = $row[11];
            $stfposition = $row[12];
            $stfaddress = $row[13];
            $stfcontact = $row[14];
            $stfnationid = $row[15];
            $stfphoto = $row[16];
            $stfremark = $row[17];
            $stfemail = $row[18];
        }
    }
} else {
    echo 'Couldnt Get ID, Please Restart Browser!';
}
$msg = '';
//////////////////////////////////////////////
if (isset($_POST['btn-submit'])) {
    require_once('connection.php');
    $qqq = ('select * from tblstaff where stfnationid=' . $_POST['stfnationid'] . ' and stfid != ' . $stfid . '');
    $q = $connect->prepare($qqq);
    $q->execute();
    if ($q->rowCount() == 0) {
        require("connection.php");
        try {
            $queryy = "UPDATE `tblstaff` SET `stffullname`=:stffullname,`stffname`=:stffname,`stfgender`=:stfgender,
      `stfdob`=:stfdob,`stfcontractionduration`=:stfcontractionduration,`stfcontractiondate`=:stfcontractiondate,`stfsalary`=:stfsalary,
      `stfdegree`=:stfeducation,`stffaculty`=:stffaculty,`stfgratuateyear`=:stfgratuateyear,`stfuniversity`=:stfuniversity,
      `stfposition`=:stfposition,`stfaddress`=:stfaddress,`stfcontact`=:stfcontact,`stfnationid`=:stfnationid,
      `stfphoto`=:stfphoto,`stfremark`=:stfremark,`stfemail`=:stfemail WHERE stfid=$stfid";
            $stmt = $connect->prepare($queryy);
            $stmt->bindValue(':stffullname', $_POST['stffullname']);
            $stmt->bindValue(':stffname', $_POST['stffname']);
            $stmt->bindValue(':stfgender', $_POST['stfgender']);
            $stmt->bindValue(':stfdob', $_POST['stfdob']);
            $stmt->bindValue(':stfcontractionduration', $_POST['stfcontractionduration']);
            $stmt->bindValue(':stfcontractiondate', $_POST['stfcontractiondate']);
            $stmt->bindValue(':stfsalary', $_POST['stfsalary']);
            $stmt->bindValue(':stfposition', $_POST['stfposition']);
            $stmt->bindValue(':stfeducation', $_POST['stfeducation']);
            $stmt->bindValue(':stfgratuateyear', $_POST['stfgratuateyear']);
            $stmt->bindValue(':stfuniversity', $_POST['stfuniversity']);
            $stmt->bindValue(':stffaculty', $_POST['stffaculty']);
            $stmt->bindValue(':stfaddress', $_POST['stfaddress']);
            $stmt->bindValue(':stfemail', $_POST['stfemail']);
            $stmt->bindValue(':stfcontact', $_POST['stfcontact']);
            $stmt->bindValue(':stfnationid', $_POST['stfnationid']);
            $stmt->bindValue(':stfphoto', 'temp');
            $stmt->bindValue(':stfremark', $_POST['stfremarks']);
            $stmt->execute();
            $q_img_name = "UPDATE `tblstaff` SET `stfphoto`=" . $stfid . " WHERE stfid=" . $stfid;
            $q_img_name = $connect->prepare($q_img_name);
            $q_img_name->execute();

            if ($_FILES['imageupload']['tmp_name'] != "") {
                if (file_exists("../staffimages/$stfid")) {
                    unlink("../staffimages/$stfid");
                    $temp = $_FILES['imageupload']['tmp_name'];
                    move_uploaded_file($temp, "../staffimages/" . $stfid);
                };
            }
            header("location:staff_list.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $msg = '<h6 style="color:red">Employee with this national identity number has been hired!</h6>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/updatestaff.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $stfname ?></title>
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
            <h4>Update Employee | <?php echo $stfname ?> Information</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input value="<?php echo $stfname ?>" class="inpt" type="text" name="stffullname" maxlength="30"
                               placeholder="Full Name" required="">
                        <input value="<?php echo $stffname ?>" class="inpt" type="text" name="stffname" maxlength="30"
                               placeholder="Father Name" required="">
                        <select class="inpt" name="stfgender" required="">
                            <?php if ($stfgender == 'Male') {
                                echo '<option value="Male" selected>Male</option>';
                                echo '<option value="Female">Female</option>';
                            } else {
                                echo '<option value="Female" selected>Female</option>';
                                echo '<option value="Male" >Male</option>';
                            }
                            ?>
                        </select>
                        <input value="<?php echo $stfdob ?>" class="inpt" type="text" name="stfdob"
                               placeholder="Date of birth" onfocus="(this.type='date')" required="">
                        <input value="<?php echo $stfaddress ?>" class="inpt" type="text" name="stfaddress"
                               maxlength="40" placeholder="Address" required="">
                        <input value="<?php echo $stfcontact ?>" class="inpt" type="number" name="stfcontact"
                               min="99999999" max="999999999999999" placeholder="Contact" required="">
                        <input value="<?php echo $stfemail ?>" class="inpt" type="Email" name="stfemail" maxlength="50"
                               placeholder="Email">
                        <input value="<?php echo $stfnationid ?>" class="inpt" type="number" name="stfnationid"
                               min="99999" max="999999999999999999999999999999" placeholder="National ID number"
                               required="">
                    </div>
                    <div class="data 2">
                        <h6>Contraction Information</h6>
                        <select class="inpt" name="stfcontractionduration" required="">
                            <option value=<?php echo $stfcontractionduration ?>><?php echo $stfcontractionduration ?>
                                Months
                            </option>
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
                        <input value="<?php echo $stfcontractiondate ?>" class="inpt" type="text"
                               name="stfcontractiondate" placeholder="Hire Date" onfocus="(this.type='date')"
                               required="">
                        <input value="<?php echo $stfposition ?>" class="inpt" type="text" name="stfposition"
                               placeholder="Position" required="">
                        <input value="<?php echo $stfsalary ?>" class="inpt" type="number" min="1000" step="500"
                               max="1000000" name="stfsalary" placeholder="Salary" required="">
                        <select class="inpt" name="stfeducation" required="">
                            <option values="<?php echo $stfeducation ?>"><?php echo $stfeducation ?></option>
                            <option>High School</option>
                            <option>Bachular' Degree</option>
                            <option>Master's Degree</option>
                            <option>Doctoral's Degree</option>
                        </select>
                        <select class="inpt" name="stffaculty" required="">
                            <option values="<?php echo $stffaculty ?>"><?php echo $stffaculty ?></option>
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
                        <input value="<?php echo $stfuniversity ?>" class="inpt" type="text" name="stfuniversity"
                               maxlength="40" placeholder="University" required="">
                        <input value="<?php echo $stfgratuateyear ?>" class="inpt" type="text" name="stfgratuateyear"
                               placeholder="Bachular's Gratuation Year" onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 3">
                        <h6><?php echo $stfname ?> Profile</h6>
                        <img style="height: 200px;width:200px; object-fit: cover; border-radius:20%" id="output"
                             src="../staffimages/<?php echo $stfphoto ?>" alt=""><br>
                        <input type="file" name="imageupload" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                        <textarea class="inpt note" maxlength="150" name="stfremarks" id="" cols="30" rows="10"
                                  placeholder="Note:"><?php echo $stfremark ?></textarea>
                    </div>
                </div>
                <?php echo $msg ?>
                <input class="bbb" type="Submit" name="btn-submit" value="Update!">
                <a class="bbb" href="staff_list.php">Cancel</a>
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