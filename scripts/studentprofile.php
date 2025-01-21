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


    $username = $_SESSION['thename'];
    $usertype = $_SESSION['thetype'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/studentprofile.css" media="all">
    <link rel="stylesheet" href="../css/studentprofilePrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $stdfullname ?> Profile</title>
    <script type="text/javascript">
        function delete_id(id, stdname) //delete confirmatation
        {
            if (confirm('Do you want to delete :  (' + stdname + ') ?')) {
                window.location.href = 'deletestudent.php?stdid=' + id;
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

            <h2><?php echo $stdfullname ?> Profile</h2>

            <div class="personal info">
                <center>
                    <div class="boxhead">
                        <h4 style="padding-top:4px ;">Personal Information</h4>
                        <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/student2.png"
                             alt="">
                    </div>
                </center>
                <div class="data">
                    <div>
                        <label>Full Name:</label>
                        <h6><?php echo $stdfullname ?></h6>
                        <label>Father Name:</label>
                        <h6><?php echo $stdfname ?></h6>
                        <label>Grand Father Name:</label>
                        <h6><?php echo $stdgfname ?></h6>
                        <label>Gender:</label>
                        <h6><?php echo $stdgender ?></h6>
                    </div>
                    <div>
                        <label class="daritext">نام</label>
                        <h6 class="daritext"><?php echo $dstdfullname ?></h6>
                        <label class="daritext">نام پدر</label>
                        <h6 class="daritext"><?php echo $dstdfname ?></h6>
                        <label class="daritext">نام پدر کلان</label>
                        <h6 class="daritext"><?php echo $dstdgfname ?></h6>
                        <label class="daritext">نمبر اساس</label>
                        <h6 class="daritext"><?php echo $stdenrolid ?></h6>
                    </div>
                    <div style="width:60%">
                        <center><label>Profile Photo</label></center>
                        <center><img src="../stdimages/<?php echo $stdphoto ?>" alt=""></center>
                    </div>
                </div>
            </div>
            <div class="Contraction info">
                <center>
                    <center>
                        <div class="boxhead">
                            <h4 style="padding-top:4px ;">Other Information</h4>
                            <img style="width: 40px; height:50px; margin:-5px; padding:0px" src="../icons/moreino.png"
                                 alt="">
                        </div>
                    </center>
                </center>
                <div class="data">
                    <div>
                        <label>National ID number:</label>
                        <h6><?php echo $stdnationid ?></h6>
                        <label>Enrol Date:</label>
                        <h6><?php echo $stdenroldate ?> - Months</h6>
                        <label>Permanent Address:</label>
                        <h6>(<?php echo $stdaddress ?>) Afg</h6>
                        <label>Contact</label>
                        <h6><?php echo $stdcontact ?></h6>
                    </div>
                    <div>
                        <label>Parent Date:</label>
                        <h6><?php echo $stdparentcontact ?></h6>
                        <label>Date Of Birth</label>
                        <h6><?php echo $stddob ?></h6>
                        <label>System ID</label>
                        <h6><?php echo $stdid ?></h6>
                        <label>Extra Note:</label>
                        <h6><?php echo $stdremark ?></h6>
                    </div>
                </div>
            </div>
            <div class="signatures">
                <div>
                    <h6>Sincerly</h6>
                    <h6> <?php echo $stdfullname ?></h6>
                    <h6>Student's Proxy</h6>
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
                border: 1px solid rgba(217, 57, 53, 0.58);
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
                <a href="student_list.php">
                    <button>Student List</button>
                </a>
                <a>
                    <button onclick="window.print();">Print</button>
                </a>
                <a href="javascript:delete_id(<?php echo $stdid ?>,'<?php echo $stdfullname ?>')">
                    <button>Delete</button>
                </a>
                <?php
                // echo
                echo '<a href="updatestudent.php?stdid=' . $stdid . '"><button>Update</button></a>';
                echo ' ';
                echo '<a href="updatestudent.php?stdid=' . $stdid . '"><button>Shift School</button></a>';
                ?>

            </div>
        </center>
</div>
</body>

</html>