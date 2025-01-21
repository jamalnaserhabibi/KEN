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
if (isset($_GET['depname'])) {
    $depname = $_GET['depname'];
} else {
    echo 'couldnt get department name';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/searchteacher.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher List</title>
</head>
<body>
<div class="maincontaner">

    <div class="top">
        <img src="../icons/mareflogo.png" alt="">
        <h2>Khana-e-Noor Private High School</h2>
        <img src="../icons/logo.png" alt="">
    </div>
    <div class="tblusers">
        <div class="tablehead">
            <h3>Teacher's information</h3>
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
                $query = "select * from selectteacher where depname='$depname'";
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
                echo '<th>Gender</th>';
                echo '<th>Date of Birth</th>';
                echo '<th>Profile</th>';
                echo '<th>Contact</th>';
                echo '<th>Email</th>';
                echo '<th>Department</th>';
                echo '<th>Address</th>';
                echo '<th>Contraction Duration</th>';
                echo '<th>Contraction Date</th>';
                echo '<th>Credit</th>';
                echo '<th>Education</th>';
                echo '<th>Gratuation Year</th>';
                echo '<th>University</th>';
                echo '<th>Faculty</th>';
                echo '<th>Nation ID number</th>';
                echo '<th>Remarks</th>';
                echo '</thead >';
                while ($row = $result->fetch()) {
                    echo '<tr style="text-transform: capitalize;">';
                    echo '<td><a href="teacherprofile.php?t0=' . $row[0] . '&&t1=' . $row[1] . '&&t2=' . $row[2] . '&&t3=' . $row[3] . '&&t4=' . $row[4] . '&&t5=' . $row[5] . '&&t6=' . $row[6] . '&&t7=' . $row[7] . '&&t8=' . $row[8] . '&&t9=' . $row[9] . '&&t10=' . $row[10] . '&&t11=' . $row[11] . '&&t12=' . $row[12] . '&&t13=' . $row[13] . '&&t14=' . $row[14] . '&&t15=' . $row[15] . '&&t16=' . $row[16] . '&&t17=' . $row[17] . '&&t18=' . $row[18] . '&&t19=' . $row[19] . '"><img class="btnprint" src="../icons/view.png"></a></td>';
                    echo '<td>' . $row[0] . '</td>';
                    echo '<td>' . $row[1] . '</td>';
                    echo '<td>' . $row[2] . '</td>';
                    echo '<td>' . $row[3] . '</td>';
                    echo '<td>' . $row[4] . '</td>';
                    echo '<td><center><img class="tphoto" src=../teacherimages/' . $row[17] . ' alt="No photo Found"></center></td>';
                    echo '<td>' . $row[15] . '</td>';
                    echo '<td>' . $row[14] . '</td>';
                    echo '<td>' . $row[8] . '</td>';
                    echo '<td>' . $row[13] . '</td>';
                    echo '<td>' . $row[5] . ' - Months</td>';
                    echo '<td>' . $row[6] . '</td>';
                    echo '<td>' . $row[7] . '</td>';
                    echo '<td>' . $row[9] . '</td>';
                    echo '<td>' . $row[10] . '</td>';
                    echo '<td>' . $row[11] . '</td>';
                    echo '<td>' . $row[12] . '</td>';
                    echo '<td>' . $row[16] . '</td>';
                    echo '<td>' . $row[18] . '</td>';
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
                }

                .tphoto {
                    height: 45px;
                    width: 45px;
                    object-fit: cover;
                    margin: -10px;
                    border-radius: 50%;
                }

                .tphoto:hover {
                    height: 100px;
                    width: 100px;
                    margin: -40px;
                }

                .tphoto:hover {
                    height: 100px;
                    width: 100px;
                    margin: -40px;
                    box-shadow: 1px 0px 60px 2px rgba(36, 36, 36, 0.322);
                }

                th {
                    background-color: #E7E7E8;
                }

                .tphoto {
                    height: 50px;
                    width: 50px;
                    object-fit: cover;
                    margin: -10px;
                    border-radius: 50%;
                    transition: 0.4s cubic-bezier(0.075, 0.82, 0.165, 1);
                }

                .tphoto:hover {
                    height: 100px;
                    width: 100px;
                    margin: -40px;
                    box-shadow: 1px 0px 60px 2px rgba(36, 36, 36, 0.322);
                    position: relative;
                    z-index: 1;
                }

                @media print {
                    .btnprint {
                        display: none;
                    }

                    .buttons, srch {
                        display: none;
                    }

                    html {
                        zoom: 60%;

                    }

                    .tablehead input, .srch {
                        display: none;
                    }


                    @page {
                        size: landscape;
                    }

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
            <a href="dep_list.php">
                <button>< Back</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="dep_list.php">
                <button>Departments</button>
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
