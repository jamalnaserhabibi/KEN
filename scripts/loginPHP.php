<?php
if (isset($_POST['uname']) && isset($_POST['upass'])) {
    require_once("connection.php");
    $uname = $_POST['uname'];
    $upass = $_POST['upass'];
    try {
        //super user
        if ($_POST['uname'] == 'superuser' && $_POST['upass'] == 'kenjnh') {
            header("Location:admindashboard.php");
            session_start();
            $_SESSION['thid'] = '0';
            $_SESSION['thename'] = 'Super User';
            $_SESSION['thetype'] = 'Administrator';
            $_SESSION['thephoto'] = 'user.png';
        }
        //end super user


        $result = $connect->prepare('select * from tbluser where username=:uname');
        $result->bindValue(':uname', $uname);
        $result->execute();


        if (
            isset($result) and
            $result->rowCount() > 0 and
            $row = $result->fetch() and
            password_verify($upass, $row["userpassword"])
        ) {
            if ($row[3] == 'Administrator') {
                header("Location:admindashboard.php");
            } elseif ($row[3] == 'Finance') {
                header("Location:financedashboard.php");
            } elseif ($row[3] == 'Book Shop') {
                header("Location:bookshopdashboard.php");
            } elseif ($row[3] == 'Human Resource') {
                header("Location:hrdashboard.php");
            } elseif ($row[3] == 'Teacher') {
                header("Location:teacherdashboard.php");
            } elseif ($row[3] == 'Head Master') {
                header("Location:headmasterdashboard.php");
            } else echo "<script>alert('wrong info')</script>";
            session_start();
            $_SESSION['thid'] = $row[0];
            $_SESSION['thename'] = $row[1];
            $_SESSION['thetype'] = $row[3];
            $_SESSION['thephoto'] = $row[4];
        } else {
            echo "<h1 style='margin:10px;font-size:20px; color:Blue ; padding:0px'>Password or Username is incorrect!</h1>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
       