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
require_once('connection.php');
if (isset($_GET['bid'])) {
    $bid = $_GET['bid'];
    $bname = $_GET['bname'];
    $bimage = $_GET['bimage'];
    $bprice = $_GET['bprice'];
    $bcurri = $_GET['bcurri'];
    $bgradeid = $_GET['bgradeid'];
    $bremark = $_GET['bremark'];
} else {
    echo 'Cant get data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatebook.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $bname ?> Book</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Update <?php echo $bname ?> Book</h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <input value="<?php echo $bname ?>" class="ttt" type="text" name="bname" placeholder="Book Full Name"
                       required=""><br>
                <select class="ttt" name="bgradeid" required="">
                    <?php
                    require_once("connection.php");
                    try {
                        $query = "select * from tblgrade where gname !='0'";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    if (isset($result)) {
                        while ($row = $result->fetch()) {
                            if ($row[1] == 1) {
                                echo '<option value="' . $row[0] . '">1st Grade</option>';
                                if ($row[1] == $bgradeid) echo '<option value="' . $row[0] . '" selected>1st Grade</option>';;
                            } elseif ($row[1] == 2) {
                                echo '<option value="' . $row[0] . '">2nd Grade</option>';
                                if ($row[1] == $bgradeid) echo '<option value="' . $row[0] . '" selected>2nd Grade</option>';;
                            } elseif ($row[1] == 3) {
                                echo '<option value="' . $row[0] . '">3rd Grade</option>';
                                if ($row[1] == $bgradeid) echo '<option value="' . $row[0] . '" selected>3rd Grade</option>';;
                            } elseif ($row[1] > 3) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . 'th Grade</option>';
                                if ($row[1] == $bgradeid) echo '<option value="' . $row[0] . '" selected>' . $row[1] . 'th Grade</option>';;
                            } else {
                                echo '<option value="' . $row[0] . '">' . $row[1] . ' </option>';
                                if ($row[1] == $bgradeid) echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';;
                            }
                        }
                    }
                    ?>
                </select><br>
                <select name="bcurri" required="">
                    <option value="" disabled selected hidden> Select Curriculum</option>
                    <option <?php if ($bcurri == 'Cambridge') {
                        echo 'selected';
                    } ?> >Cambridge
                    </option>
                    <option <?php if ($bcurri == 'Maaref') {
                        echo 'selected';
                    } ?> >Maaref
                    </option>
                    <option <?php if ($bcurri == 'Other') {
                        echo 'selected';
                    } ?> >Other
                    </option>
                </select><br>
                <input value="<?php echo $bprice ?>" class="ttt" step="10" type="number" max="10000" min="10"
                       name="bprice" placeholder="Unite Price" required=""><br>
                <input value="<?php echo $bremark ?>" class="ttt" type="text" maxlength="50" name="bremark"
                       placeholder="Remarks"><br>
                <input type="file" name="imageupload" class="filebtn" accept=".jpg,.jpeg,.png"
                       onchange="loadFile(event)"><br>
                <img style="height: 320px;width:320px; object-fit: cover;" id="output"
                     src="../bookimages/<?php echo $bimage ?>" alt=""><br>

                <?php
                if (isset($_POST['bname'])) {
                    require("connection.php");
                    try {
                        $bname = $_POST['bname'];
                        $bgradeid = $_POST['bgradeid'];
                        $stmt = $connect->prepare("SELECT `bfullname`, `bgradeid` FROM `tblbook` WHERE  `bfullname`=:bfname And `bgradeid` = :bgrade and bid !=:bid");
                        $stmt->bindValue(":bid", $bid);
                        $stmt->bindValue(':bfname', $bname);
                        $stmt->bindValue(':bgrade', $bgradeid);
                        $stmt->execute();
                        //check existence of data end...
                        if ($stmt->rowCount() == 0) {
                            try {
                                if (isset($_POST['btn-submit'])) {
                                    try {
                                        $query = "UPDATE `tblbook` SET `bfullname`=:bname, `bimage`=:bimage,`bgradeid`=:bgradeid ,`bcurriculum`=:bcurri ,`bprice`=:bprice ,`bremark`=:bremark   WHERE bid=:bid";
                                        $stm = $connect->prepare($query);
                                        $stm->bindValue(":bid", $bid);
                                        $stm->bindValue(":bname", $bname);
                                        $stm->bindValue(":bimage", $bid);
                                        $stm->bindValue(":bgradeid", $bgradeid);
                                        $stm->bindValue(':bcurri', $_POST['bcurri']);
                                        $stm->bindValue(':bprice', $_POST['bprice']);
                                        $stm->bindValue(':bremark', $_POST['bremark']);
                                        $stm->execute();

                                        if ($_FILES['imageupload']['tmp_name'] != "") {
                                            if (file_exists("../bookimages/$bid")) {
                                                unlink("../bookimages/$bid");
                                                $temp = $_FILES['imageupload']['tmp_name'];
                                                move_uploaded_file($temp, "../bookimages/" . $bid);
                                            };
                                        }

                                        header("location: book_list.php");
                                    } catch (PDOException $e) {
                                        $e->getMessage();
                                    }
                                }

                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }

                        } else {
                            echo '<h6 style="color: red;margin-left:13%;">This Book on the selected grade is already exist!</h6>';
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Update"><br>
        </form>
        <script> //load file-image to img tag
            var loadFile = function (event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };
        </script>
        <div class="controls">
            <a href="book_list.php">
                <button class="bbb">< Back</button>
            </a>
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="booksales.php">
                <button class="bbb">Sales List</button>
            </a>
            <a href="bookpurchase">
                <button class="bbb">Purchase List</button>
            </a>

        </div>
    </center>
</div>
</body>
</html>