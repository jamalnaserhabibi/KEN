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
    <link rel="stylesheet" href="../css/resultsheetsearch.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultsheet Search</title>
</head>
<body>
<?php
if (isset($_POST['btn-submit'])) {
    try {
        $classid = $_POST['classid'];
        header('Location: resultsheetview.php?classid=' . $classid . '');
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
?>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Please define the class to get the sheet</h4>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <!--                        <center><textarea class="ttt headofresult" type="text" name="toptext">-->
                <!--جمهوری اسلامی افغانستان-->
                <!--وزارت جلیله معارف-->
                <!--ریاست معارف ولایت بلخ-->
                <!--لیسه خصوصی خانه نور ۵-->
                <!--                        </textarea>-->
                <div class="mybox">

                    <div class="contain">
                        <label>Select Class</label>
                        <select class="ttt" name="classid" required="">
                            echo '
                            <option value="" disabled selected hidden>Select Class</option>
                            ';

                            <?php
                            require_once("connection.php");
                            try {
                                $query = "select * from selectstdclass where gname !='0' group by cid order by ccreatedate desc ";
                                $result = $connect->query($query);
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }

                            if (isset($result)) {
                                while ($row = $result->fetch()) {
                                    $year = explode("-", $row[9]);
                                    if ($row['gname'] == 1) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'st ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] == 2) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'nd ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] == 3) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'rd ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } elseif ($row['gname'] > 3) {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . 'th ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    } else {
                                        echo '<option value="' . $row['cid'] . '">' . $row['gname'] . ' ' . $row[8] . ' - ' . $row[10] . ' - ' . $year[0] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search">
        </form>
</div>
</body>
</html>


