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
    require_once("connection.php");

    $username = $_SESSION['thename'];
    $usertype = $_SESSION['thetype'];
    try {
        $query = "select * from tblstaff where stfid=" . $_GET['t0'] . "";
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
            $stfcontractduration = $row[5];
            $stfcontractdate = $row[6];
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/staffprofile.css" media="all">
    <link rel="stylesheet" href="../css/staffprofilePrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $stfname ?> Profile</title>
    <script type="text/javascript">
        function delete_id(stfid, stfname) //delete confirmatation
        {
            if (confirm('Do you want to delete :  (' + stfname + ') with the user account?')) {
                window.location.href = 'deletestaff.php?stfid=' + stfid + '&&stfname=' + stfname + '';
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
                <h2>Employee | <?php echo $stfname ?> | Profile</h2>
            </center>
            <div class="personal info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Personal Information</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/teacher2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Full Name:</label>
                        <h6><?php echo $stfname ?></h6>
                        <label>Father Name:</label>
                        <h6><?php echo $stffname ?></h6>
                        <label>Data of Birth:</label>
                        <h6><?php echo $stfdob ?></h6>
                        <label>Gender:</label>
                        <h6><?php echo $stfgender ?></h6>
                    </div>
                    <div>
                        <label>Permanent Address:</label>
                        <h6><?php echo $stfaddress ?></h6>
                        <label>Email Address:</label>
                        <h6><?php echo $stfemail ?></h6>
                        <label>Contact:</label>
                        <h6><?php echo $stfcontact ?></h6>
                        <label>National Identity ID:</label>
                        <h6><?php echo $stfnationid ?></h6>
                    </div>
                    <div style="width:60%">
                        <center><label>Profile Photo</label></center>
                        <center><img src="../staffimages/<?php echo $stfphoto ?>" alt=""></center>
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
                        <h6><?php echo $stfcontractdate ?></h6>
                        <label>Contraction Period:</label>
                        <h6><?php echo $stfcontractduration ?> - Months</h6>
                        <label>Contraction Credit:</label>
                        <h6>(<?php echo $stfsalary ?>) Afg</h6>
                        <label>Contraction Position:</label>
                        <h6><?php echo $stfposition ?></h6>
                    </div>
                    <div>
                        <label>University Gratuation:</label>
                        <h6><?php echo $stfuniversity ?></h6>
                        <label>Gratuation Date:</label>
                        <h6><?php echo $stfgratuateyear ?></h6>
                        <label>Faculty Gratuation</label>
                        <h6><?php echo $stffaculty ?></h6>
                        <label>Extra Note:</label>
                        <h6><?php echo $stfremark ?></h6>
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
                        <h6><?php echo $stfname ?></h6>
                    </div>
                    <div>
                        <label>Login Default Password</label>
                        <h6><?php echo $stfcontact ?></h6>
                    </div>
                    <div>
                        <label>Account Accessibility</label>
                        <h6><?php echo $usertype ?> Accessibility</h6>
                    </div>
                </div>
            </div>
            <div class="signatures">
                <div>
                    <h6>Sincerly</h6>
                    <h6>Resptected <?php echo $stfname ?></h6>
                    <h6>Employee</h6>
                    <?php echo date('Y/m/d') ?>
                    <hr>
                </div>
                <div>
                    <h6>Sincerly</h6>
                    <h6><?php echo 'Resptected ' . $username ?></h6>
                    <h6>KEN - <?php echo 'Employer ' . $usertype ?></h6>
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
                <a href="staff_list.php">
                    <button>Employee List</button>
                </a>
                <?php
                echo '<a href="updatestaff.php?stfid=' . $stfid . '"><button>Update</button></a>';
                ?>
                <a href="javascript:delete_id(<?php echo $stfid ?>,'<?php echo $stfname ?>')">
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