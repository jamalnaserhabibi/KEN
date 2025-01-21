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

if (isset($_GET['classid'])) {
    $classid = $_GET['classid'];
} else {
    echo 'Couldnt get Data!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/resultsheetview.css" media="all">
    <link rel="stylesheet" href="../css/resultsheetviewPrint.css" media="print">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/sorttable.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Class Id: ' . $classid ?></title>
</head>
<body>
<div class="maincontaner">
    <div class="top">
        <img src="../icons/mareflogo.png" alt="">
        <div>
           <textarea class="ttt headofresult" type="text" name="toptext">
    دولت جمهوری اسلامی افغانستان
    وزارت جلیله معرف
   ریاست معارف ولایت بلخ
    لیسه عالی خصوصی خانه نور ۵
                  </textarea>
        </div>
        <img src="../icons/logo.png" alt="">
    </div>

    <div class="tblusers">
        <!--        <center><h4 class="titleonview">--><?php //echo 'Class ' ?><!--</h4></center>-->
        <div style="display: flex; flex-direction: row; margin: 10px 0px;">
              <textarea class="ttt headofresult2 lefttext " type="text" name="toptext">
    "ممتحن: جمال ناصر "حبیبی
    "ممیز: جمال ناصر "حبیبی

                  </textarea>

            <textarea class="ttt headofresult2 cnter" type="text" name="toptext">
    امتحان سالانه
    تاریخ: ۱۴۰۰/۵/۵
                  </textarea>
            <textarea class="ttt headofresult2 " type="text" name="toptext">
    مضمون: کمپیوتر
    صنف: دوازدهم الف
                  </textarea>
        </div>
        <div class="data" id="ajxdata">
            <?php
            require_once("connection.php");

            try {
                $query = "select dstdfullname,dstdgfname from selectstdclass where cid='$classid' and gname !='0'";
//                    echo $query;
                $result = $connect->query($query);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            if (isset($result)) {
                $number = 0;
                echo '<table style="text-align: right" id="myTable" class="sortable   table-bordered table-hover ">';
                echo '<thead >';
                echo '<th>ملاحظات</th>';
                echo '<th>مجموعه</th>';
                echo '<th>وظیفه خانگی</th>';
                echo '<th>فعالیت صنفی</th>';
                echo '<th>عملی</th>';
                echo '<th>تقریری</th>';
                echo '<th>تحریری</th>';
                echo '<th class="stdname">نام پدر</th>';
                echo '<th class="stdname">نام</th>';
                echo '<th class="smalltd">شماره</th>';
                echo '</thead >';
                while ($row = $result->fetch()) {
                    $number++;
                    echo '<tr>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td class="stdname">' . $row[1] . '</td>';
                    echo '<td class="stdname">' . $row[0] . '</td>';
                    echo '<td class="smalltd" >' . $number . '</td>';
                    echo '</tr>';


                }
                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td class="stdname"></td>';
                echo '<td class="stdname"></td>';
                echo '<td class="smalltd" >   </td>';
                echo '</tr>';
                echo '</table>';

            }

            ?>
            <textarea class="ttt headofresult2 " type="text" name="toptext">
.قرار شرح فوق جدول نمرات مضمون کمپیوتر بر حسب لیاقت شاگردان به قلم خودم درج گردیده صحت است       </textarea>
        </div>
        </center>
    </div>
    <center>
        <div class="buttons">
            <a href="resultsheetsearch.php">
                <button> < Back</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="">
                <button onclick="window.print()">Print</button>
            </a>
            <a href="examination.php">
                <button>Examination</button>
            </a>
        </div>
    </center>
</div>
<style>
    th {
        background-color: #E7E7E8;
    }

    #myTable {
        width: 100%;
        font-size: 18px;
    }

    td, th {
        padding: 2px 4px;
    }

    .smalltd {
        width: 70px;
        text-align: center;
    }

    .stdname {
        width: 190px;
    }

</style>
<script src="../js/search.js"></script>
</body>
</html>