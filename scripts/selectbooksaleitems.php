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
/////////cash removal////////////////////
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/selectbooksaleitems.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Items</title>
</head>
<body>
<div style="text-align: center">

    <div class="maincontaner">
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>

        <div class="tblusers zero">
            <?php
            require_once("connection.php");
            try {
                $query = "select *  from tblbooksales order by saledate desc ";
                $result = $connect->query($query);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            if (isset($result)) {
                $row = $result->fetch();
                echo '<h5>● Buyer Profile ●</h5>';
                echo '<td><center><img class="buyer" src="../stdimages/' . $row['buyerid'] . '" alt="" ></center></td>';
                echo '</br>';
                echo '<h5>● Student Name ● </h5>';
                echo '<h4>' . $row['buyername'] . '</h4>';
                echo '<h5>● Sale Date ●</h5>';
                $dateandtime = explode(' ', $row['saledate']);
                echo '<p>' . $dateandtime[0] . '</br>' . $dateandtime[1] . '</p>';
                $buyerid = $row[0];
            }
            ?>
        </div>


        <div style="display: flex; flex-direction: row">
            <div class="tblusers first">
                <div class="tablehead">
                    <h4>Select Book For Sale</h4>
                    <div class="seek">
                        <img class="srch" src="../icons/srch.png" alt="">
                        <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                               placeholder="Search">
                        <span style="color: black" id="record-count"></span>
                    </div>
                </div>
                <div class="data">
                    <?php
                    require_once("connection.php");

                    try {
                        $query = "select * from selectbook";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        echo '<table style="font-size: 14px" id="myTable" class="sortable table  table-bordered table-hover table-striped">';
                        echo '<thead >';
                        echo '<th>FullName</th>';
                        echo '<th>Cover</th>';
                        echo '<th>Grade</th>';
                        echo '<th>Curriculum</th>';
                        echo '<th>Price</th>';
                        echo '<th>Sale</th>';
                        echo '</thead >';
                        while ($row = $result->fetch()) {
                            echo '<tr style="text-transform: capitalize;">';
                            echo '<td>' . $row[1] . '</td>';
                            echo '<td><center><img class="tphoto" src="../bookimages/' . $row[2] . '" alt="" ></center></td>';
                            if ($row[3] == 1) {
                                echo '<td>' . $row[3] . 'st</th>';
                            } elseif ($row[3] == 2) {
                                echo '<td>' . $row[3] . 'nd</th>';
                            } elseif ($row[3] == 3) {
                                echo '<td>' . $row[3] . 'rd</th>';
                            } elseif ($row[3] > 3) {
                                echo '<td>' . $row[3] . 'th</th>';
                            } else {
                                echo '<td>' . $row[3] . '</th>';
                            }
                            echo '<td>' . $row[4] . '</th>';
                            echo '<td>' . $row[5] . ' Afg</th>';
                            echo '<td><a href="addbookitem.php?buyerid=' . $buyerid . '&itemid=' . $row[0] . '"><label class="btnsale">Add +</label></a></td>';
                            echo '  </tr>';
                        }
                        echo '</table>';
                    }
                    ?>

                </div>
            </div>

            <div class="tblusers second">
                <div class="tablehead">
                    <h3>Sold Book</h3>
                </div>
                <div class="data">
                    <?php
                    try {
                        $query = "select * from selectsoldbookitems";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        echo '<table style="font-size: 14px" id="myTable" class="sortable table  table-bordered table-hover table-striped">';
                        echo '<thead >';
                        echo '<th>FullName</th>';
                        echo '<th>Image</th>';
                        echo '<th>Grade</th>';
                        echo '<th>Curriculum</th>';
                        echo '<th>Price</th>';
                        echo '</thead >';
                        while ($row = $result->fetch()) {
                            echo '<tr style="text-transform: capitalize;">';
                            echo '<td>' . $row[1] . '</td>';
                            echo '<td><center><img class="tphoto" src="../bookimages/' . $row[2] . '" alt="" ></center></td>';
                            if ($row[3] == 1) {
                                echo '<td>' . $row[3] . 'st Grade</th>';
                            } elseif ($row[3] == 2) {
                                echo '<td>' . $row[3] . 'nd Grade</th>';
                            } elseif ($row[3] == 3) {
                                echo '<td>' . $row[3] . 'rd Grade</th>';
                            } elseif ($row[3] > 3) {
                                echo '<td>' . $row[3] . 'th Grade</th>';
                            } else {
                                echo '<td>' . $row[3] . '</th>';
                            }
                            echo '<td>' . $row[4] . '</td>';
                            echo '<td>' . $row[5] . '</td>';
                            echo '  </tr>';
                        }
                        echo '</table>';
                    }

                    ?>
                </div>
            </div>
        </div>


        <div class="buttons" style="text-align: center;">
            <a href="stdclasssearch.php">
                <button>Student Class</button>
            </a>
            <a href="">
                <button onclick="window.print()">Print</button>
            </a>
        </div>
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
</div>
<style>
    .btnprint {
        height: 40px;
    }

    .btnsale {
        width: 80px;
        margin: -10px;
        background-color: #D93935;
        padding: 10px 15px;
        text-decoration: none;
        color: white;
        border-radius: 15px;
        transition: 0.4s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .btnsale:hover {
        background-color: rgba(217, 57, 53, 0.75);
        border-radius: 20px;
        text-decoration: none;
        color: white;
    }

    .buyer {
        margin: 5px;
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50px;
        transition: 0.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .zero {
        height: auto;
        display: flex;
        flex-direction: row;
        border: 1px solid #D93935;
        margin: 85px 0px 0px 0px;
    }

    h5 {
        color: #D93935;
    }

    td {
        font-size: 14px;
        text-align: left;
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
        transition: 0.3s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .tphoto:hover {
        height: 100px;
        width: 100px;
        margin: -40px;
        box-shadow: 1px 0px 60px 2px rgba(36, 36, 36, 0.322);
        position: relative;
        z-index: 1;
    }


    th {
        background-color: #E7E7E8;
    }

    @media print {
        .btnprint {
            display: none;
        }

        .top {
            align-items: start;
        }

        .buttons {
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
<script src="../js/search.js"></script>
</body>
</html>
