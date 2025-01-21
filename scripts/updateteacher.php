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


if (isset($_GET['t0'])) {
    $tid = $_GET['t0'];
    $tname = $_GET['t1'];
    $tfname = $_GET['t2'];
    $tgender = $_GET['t3'];
    $tdob = $_GET['t4'];
    $tcontractduration = $_GET['t5'];
    $tcontractdate = $_GET['t6'];
    $tsalary = $_GET['t7'];
    $tdepartment = $_GET['t8'];
    $teducation = $_GET['t9'];
    $tgratuateyear = $_GET['t10'];
    $tuniversity = $_GET['t11'];
    $tfaculty = $_GET['t12'];
    $taddress = $_GET['t13'];
    $temail = $_GET['t14'];
    $tcontact = $_GET['t15'];
    $tnationid = $_GET['t16'];
    $tphoto = $_GET['t17'];
    $tremark = $_GET['t18'];
    $example2 = $_GET['t19'];
}
$msg = '';
//////////////////////////////////////////////
if (isset($_POST['btn-submit'])) {
    require_once('connection.php');
    $qqq = ('select * from tblteacher where tnationID=' . $_POST['tnationid'] . ' and tid != ' . $tid);
    $q = $connect->prepare($qqq);
    $q->execute();
    if ($q->rowCount() == 0) {
        require("connection.php");
        try {
            $queryy = "UPDATE `tblteacher` SET `tfullname`=:tfullname,`tfname`=:tfname,`tgender`=:tgender,`tdob`=:tdob,`tcontractduration`=:tcontractduration,
                  `tcontractdate`=:tcontractdate,`tsalary`=:tsalary,`tdepartment`=:tdepartment,`teducation`=:teducation,`tgratuateyear`=:tgratuateyear, `tuniversity`
                  =:tuniversity,`tfaculty`=:tfaculty,`taddress`=:taddress,`temail`=:temail,`tcontact`=:tcontact,`tnationid`=:tnationid,
                  `tphoto`=:tphoto,`tremarks`=:tremarks,`example2`=:example2 WHERE tid=$tid";
            $stmt = $connect->prepare($queryy);
            $stmt->bindValue(':tfullname', $_POST['tfullname']);
            $stmt->bindValue(':tfname', $_POST['tfname']);
            $stmt->bindValue(':tgender', $_POST['tgender']);
            $stmt->bindValue(':tdob', $_POST['tdob']);
            $stmt->bindValue(':tcontractduration', $_POST['tcontractduration']);
            $stmt->bindValue(':tcontractdate', $_POST['tcontractdate']);
            $stmt->bindValue(':tsalary', $_POST['tsalary']);
            $stmt->bindValue(':tdepartment', $_POST['tdepartment']);
            $stmt->bindValue(':teducation', $_POST['teducation']);
            $stmt->bindValue(':tgratuateyear', $_POST['tgratuateyear']);
            $stmt->bindValue(':tuniversity', $_POST['tuniversity']);
            $stmt->bindValue(':tfaculty', $_POST['tfaculty']);
            $stmt->bindValue(':taddress', $_POST['taddress']);
            $stmt->bindValue(':temail', $_POST['temail']);
            $stmt->bindValue(':tcontact', $_POST['tcontact']);
            $stmt->bindValue(':tnationid', $_POST['tnationid']);
            $stmt->bindValue(':tphoto', 'temp');
            $stmt->bindValue(':tremarks', $_POST['tremarks']);
            $stmt->bindValue(':example2', $_POST['tremarks']);
            $stmt->execute();

            $q_img_name = "UPDATE `tblteacher` SET `tphoto`=" . $tid . " WHERE tid=" . $tid;
            $q_img_name = $connect->prepare($q_img_name);
            $q_img_name->execute();

            if ($_FILES['imageupload']['tmp_name'] != "") {
                if (file_exists("../teacherimages/$tid")) {
                    unlink("../teacherimages/$tid");
                    $temp = $_FILES['imageupload']['tmp_name'];
                    move_uploaded_file($temp, "../teacherimages/" . $tid);
                };
            }
            header("location:teacher_list.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $msg = '<h6 style="color:red">Teacher with this national identity number has been hired!</h6>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updateteacher.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher <?php echo $tname ?></title>
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
            <h4>Update Teacher Information</h4>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="all-inputs">
                    <div class="data 1">
                        <h6>Personal Information</h6>
                        <input value="<?php echo $tname ?>" class="inpt" type="text" name="tfullname" maxlength="30"
                               placeholder="Full Name" required="">
                        <input value="<?php echo $tfname ?>" class="inpt" type="text" name="tfname" maxlength="30"
                               placeholder="Father Name" required="">
                        <select class="inpt" name="tgender" required="">
                            <?php if ($tgender == 'Male') {
                                echo '<option value="Male" selected>Male</option>';
                                echo '<option value="Female">Female</option>';
                            } else {
                                echo '<option value="Female" selected>Female</option>';
                                echo '<option value="Male" >Male</option>';
                            }
                            ?>
                        </select>
                        <input value="<?php echo $tdob ?>" class="inpt" type="text" name="tdob"
                               placeholder="Date of birth" onfocus="(this.type='date')" required="">
                        <input value="<?php echo $taddress ?>" class="inpt" type="text" name="taddress" maxlength="40"
                               placeholder="Address" required="">
                        <input value="<?php echo $tcontact ?>" class="inpt" type="number" name="tcontact" min="99999999"
                               max="999999999999999" placeholder="Contact" required="">
                        <input value="<?php echo $temail ?>" class="inpt" type="Email" name="temail" maxlength="50"
                               placeholder="Email">
                        <input value="<?php echo $tnationid ?>" class="inpt" type="number" name="tnationid" min="99999"
                               max="999999999999999999999999999999" placeholder="National ID number" required="">
                    </div>
                    <div class="data 2">
                        <h6>Contraction Information</h6>
                        <select class="inpt" name="tcontractduration" required="">
                            <option value=<?php echo $tcontractduration ?>><?php echo $tcontractduration ?>Months
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
                        <input value="<?php echo $tcontractdate ?>" class="inpt" type="text" name="tcontractdate"
                               placeholder="Hire Date" onfocus="(this.type='date')" required="">
                        <select class="inpt" name="tdepartment" required="">
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
                                    // echo '<option value="' . $row[0] . '">' . $tdepartment . '</option>';
                                    echo '<option value=' . $row[0];
                                    if ($row[1] == $tdepartment) {
                                        echo ' selected ';
                                    }
                                    echo '>' . $row[1] . '</option>';
                                }
                            } ?>
                        </select>

                        <input value="<?php echo $tsalary ?>" class="inpt" type="number" min="1000" step="500"
                               max="1000000" name="tsalary" placeholder="Salary" required="">
                        <select class="inpt" name="teducation" required="">
                            <option values="<?php echo $teducation ?>"><?php echo $teducation ?></option>
                            <option>High School</option>
                            <option>Bachular' Degree</option>
                            <option>Master's Degree</option>
                            <option>Doctoral's Degree</option>
                        </select>
                        <select class="inpt" name="tfaculty" required="">
                            <option values="<?php echo $tfaculty ?>"><?php echo $tfaculty ?></option>
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
                        <input value="<?php echo $tuniversity ?>" class="inpt" type="text" name="tuniversity"
                               maxlength="40" placeholder="University" required="">
                        <input value="<?php echo $tgratuateyear ?>" class="inpt" type="text" name="tgratuateyear"
                               placeholder="Bachular's Gratuation Year" onfocus="(this.type='date')" required="">
                    </div>
                    <div class="data 3">
                        <h6>Teacher Profile</h6>
                        <img style="height: 200px;width:200px; object-fit: cover; border-radius:50%" id="output"
                             src="../teacherimages/<?php echo $tphoto ?>" alt=""><br>
                        <input type="file" name="imageupload" class="filebtn" accept=".jpg,.jpeg,.png"
                               onchange="loadFile(event)"><br>
                        <textarea class="inpt note" maxlength="150" name="tremarks" id="" cols="30" rows="10"
                                  placeholder="Note:"><?php echo $example2 ?></textarea>
                    </div>
                </div>
                <?php echo $msg ?>
                <input class="bbb" type="Submit" name="btn-submit" value="Update!">
                <a class="bbb" href="teacher_list.php">Cancel</a>
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