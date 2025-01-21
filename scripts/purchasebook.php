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
    <link rel="stylesheet" href="../css/purchasebook.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Book</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Purchase Book</h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <select name="bname" required="">
                    <option value="" disabled selected hidden>Select Book</option>
                    <?php
                    try {
                        require_once('connection.php');
                        $query = "select * from selectbook";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($row = $result->fetch()) {
                        if ($row[3] == 1) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[3] . 'st Grade</option>';
                        } elseif ($row[3] == 2) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[3] . 'nd Grade</option>';
                        } elseif ($row[3] == 3) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[3] . 'rd Grade</option>';
                        } elseif ($row[3] > 3) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[3] . 'th Grade</option>';
                        } else {
                            echo '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[3] . '</option>';
                        }
                    }
                    ?>
                </select><br>
                <input class="ttt small" step="10" type="number" max="10000" min="10" name="bpunitprice"
                       placeholder="Unite Price" required="">
                <input class="ttt small" step="1" type="number" max="10000" min="1" name="bquantity"
                       placeholder="Quantity" required=""><br>
                <input class="ttt small" type="text" name="bpfrom" placeholder="Purchase Address" required="">
                <input class="ttt small" type="text" name="bpto" placeholder="Purchased By" required=""><br>
                <input class="ttt" type="text" name="bpdate" placeholder="Purchase Date" onfocus="(this.type='date')"
                       required="">
                <input class="ttt" type="text" maxlength="50" name="bpremark" placeholder="Remarks"><br>
                <?php
                if (isset($_POST['bname'])) {
                    require("connection.php");
                    if (isset($_POST['btn-submit'])) {
                        try {
                            $query = "insert into tblbookpurchase (bid,bunitprice,bquantity,bpfrom,bpto,bpdate,bpremark) value(:bid,:bpunitprice,:bquantity,:bpfrom,:bpto,:bpdate,:bpremark)";
                            $stm = $connect->prepare($query);
                            $stm->bindValue(":bid", $_POST['bname']);
                            $stm->bindValue(":bpunitprice", $_POST['bpunitprice']);
                            $stm->bindValue(':bquantity', $_POST['bquantity']);
                            $stm->bindValue(':bpfrom', $_POST['bpfrom']);
                            $stm->bindValue(':bpto', $_POST['bpto']);
                            $stm->bindValue(':bpdate', $_POST['bpdate']);
                            $stm->bindValue(':bpremark', $_POST['bpremark']);
                            $stm->execute();
                            header("location: book_purchase_list.php");
                        } catch (PDOException $e) {
                            $e->getMessage();
                        }
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Purchase!"><br>
        </form>
        <div class="controls">
            <a href="book_purchase_list.php">
                <button class="bbb">< Back</button>
            </a>
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="book_list.php">
                <button class="bbb">Book List</button>
            </a>
            <a href="booksales.php">
                <button class="bbb">Sales List</button>
            </a>


        </div>
    </center>
</div>
</body>
</html>