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

if (isset($_GET['pid'])) {
    require_once("connection.php");

    $paymentid = $_GET['pid'];

    $query = "select * from selectfeepayment where  payid = '$paymentid'";
    $result = $connect->query($query);
    if (isset($result)) {
        while ($row = $result->fetch()) {
            $stdname = $row['stdfullname'];
            $stdfname = $row['stdfname'];
            $stdclassname = $row['classname'];
            $stdrootid = $row['stdenrolid'];
            $stdphoto = $row['stdid'];
            $paymentid = $row['payid'];

            $payamount = $row['payamount'];
            $paytype = $row['paytype'];
            $pperiod = $row['payperiod'];
            $pdate = $row['paydate'];
            $premark = $row['payremark'];
            $username = $row['savedby'];
        }
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatepaymentbale.css" media="all">
    <link rel="stylesheet" href="../css/staffprofilePrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $stdname ?> Profile</title>

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
                <h2>Update <?php echo $stdname ?> Payment Bale</h2>
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
                        <h6><?php echo $stdphoto ?></h6>
                        <label>Full Name:</label>
                        <h6><?php echo $stdname ?></h6>
                        <label>Father Name:</label>
                        <h6><?php echo $stdfname ?></h6>
                        <label>Class</label>
                        <h6><?php echo $stdclassname ?></h6>
                        <label>Root ID</label>
                        <h6><?php echo $stdrootid ?></h6>
                    </div>
                    <div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <label>Payment Amount:</label><br>
                            <input value="<?php echo $payamount ?>" class="tbox" type="number" min="100" max="10000"
                                   required="" name="pamount"><br>

                            <label>Type:</label><br>

                            <select class="tbox" name="ptype">
                                <?php
                                if ($paytype == "Bank") {
                                    echo '<option value="Bank" >Bank</option> ';
                                    echo '<option value="Cash" >Cash</option> ';
                                    echo '<option value="Other" >Other</option> ';
                                } elseif ($paytype == "Cash") {
                                    echo '<option value="Cash" >Cash</option> ';
                                    echo '<option value="Bank" >Bank</option> ';
                                    echo '<option value="Other" >Other</option> ';
                                } else {
                                    echo '<option value="Other" >Other</option> ';
                                    echo '<option value="Bank" >Bank</option> ';
                                    echo '<option value="Cash" >Cash</option> ';
                                }
                                ?>
                            </select>

                            <label>Period:</label><br>
                            <input value="<?php echo $pperiod ?>" class="tbox" type="number" min="1" max="10"
                                   required="" name="pperiod"><br>

                            <label>Date:</label><br>
                            <input value="<?php echo $pdate ?>" class="tbox" type="date" required="" name="pdate"><br>

                            <label>Describtion:</label><br>
                            <input value="<?php echo $premark ?>" class="tbox" type="text" name="premark"><br>


                            <?php
                            if (isset($_POST['btn-submit'])) {
                                try {
                                    $pamount = $_POST['pamount'];
                                    $ptype = $_POST['ptype'];
                                    $pperiod = $_POST['pperiod'];
                                    $pdate = $_POST['pdate'];
                                    $premark = $_POST['premark'];
                                    $date = date("d/m/Y");
                                    $stmt = $connect->prepare("UPDATE `tblfeepayment` SET `payamount`=:payamount,`paytype`=:ptype,`payperiod`=:payperiod,`paydate`=:pdate,`payremark`=:premark,`updatedby`= :updateby WHERE payid= :payid");
                                    $stmt->bindValue(':payid', $paymentid);
                                    $stmt->bindValue(':payamount', $pamount);
                                    $stmt->bindValue(':payperiod', $pperiod);
                                    $stmt->bindValue(':ptype', $ptype);
                                    $stmt->bindValue(':pdate', $pdate);
                                    $stmt->bindValue(':premark', $premark);
                                    $stmt->bindValue(':updateby', $username);
                                    $stmt->execute();
                                    header('Location: feepayment_list.php');
                                } catch (PDOException $e) {
                                    $e->getMessage();
                                }
                            }
                            ?>

                    </div>
                    <div style="width:60%">
                        <center><label>Profile Photo</label></center>
                        <center><img src="../stdimages/<?php echo $stdphoto ?>" alt=""></center>
                        <h5 style="text-align: center; margin: 10px">Payment ID</h5>
                        <h4 style="text-align: center; margin: 10px"><?php echo $paymentid ?></h4>
                    </div>
                </div>
            </div>

            <div class="useraccount info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Registered</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/student2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Registered by</label>
                        <h6><?php echo $username ?></h6>
                    </div>
                    <div>
                        <label>Account Accessibility</label>
                        <h6><?php echo "#" ?> Accessibility</h6>
                    </div>
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
                <input class="bbb signin" type="submit" name="btn-submit" value="Update">
                </form>
                <a href='feepayment_list.php'>
                    <button>Back</button>
                </a>

            </div>
        </center>
</div>
</body>

</html>