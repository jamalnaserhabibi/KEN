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

    $username = $_SESSION['thename'];
    $usertype = $_SESSION['thetype'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/teacherprofile.css" media="all">
    <link rel="stylesheet" href="../css/teacherprofilePrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher <?php echo $tname ?> Profile</title>
    <script type="text/javascript">
        function delete_id(id, tname) //delete confirmatation
        {
            if (confirm('Do you want to delete Teacher:  (' + tname + ')with the user account?')) {
                window.location.href = 'deleteteacher.php?tid=' + id + '&&tname=' + tname + '';
            }
        }
    </script>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <div class="headers">
                <!-- <h6>Khana-e-Noor Private High School</h6>
            <h6>Khana-e-Noor Private High School</h6>
            <h6>Khana-e-Noor Private High School</h6> -->
                <h2>Khana-e-Noor Private High School</h2>
            </div>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="middle">
            <center>
                <h2>Teacher | <?php echo $tname ?> | Profile</h2>
            </center>
            <div class="personal info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Personal Information</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/teach.png" alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Full Name:</label>
                        <h6><?php echo $tname ?></h6>
                        <label>Father Name:</label>
                        <h6><?php echo $tfname ?></h6>
                        <label>Data of Birth:</label>
                        <h6><?php echo $tdob ?></h6>
                        <label>Gender:</label>
                        <h6><?php echo $tgender ?></h6>
                    </div>
                    <div>
                        <label>Permanent Address:</label>
                        <h6><?php echo $taddress ?></h6>
                        <label>Email Address:</label>
                        <h6><?php echo $temail ?></h6>
                        <label>Contact:</label>
                        <h6><?php echo $tcontact ?></h6>
                        <label>National Identity ID:</label>
                        <h6><?php echo $tnationid ?></h6>
                    </div>
                    <div style="width:60%">
                        <center><label>Profile Photo</label></center>
                        <center><img src="../teacherimages/<?php echo $tphoto ?>" alt=""></center>
                    </div>
                </div>
            </div>
            <div class="Contraction info">
                <center>
                    <center>
                        <div class="boxhead">
                            <h4 style="padding-top:4px ;">Contraction Information</h4>
                            <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/contract.png"
                                 alt="">
                        </div>
                    </center>
                </center>
                <div class="data">
                    <div>
                        <label>Contraction Date:</label>
                        <h6><?php echo $tcontractdate ?></h6>
                        <label>Contraction Period:</label>
                        <h6><?php echo $tcontractduration ?> - Months</h6>
                        <label>Contraction Credit:</label>
                        <h6>(<?php echo $tsalary ?>) Afg</h6>
                        <label>Contraction Department:</label>
                        <h6><?php echo $tdepartment ?></h6>
                    </div>
                    <div>
                        <label>University Gratuation:</label>
                        <h6><?php echo $tuniversity ?></h6>
                        <label>Gratuation Date:</label>
                        <h6><?php echo $tgratuateyear ?></h6>
                        <label>Faculty Gratuation</label>
                        <h6><?php echo $tfaculty ?></h6>
                        <label>Extra Note:</label>
                        <h6><?php echo $tremark ?></h6>
                    </div>
                </div>
            </div>
            <div class="useraccount info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Account Information</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/student2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Username:</label>
                        <h6><?php echo $tname ?></h6>
                    </div>
                    <div>
                        <label>Login Default Password</label>
                        <h6><?php echo $tcontact ?></h6>
                    </div>
                    <div>
                        <label>Account Accessibility</label>
                        <h6>Teacher Accessibility</h6>
                    </div>
                </div>
            </div>
            <div class="signatures">
                <div>
                    <h6>Sincerly</h6>
                    <h6> <?php echo 'Teacher ' . $tname ?></h6>
                    <h6>Contractor</h6>
                    <?php echo date('Y/m/d') ?>
                    <hr>
                </div>
                <div>
                    <h6>Sincerly</h6>
                    <h6><?php echo $username ?></h6>
                    <h6>KEN - <?php echo $usertype ?></h6>
                    <?php echo date('Y/m/d') ?>
                    <hr>
                </div>
            </div>
            <div style="height: 100px; width: 100px;"></div>
        </div>
        <style>
            .info h6 {
                padding: 10px;
                border: 1px solid #D93935;
                background-color: white;
                text-align: center;
                margin: 5px;
                /* margin-left: 50px; */
                border-radius: 10px;
            }

            .info label {
                margin: 0px;
            }

            .info img {
                margin-top: 10px;
                height: 250px;
                width: 200px;
                object-fit: cover;
                border-radius: 40px;
            }
        </style>
        <center>
            <div class="buttons">
                <a href="teacher_list.php">
                    <button>Teacher List</button>
                </a>
                <?php
                // echo
                echo '<a href="updateteacher.php?t0=' . $tid . '&&t1=' . $tname . '&&t2=' . $tfname . '&&t3=' . $tgender . '&&t4=' . $tdob . '&&t5=' . $tcontractduration . '&&t6=' . $tcontractdate . '&&t7=' . $tsalary . '&&t8=' . $tdepartment . '&&t9=' . $teducation . '&&t10=' . $tgratuateyear . '&&t11=' . $tuniversity . '&&t12=' . $tfaculty . '&&t13=' . $taddress . '&&t14=' . $temail . '&&t15=' . $tcontact . '&&t16=' . $tnationid . '&&t17=' . $tphoto . '&&t18=' . $tremark . '&&t19=' . $example2 . '"><button>Update</button></a>';
                ?>
                <a href="javascript:delete_id(<?php echo $tid ?>,'<?php echo $tname ?>')">
                    <button>Delete</button>
                </a>
                <a>
                    <button onclick="window.print();">Print</button>
                </a>
            </div>
        </center>
</div>
</body>

</html>