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
    <link rel="stylesheet" href="../css/user_list.css" media="all">
    <link rel="stylesheet" href="../css/userprnt.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Lists</title>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {
            if (confirm('Do you want to delete (' + id + ') id?')) {
                window.location.href = 'deleteuser.php?userid=' + id;
            }
        }
    </script>
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
            <h3>User's information</h3>
            <div class="seek">
                <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                       placeholder="Search">
                <img src="../icons/srch.png" alt="">
                <span> </span>
                <span id="record-count"></span>
            </div>
        </div>
        <center>
            <div class="data" id="ajxdata">
                <?php
                require_once("connection.php");

                try {
                    $query = "select * from tbluser";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table  table-bordered table-hover table-striped">';
                    echo '<thead >';
                    echo '<th>User ID</th>';
                    echo '<th>User Name</th>';
                    echo '<th>User Authority</th>';
                    echo '<th>Profile Picture</th>';
                    echo '<th>Create Date</th>';
                    echo '<th><center>Operations</center></th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<a href="book.php?id="' . $row[0] . '"><tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[3] . '</td>';
                        echo '<td><center><img class="tphoto" src="../userimages/' . $row[4] . '" alt="" ></center></td>';

                        echo '<td>' . $row[5] . '</th>';
                        echo '<td><center><a class="lbtn update" href="updatesignup.php?uuid=' . $row[0] . '&&uuname=' . $row[1] . '&&uupassword=' . $row[2] . '&&uuauthority=' . $row[3] . '&&uuphoto=' . $row[4] . '">Update</a>';

                        if ($_SESSION["thid"] != $row[0]) {
                            echo '<a class="lbtn" href="javascript:delete_id(' . $row[0] . ')">Delete</a></center></td>';
                        }
                        echo '  </tr></a>';
                    }
                    echo '</table>';
                }

                ?>
            </div>
        </center>
    </div>
    <center>
        <div class="buttons">
            <a href="signUp.php">
                <button>Create New User</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="">
                <button onclick="window.print()">Print</button>
            </a>
            <a href="login.php">
                <button>Log Out</button>
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
<style>
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

    th {
        background-color: #E7E7E8;
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
<script src="../js/search.js"></script>
</body>
</html>