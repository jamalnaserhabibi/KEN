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
require_once("connection.php");

if (isset($_POST['list'])) {
    try {
        $connect->beginTransaction();
        foreach ($_POST['list'] as $value) {
            $remark = $value['remark'];
            $actScore = $value['act-score'];
            $hmScore = $value['hm-score'];
            $score = $value['score'];
            $rid = $value['rid'];
            $insertquery = "UPDATE `tblresults` set `rscore`=:rscore,`rhomeworkscore`=:rhomeworkscore,`ractivityscore`=:ractivityscore, `rremark`=:rremark, `rupdateby`=:rinsertby, `rupdatedate`=current_timestamp() where rid=:rid";
            $stmt = $connect->prepare($insertquery);
            $stmt->bindValue(':rid', $rid);
            $stmt->bindValue(':rscore', $score);
            $stmt->bindValue(':ractivityscore', $actScore);
            $stmt->bindValue(':rhomeworkscore', $hmScore);
            $stmt->bindValue(':rremark', $remark);
            $stmt->bindValue(':rinsertby', $_SESSION['thid']);
            $stmt->execute();
            if ($stmt->errorCode() > 0) {
                print_r($stmt->errorInfo());

            }

        }


        // commit the transaction
        $connect->commit();
        echo 'The amount has been transferred successfully';
    } catch (PDOException $e) {
        $connect->rollBack();
        die($e->getMessage());
    }

}


if (isset($_GET['classid'])) {
    $classid = $_GET['classid'];
    $subjectid = $_GET['subjectid'];
    $scoretype = $_GET['scoretype'];
    $chance = $_GET['chance'];

    try {
        require_once('connection.php');
        $query = "select gname,cname,ccreatedate,cgender from selectclass where cid='$classid'";
        $result = $connect->query($query);
        while ($row = $result->fetch()) {
            $year = explode('-', $row[2]);
            if ($row[0] == 1) {
                $cfullname = $row[0] . 'st ' . $row[1] . ' ' . $year[0] . ' ' . $row[3];
            } elseif ($row == 2) {
                $cfullname = $row[0] . 'nd ' . $row[1] . ' ' . $year[0] . ' ' . $row[3];
            } elseif ($row == 3) {
                $cfullname = $row[0] . 'rd ' . $row[1] . ' ' . $year[0] . ' ' . $row[3];
            } elseif ($row > 3) {
                $cfullname = $row[0] . 'th ' . $row[1] . ' ' . $year[0] . ' ' . $row[3];
            } else {
                $cfullname = $row[0] . ' ' . $row[1] . ' ' . $year . [0] . ' ' . $row[3];
            }
        }
        $query = "select subname from tblsubject where subid='$subjectid'";
        $result = $connect->query($query);
        while ($row = $result->fetch()) {

            $subname = $row[0];

        }

//        $getquery = "select * from selectdiwanatable where cid='$classid' and rsubid='$subjectid' and rexamtype='$scoretype' and rchance='$chance'";
//        $getresult = $connect->query($getquery);
//        if($getresult->rowCount()==0){
//            $stdscore= '0';
//            $stdhomeworkscore= '2';
//            $stdactivityScore= '2';
//            $stdchance= '1';
//            $stdrremark= '';
//        }elseif ($getresult->rowCount()>0){
//            while ($row = $getresult->fetch()) {
//                $stdscore= $row['rscore'];
//                $stdhomeworkscore= $row[17];
//                $stdactivityScore= $row[18];
//                $stdchance= $row['rchance'];
//                $stdrremark= $row['rremark'];
//            }
//        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/insertresult_written.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/sorttable.js"></script>
    <title><?PHP echo $cfullname . ' Subject ' . $subname ?></title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <div class="inspection">
            <div class="circle"></div>
            <h6>Inspecting</h6>
        </div>
        <h4>Student's Mark Entrance Form</h4>
        <div class="resultinfo">
            <h5>Subject: <span><?PHP echo $subname ?></span></h5>
            <h5>Class: <span><?PHP echo $cfullname ?></span></h5>
            <h5>Exam: <span>Mid Term</span></h5>
        </div>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <?php
                try {
//                    $query = "select stdenrolid,dstdfullname,dstdfname,stdclassid  from selectstdclass where cid ='$classid' order by dstdfullname ";
                    $query = "select * from selectdiwanatable where cid='$classid' and rsubid='$subjectid' and rexamtype='$scoretype' and rchance='$chance' order by dstdfullname ";
                    $result = $connect->query($query);

                    if (isset($result)) {
                        echo '<table id="myTable" class="sortable   table-hover" style="font-size:20px;border-radius: 5px; width: 100%; text-align: right">';
                        echo '<thead >';
                        echo '<th class="values">ملاحظات</th>';
                        echo '<th class="values">چانس</th>';
                        echo '<th class="values">فعالیت صنفی</th>';
                        echo '<th class="values">وظیفه خانگی</th>';
                        echo '<th class="values circled">تحریری</th>';
                        echo '<th style="background-color: rgba(173,145,145,0); border-radius: 50%;"> </th>';
                        echo '<th class="circled2">نام پدر</th>';
                        echo '<th>نام</th>';
                        echo '<th>نمبر اساس</th>';
                        echo '<th>شماره</th>';
                        echo '</thead >';
                        $number = 0;
                        while ($row = $result->fetch()) {
                            $number++;
                            echo '<tr style="text-transform: capitalize;">';
                            echo '<td class="values"><input class="ttt"  type="text" minlength="30"  name="list[' . $row['stdclassid'] . '][remark]" value="' . $row['rremark'] . '" placeholder="ملاحظات" ></td>';
                            echo '<input type="hidden" name="list[' . $row['stdclassid'] . '][rid]" value="' . $row['rid'] . '">';
                            echo '<input type="hidden" name="list[' . $row['stdclassid'] . '][stdclass_id]" value="' . $row['stdclassid'] . '">';
                            echo '<input type="hidden" name="list[' . $row['stdclassid'] . '][subject_id]" value="' . $subjectid . '">';
                            echo '<input type="hidden" name="list[' . $row['stdclassid'] . '][chance]" value="' . $chance . '">';
                            echo '<td class="values">
<input class="ttt" type="number" min="1" max="3" value=' . $row['rchance'] . ' disabled="" step="1"  name="list[' . $row['stdclassid'] . '][chance]" required=""></td>';
                            echo '<td class="values">
<input class="ttt" type="number" min="0" max="2" value=' . $row['ractivityscore'] . ' step="1"  name="list[' . $row['stdclassid'] . '][act-score]" required=""></td>';
                            echo '<td class="values"><input class="ttt" type="number" min="0" max="2" value=' . $row['rhomeworkscore'] . ' step="1"  name="list[' . $row['stdclassid'] . '][hm-score]" required=""></td>';
                            echo '<td class="values circled"><input class="ttt" type="number" min="0" max="36" value=' . $row['rscore'] . ' step="1"  name="list[' . $row['stdclassid'] . '][score]" required=""></td>';
                            echo '<td style="background-color: rgba(173,145,145,0); border-radius: 50%; "> </td>';
                            echo '<td class="circled2">' . $row['dstdfname'] . '</td>';
                            echo '<td >' . $row['dstdfullname'] . '</td>';
                            echo '<td>' . $row['stdenrolid'] . '</td>';
                            echo '<td>' . $number . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Save">
        </form>
        <style>
            th {
                text-align: center;
                background-color: rgba(0, 0, 0, 0.048);
            }

            table {
                border-collapse: separate;
                border-spacing: 0px 10px;
            }

            tr {
                border-radius: 10px;
                background-color: white;
                padding: 5px;
                margin-top: 5px;

            }


            td:first-child {
                border-radius: 20px 0 0 20px;
            }

            td:last-child {
                border-radius: 0 20px 20px 0;
            }

            td, th {
                height: 60px;
                padding: 5px 15px;
            }

            th:first-child {
                border-radius: 20px 0 0 20px;
            }

            th:last-child {
                border-radius: 0 20px 20px 0;
            }

            tr:first-child:hover {
                background-color: rgba(0, 0, 0, 0.10);
            }

            .circled {
                border-radius: 0 20px 20px 0;

            }

            .circled2 {
                border-radius: 20px 0 0 20px;
            }

        </style>

</div>
</body>
</html>

