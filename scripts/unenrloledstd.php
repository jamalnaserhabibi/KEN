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


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/unenrloledstd.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unenroled Students</title>
    <script src="../js/sorttable.js"></script>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <!-- <h3>Islamic Republic of Afghanistan</h3> -->
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="tbldepartments">
            <div class="tablehead">
                <h3 style="text-align: left;">Unenroled Students</h3>
                <div class="seek">
                    <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                           placeholder="Search">
                    <img class="srch" src="../icons/srch.png" alt="">
                    <span id="record-count"></span>
                </div>
            </div>
            <div class="data">
                <?php
                require_once("connection.php");
                //
                try {
                    $query = "SELECT * FROM selectunenroledstudent ";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table  table-bordered table-hover table-striped ">';
                    echo '<thead >';
                    echo '<th>Full Name</th>';
                    echo '<th>Father Name</th>';
                    echo '<th>G/Father Name</th>';
                    echo '<th style="text-align: right">نام</th>';
                    echo '<th style="text-align: right">نام پدر</th>';
                    echo '<th style="text-align: right">نام پدرکلان</th>';
                    echo '<th>Profile</th>';
                    echo '<th>Root ID</th>';
                    echo '<th>Reg  Date</th>';
                    echo '<th class="oper">Operations</th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[2] . '</td>';
                        echo '<td>' . $row[3] . '</td>';
                        echo '<td style="text-align: right">' . $row[4] . '</td>';
                        echo '<td style="text-align: right">' . $row[5] . '</td>';
                        echo '<td style="text-align: right">' . $row[6] . '</td>';
                        echo '<td><center><img class="tphoto" src=../stdimages/' . $row[7] . ' alt="No photo Found"></center></td>';
                        echo '<td >' . $row[8] . '</td>';
                        echo '<td>' . $row[9] . '</td>';
                        echo '<td class="oper"><center><a class="lbtn update" href="enrolstudent.php?stdname=' . $row[1] . '&&stdfname=' . $row[2] . '&&stdid=' . $row[7] . '&&stdrootid=' . $row[8] . '">Enrol</a>';
                        echo '  </tr>';
                    }
                    echo '</table>';
                }
                ?>
                <!-- style of delete and update btns -->
                <style>
                    .tphoto {
                        height: 50px;
                        width: 50px;
                        object-fit: cover;
                        margin: -10px;
                        border-radius: 50%;
                    }

                    th {
                        background-color: #E7E7E8;
                    }

                    @media print {
                        .buttons, .oper, .srch {
                            display: none;
                        }

                        html {
                            zoom: 70%;
                        }
                    }


                    .lbtn {
                        margin-right: 10px;
                        border: 1px solid rgba(226, 0, 0, 0.74);
                        color: red;
                        padding: 8px 20px;
                        border-radius: 10px;
                    }

                    .lbtn:hover {
                        background-color: rgba(226, 0, 0, 0.5);
                        border: none;
                        text-decoration: none;
                        color: white;
                    }

                    .update {

                        border: 1px solid #107C41;
                        color: #107C41;
                    }

                    .update:hover {
                        background-color: #107C41;
                        border: none;
                    }
                </style>
                </script>
            </div>
        </div>
        <div class="buttons">
            <a href="student_list.php">
                <button>Student List</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="stdclasssearch.php">
                <button>Student Class</button>
            </a>
            <a href="">
                <button onclick="window.print()">Print</button>
            </a>
        </div>
    </center>
</div>
<script src="../js/search.js"></script>
</body>
</html>