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
if (isset($_GET['exname'])) {
    $exname = $_GET['exname'];
    $exby = $_GET['exby'];
    $exfrom = $_GET['exfrom'];
    $exminprice = $_GET['exminprice'];
    $exmaxprice = $_GET['exmaxprice'];
    $exstartdate = $_GET['exstartdate'];
    $exenddate = $_GET['exenddate'];
} else {
    $exname = "";
    $exby =    "";
    $exfrom = "";
    $exminprice ="";
    $exmaxprice = "";
    $exstartdate =  date('Y-m-d');
    $exenddate = date('Y-m-d');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/expenditure_list.css" media="all">
    <link rel="stylesheet" href="../css/userprnt.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenditure List</title>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {
            if (confirm('Do you want to delete (' + id + ') id?')) {
                window.location.href = 'deleteexpenditure.php?bpid=' + id;
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
            <h3>Expenditures List</h3>
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
                    if ($exminprice == '' and $exmaxprice != '') {
                        $query = "select * from tblexpenditures where exname like '%$exname%' and exby like '%$exby%' and exfor like '%$exfrom%' and exprice between 0 and '$exmaxprice' and exdate  between '$exstartdate' and '$exenddate'";
                    } elseif ($exmaxprice == '' and $exminprice != '') {
                        $query = "select * from tblexpenditures where exname like '%$exname%' and exby like '%$exby%' and exfor like '%$exfrom%' and exprice > '$exminprice'  and exdate  between '$exstartdate' and '$exenddate'";
                    } elseif ($exminprice == '' and $exmaxprice == '') {
                        $query = "select * from tblexpenditures where exname like '%$exname%' and exby like '%$exby%' and exfor like '%$exfrom%'  and exdate  between '$exstartdate' and '$exenddate'";
                    }
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table style="font-size: 14px" id="myTable" class="sortable table  table-bordered table-hover table-striped">';
                    echo '<thead >';
                    echo '<th>ID</th>';
                    echo '<th>Item Describtion</th>';
                    echo '<th>Ordered By</th>';
                    echo '<th>Requested By</th>';
                    echo '<th>Unite Price</th>';
                    echo '<th>Quantity</th>';
                    echo '<th>Total</th>';
                    echo '<th>Date</th>';
                    echo '<th>Remark</th>';
                    echo '<th class="operation"><center>Operations</center></th>';
                    echo '</thead >';
                    $grandtotatal = 0;

                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[0] . '</td>';
                        echo '<td>' . $row[1] . '</td>';
                        echo '<td>' . $row[2] . ' </th>';
                        echo '<td>' . $row[3] . ' </th>';
                        echo '<td>' . $row['exprice'] . ' </th>';
                        echo '<td>' . $row['exquantity'] . ' </th>';
                        $total = strval($row['exprice'] * $row['exquantity']);
                        $grandtotatal = $grandtotatal + $total;
                        echo '<td>' . $total . ' Afg </th>';
                        echo '<td>' . $row['exdate'] . ' </th>';
                        echo '<td>' . $row['exremarks'] . ' </th>';
                        echo '<td class="operation"><center><a class="lbtn update" href="update_expenditure.php?exid=' . $row[0] . '">Update</a>';
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
            <a href="create_expenditure.php">
                <button>New Record</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>

            <a href="expenditure_list.php">
                <button>Expenditure List</button>
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