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

if (isset($_GET['stdname'])) {
    $stdname = $_GET['stdname'];
    $rootid = $_GET['rootid'];
    $cname = $_GET['cname'];
    $cgender = $_GET['cgender'];
    $gname = $_GET['gname'];
    $getyear = explode('-', $_GET['cyear']);
    $cyear = $getyear[0];
    $scoreresult = $_GET['scoreresult'];
    $examtype = $_GET['examtype'];
    $scoreresult2 = $_GET['scoreresult2'];
} else {
    echo 'Couldnt get Data!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/result_list.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $stdname . ' ' . $rootid . ' ' . $gname . '-' . $cname . ' ' . $cgender . '  ' . $cyear ?> </title>

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
                <h3><?php echo $cyear ?> Students Results </h3>
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
                    $query = "";
                    if ($cname === 'all except change school') {
                        $query = "select * from selectresult where stdfullname like '%$stdname%' and stdenrolid like '%$rootid%' and cname !='change school' and gname !=0 and ccreatedate like '%$cyear%' and cgender like '$cgender%' and rexamtype like '%$examtype%'  and rscore >= '$scoreresult' and (rscore+roralscore+rpracticalscore+rhomeworkscore+ractivityscore) <='$scoreresult2'";
//                                echo $query;
                    } else {
                        $query = "select * from selectresult where stdfullname like '%$stdname%' and stdenrolid like '%$rootid%' and cname like '%$cname%' and gname like '%$gname%' and ccreatedate like '%$cyear%' and cgender like '$cgender%' and rexamtype like '%$examtype%' and rscore >= '$scoreresult' and (rscore+roralscore+rpracticalscore+rhomeworkscore+ractivityscore) <='$scoreresult2'";
//                                echo $query;
                    }

                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table  table-bordered  table-hover table-striped" style="font-size:15px;">';

                    echo '<thead >';
                    echo '<th></th>';
                    echo '<th>ID</th>';
                    echo '<th>Full Name</th>';
                    echo '<th>Father Name</th>';
//                    echo '<th>G/Father Name</th>';
//                    echo '<th style="text-align: right" >نام</th>';
//                    echo '<th style="text-align: right">نام پدر</th>';
//                    echo '<th style="text-align: right">نام پدر کلان</th>';
                    echo '<th>Profile</th>';
                    echo '<th>Class</th>';
                    echo '<th>Subject</th>';
                    echo '<th>Exam Type</th>';
                    echo '<th>Written Exam</th>';
                    echo '<th>Oral Exam</th>';
                    echo '<th>Practical Exam</th>';
                    echo '<th>Home Work</th>';
                    echo '<th>Activity</th>';
                    echo '<th>Total</th>';
                    echo '<th>Chance</th>';

                    echo '<th>Inserted Date</th>';
                    echo '<th>Update Date</th>';
                    echo '<th>Inserted By</th>';
                    echo '<th>Updated By</th>';
                    echo '<th>Describtion</th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td><a href="updateenrolstd.php?stdclassid=' . $row[0] . '&&stdname=' . $row[1] . '&&stdfname=' . $row[2] . '&&stdid=' . $row[7] . '&&stdrootid=' . $row[15] . '&&stdclass=' . $row[11] . '&&stdclassremark=' . $row[14] . '"><img class="btnprint" src="../icons/view.png"></a></td>';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[2] . '</td>';
//                        echo '<td>' . $row[3] . '</td>';
//                        echo '<td style="text-align: right">' . $row[4] . '</td>';
//                        echo '<td style="text-align: right">' . $row[5] . '</td>';
//                        echo '<td style="text-align: right">' . $row[6] . '</td>';

                        echo '<td><center><img class="tphoto" src=../stdimages/' . $row[7] . ' alt="No photo Found"></center></td>';
                        $year = explode("-", $row[11]);
                        if ($row[9] === '1') {
                            echo '<td>' . $row[9] . 'st ' . $row[10] . ' - ' . $year[0] . '</td>';
                        } elseif ($row[9] === '0') {
                            echo '<td>' . $row[10] . ' - ' . $year[0] . '</td>';
                        } elseif ($row[9] === '2') {
                            echo '<td>' . $row[9] . 'nd ' . $row[10] . ' - ' . $year[0] . '</td>';
                        } elseif ($row[9] === '3') {
                            echo '<td>' . $row[9] . 'rd ' . $row[10] . ' - ' . $year[0] . '</td>';
                        } elseif ($row[9] > 3) {
                            echo '<td>' . $row[9] . 'th ' . $row[10] . ' - ' . $year[0] . '</td>';
                        } else {
                            echo '<td>' . $row[9] . ' (' . $row[10] . ') - ' . $year[0] . '</td>';
                        }
                        echo '<td>' . $row[8] . '</td>';
                        echo '<td>' . $row[13] . '</td>';
                        echo '<td>' . $row[14] . '</td>';
                        echo '<td>' . $row[15] . '</td>';
                        echo '<td>' . $row[16] . '</td>';
                        echo '<td>' . $row[17] . '</td>';
                        echo '<td>' . $row[18] . '</td>';
                        echo '<td>' . intval($row[14] + $row[15] + $row[16] + $row[17] + $row[18]) . '</td>';
                        if ($row['rchance'] == 1) {
                            echo '<td>' . $row['rchance'] . 'st</td>';
                        } elseif ($row['rchance'] == 2) {
                            echo '<td>' . $row['rchance'] . 'nd</td>';
                        } elseif ($row['rchance'] == 3) {
                            echo '<td>' . $row['rchance'] . 'rd</td>';
                        } elseif ($row['rchance'] > 3) {
                            echo '<td>' . $row['rchance'] . 'th</td>';
                        }
                        echo '<td>' . $row[21] . '</td>';
                        echo '<td>' . $row[22] . '</td>';
                        echo '<td>' . $row[23] . '</td>';
                        echo '<td>' . $row[24] . '</td>';
                        echo '<td>' . $row[25] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';

                }
                ?>
                <style>
                    .btnprint {
                        height: 40px;
                        margin: -20px;
                    }

                    .btnprint:hover {
                        cursor: pointer;
                        outline: none;
                    }

                    .tphoto {

                        height: 45px;
                        width: 45px;
                        object-fit: cover;
                        margin: -10px;
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
                <a href="resultsearch.php">
                    <button>Resuls</button>
                </a>
                <a href="unenrloledstd.php">
                    <button>Students Out Of Class</button>
                </a>
                <a href="admindashboard.php">
                    <button>Dashboard</button>
                </a>
                <a href="">
                    <button onclick="window.print()">Print</button>
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
