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
    <link rel="stylesheet" href="../css/unpaidstudent_list.css" media="all">
    <link rel="stylesheet" href="../css/userprnt.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payments List</title>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {
            if (confirm('Do you want to delete (' + id + ') id?')) {
                window.location.href = 'deletepayment.php?bpid=' + id;
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
            <h3>Student Payment List</h3>
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

                $rootid = isset($_GET['rootid']) ? $_GET['rootid'] : '';
                $cyear = isset($_GET['cyear']) ? $_GET['cyear'] : 'All';
                $classname = isset($_GET['classname']) ? $_GET['classname'] : 'All';
                $gender =isset( $_GET['gender']) ? $_GET['gender'] : 'All';

                $query = "select * from selectunpaidstudents where 1=1 ";

                if (isset($rootid) and $rootid != '') $query .= "and stdenrolid = :rootid ";
                if (isset($cyear) and $cyear != 'All') $query .= "and YEAR(ccreatedate) = :cyear ";
                if (isset($classname) and $classname != 'All') $query .= "and classname = :classname ";
                if (isset($gender) and $gender != 'All') $query .= "and cgender = :gender ";

                $stmt = $connect->prepare($query);
                if (isset($rootid) and $rootid != '') $stmt->bindValue(':rootid', $rootid);
                if (isset($cyear) and $cyear != 'All') $stmt->bindValue(':cyear', $cyear);
                if (isset($classname) and $classname != 'All') $stmt->bindValue(':classname', $classname);
                if (isset($gender) and $gender != 'All') $stmt->bindValue(':gender', $gender);
                 $stmt->execute();

                if ($stmt->execute()) {
                    echo '<table style="font-size: 12px" id="myTable" class="sortable table  table-bordered table-hover table-striped">';
                    echo '<thead >';
                    echo '<th>ID</th>';
                    echo '<th> Name</th>';
                    echo '<th> F/Name</th>';
                    echo '<th>Profile</th>';
                    echo '<th>Class</th>';
                    echo '<th>Pay Amount</th>';
                    echo '<th>Pay Type</th>';
                    echo '<th class="operation"><center>Operations</center></th>';
                    echo '</thead >';
                    $grandtotatal = 0;
                    while ($row = $stmt->fetch()) {
                        // TODO: match column-names with data
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row['dstdfullname'] . '</td>';
                        echo '<td>' . $row['gid'] . '</td>';
                        echo '<td>' . $row['stdenrolid'] . ' </td>';
                        echo '<td>' . $row['ccreatedate'] . ' </td>';
                        echo '<td>' . $row['cgender'] . ' </td>';
                        echo '<td>' . $row['classname'] . ' </td>';
                        echo '<td>' . $row['paid'] . ' </td>';
                        echo '<td>' . $row['payable'] . ' </td>';
                        $grandtotatal = $grandtotatal + $row['paid'];
                        echo '<td class="operation"><center><a class="lbtn update" href="updatepaymentbale.php?pid=' . $row[0] . '">Update</a>';
                        echo '<a class="lbtn" href="javascript:delete_id(' . $row[0] . ')">Delete</a></center></td>';
                        echo '  </tr>';

                    }
                    echo '</table>';
                    echo '<span style="color: #D93935; font-weight: bold"; >- Total Amount: ' . $grandtotatal . ' Afg -</span>';
                }
                ?>
            </div>
        </center>
    </div>
    <center>
        <div class="buttons">
            <a href="addnewpayment.php">
                <button>New Payment</button>
            </a>


            <a href="financesearch.php">
                <button>Finance Board</button>
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
<style>
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