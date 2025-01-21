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
if (isset($_GET['cname'])) {
    $classid = $_GET['cname'];
} else {
    echo 'Couldnt get Data!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/classsearchforpayment.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $classid ?> </title>

</head>
<body>
<div class="maincontaner">

    <div class="top">
        <img src="../icons/mareflogo.png" alt="">
        <h2>Khana-e-Noor Private High School</h2>
        <img src="../icons/logo.png" alt="">
    </div>
    <center>
        <div class="tblusers">
            <div class="tablehead">
                <h3><?php echo $classid ?> </h3>
                <div class="seek">
                    <img class="srch" src="../icons/srch.png" alt="">
                    <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                           placeholder="Search">
                    <span id="record-count"></span>
                </div>
            </div>

            <div class="data">
                <?php
                require_once("connection.php");

                try {
                    $query = "select * from selectstdclass where classname='" . $classid . "'";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table  table-bordered  table-hover table-striped" style="font-size:15px;">';

                    echo '<thead >';
                    echo '<th>ID</th>';
                    echo '<th>Full Name</th>';
                    echo '<th>Father Name</th>';
//                    echo '<th>G/Father Name</th>';
//                    echo '<th style="text-align: right" >نام</th>';
//                    echo '<th style="text-align: right">نام پدر</th>';
//                    echo '<th style="text-align: right">نام پدر کلان</th>';
                    echo '<th>Class Name</th>';
                    echo '<th>Profile</th>';
                    echo '<th>Enrol Date</th>';
                    echo '<th>Promotion Date</th>';
                    echo '<th>Describtion</th>';
                    echo '<th>Payment</th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[2] . '</td>';
//                        echo '<td>' . $row[3] . '</td>';
//                        echo '<td style="text-align: right">' . $row[4] . '</td>';
//                        echo '<td style="text-align: right">' . $row[5] . '</td>';
//                        echo '<td style="text-align: right">' . $row[6] . '</td>';
                        echo '<td>' . $row['classname'] . '</td>';
                        echo '<td><center><img class="tphoto" src=../stdimages/' . $row[7] . ' alt="No photo Found"></center></td>';
                        echo '<td>' . $row[12] . '</td>';
                        echo '<td>' . $row[13] . '</td>';
                        echo '<td>' . $row[14] . '</td>';
                        echo '<td class="seekbtns" ><a href="tarofa.php?stdid=' . $row[0] . '&classid=' . $row['cid'] . '"><label class="sbtn">Get Tarofa </label></a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';

                }
                ?>
                <style>
                    .sbtn {
                        margin: -10px 0px;
                        color: white;
                        padding: 8px 30px;
                        border-radius: 4px;
                        border: 1px solid #D93935;
                        background-color: #D93935;
                        transition: 0.9s cubic-bezier(0.075, 0.82, 0.165, 1);
                    }

                    .sbtn:hover {
                        color: #D93935;
                        cursor: pointer;
                        background-color: rgba(217, 57, 53, 0.01);
                    }

                    .seekbtns {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        transition: 0.9s cubic-bezier(0.075, 0.82, 0.165, 1);

                    }


                    .tphoto {

                        height: 45px;
                        width: 45px;
                        object-fit: cover;
                        margin: -10px -20px;
                        border-radius: 50%;
                        transition: 0.3s cubic-bezier(0.075, 0.82, 0.165, 1);
                    }

                    .tphoto:hover {
                        height: 100px;
                        width: 100px;
                        margin: -40px;
                        box-shadow: 1px 0px 60px 2px rgba(36, 36, 36, 0.322);
                        z-index: 1;
                        position: relative;
                    }

                    th {
                        background-color: #E7E7E8;
                    }

                    @media print {
                        body {
                            background-image: url(../backgrounds/bg3p.png);
                        }

                        .btnprint {
                            display: none;
                        }

                        .buttons, srch {
                            display: none;
                        }

                        html {
                            zoom: 80%;

                        }

                        .tablehead input, .srch {
                            display: none;
                        }

                        /*@page {*/
                        /*    size: landscape;*/
                        /*}*/
                        .maincontaner {
                            text-align: center;
                        }

                        .tablehead {
                            width: 100%;
                        }
                    }
                </style>
            </div>
        </div>
        <center>
            <div class="buttons">
                <a href="feepayment_list.php">
                    <button>Payment Records</button>
                </a>
                <a href="financesearch.php">
                    <button>Finance Board</button>
                </a>
                <a href="admindashboard.php">
                    <button>Dashboard</button>
                </a>
                <a href="">
                    <button>What you Need to be?</button>
                </a>
            </div>
        </center>
        <!-- printing data -->
        <div class="printdata">
            <?php
            require_once("loginPHP.php");
            echo "<h5>Sincerely </h5>";
            echo "<h5>" . $_SESSION['thename'] . "</h5>";
            echo "<h5>" . $_SESSION['thetype'] . "</h5>";
            date_default_timezone_set('Asia/kabul');
            echo date("Y/m/d") . " | " . date("h:i A");
            ?>
        </div>

</div>
<script src="../js/search.js"></script>
</body>
</html>
