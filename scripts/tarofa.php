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
    require_once("connection.php");

    $stdid = $_GET['stdid'];
    $classid = $_GET['classid'];

    $query = "select * from selectstdclass where stdclassid = '$stdid'";
    $result = $connect->query($query);
    if (isset($result)) {
        while ($row = $result->fetch()) {
            $stdname = $row['stdfullname'];
            $stdfname = $row['stdfname'];
            $stdrootid = $row['stdenrolid'];
            $stdphoto = $row['stdphoto'];
            $classname = $row['classname'];
            $gname = $row['gname'];
        }
    }
    $query2 = "select * from tblfeepayment where   stdclassid = '$stdid'";
    $result2 = $connect->query($query2);
    if (isset($result2)) {
        $payperiod = $result2->rowCount();
    }
    $query3 = "select sum(payamount) from tblfeepayment where stdclassid = '$stdid'";
    $result3 = $connect->query($query3);
    if (isset($result3)) {
        while ($row = $result3->fetch()) {
            $totalpayamount = $row[0] + 0;
        }
    }
    $query4 = "select gfee from tblgrade where  gname = '$gname'";
    $result4 = $connect->query($query4);
    if (isset($result4)) {
        while ($row = $result4->fetch()) {
            $gradetotalfee = $row[0];
        }
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/tarofa.css" media="all">
    <link rel="stylesheet" href="../css/tarofaPrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Bale for <?php echo $stdname ?></title>

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
                <h2><?php echo $stdname ?> Payment Bale</h2>
            </center>
            <div class="personal info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Payment Information</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/teacher2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Student ID</label>
                        <h6><?php echo $stdid ?></h6>
                        <label>Full Name:</label>
                        <h6><?php echo $stdname ?></h6>
                        <label>Father Name:</label>
                        <h6><?php echo $stdfname ?></h6>
                        <label>Class</label>
                        <h6><?php echo $classname ?></h6>
                        <label>Root ID</label>
                        <h6><?php echo $stdrootid ?></h6>
                    </div>
                    <div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <label>Payment Amount:</label><br>
                            <input value="<?php echo $gradetotalfee - $totalpayamount ?>" class="tbox" type="number"
                                   min="100" max="10000" required="" name="pamount"><br>

                            <label>Type:</label><br>

                            <select class="tbox" name="ptype">

                                <option value="Bank">Bank</option>
                                <option value="Cash">Cash</option>
                                <option value="Other">Other</option>
                            </select>
                            <label>Total Pay Amount:</label><br>
                            <h6>(<?php echo $totalpayamount . ") Payed in (" . $payperiod . ") Periods " ?></h6>
                            <label>Total Fee for this Grade</label><br>
                            <h6>(<?php echo $gradetotalfee ?>)</h6>


                            <label>Date:</label><br>
                            <h6><?php echo date('D, M d, Y') ?></h6>


                    </div>
                    <div style="width:60%">
                        <center><label>Profile Photo</label></center>
                        <center><img src="../stdimages/<?php echo $stdphoto ?>" alt=""></center>

                    </div>
                </div>
            </div>


            <div class="useraccount info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Important Note</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/note.png"
                             alt="">
                    </div>
                </center>
                <div style="display: flex;flex-direction: column;text-align: left" class="data">
                    <h5>Dear Parents and Student</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis dolorem expedita nam, odit
                        quibusdam repellendus! Corporis, deleniti dolore dolores eligendi excepturi fugit iusto
                        perspiciatis quibusdam veniam vero? Aliquid, inventore, velit? Lorem ipsum dolor sit amet,
                        consectetur adipisicing elit. Aliquid animi consequatur cumque, nobis nulla odio optio vel?
                        Animi nemo odio sit. Dicta enim exercitationem inventore iusto maxime quis totam ut!</p>
                </div>

            </div>

            <div class="useraccount info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Bale Printed By</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/student2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Registered by</label>
                        <h6><?php echo $_SESSION['thename'] ?></h6>
                    </div>
                    <div>
                        <label>Account Accessibility</label>
                        <h6><?php echo $_SESSION['thetype'] ?></h6>
                    </div>
                </div>

            </div>


            <div style="height: 100px; width: 100px;"></div>
        </div>
        <style>
            .info h6 {
                padding: 10px;
                border: 1px solid #D93935;
                background-color: rgba(0, 0, 0, 0.04);
                text-align: center;
                margin: 5px;
                /* margin-left: 50px; */
                border-radius: 10px;
            }

            .info .tbox {
                padding: 10px;
                border: 1px solid #D93935;
                background-color: white;
                margin: 5px;
                border-radius: 10px;
                color: rgba(0, 0, 0, 0.7);
                width: 100%;
                height: 41px;
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

                </form>
                <a href='#.php'>
                    <button onclick="window.history.back()">Back</button>
                </a>
                <a href='#.php'>
                    <button onclick="window.print()">Print</button>
                </a>

            </div>
        </center>
</div>
</body>

</html>