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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once("connection.php");
if (isset($_POST['save'])) {
    $path = "userimages/";
    $image_name = $_POST['uname'];
    $name = $_FILES['imageupload']['name'];//Name of the File
    $imgExten = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $filename = $image_name . "." . $imgExten;
    $temp = $_FILES['imageupload']['tmp_name'];
    if (move_uploaded_file($temp, $path . $filename)) {
        $stm = $connect->prepare("insert into userimage (uname,iname) values(:iiname,:iimage)");
        $stm->bindValue(':iiname', $image_name);
        $stm->bindValue(':iimage', $image_name);
        $stm->execute();
        echo "success";
    } else {
        echo "failed";
    }
}
?>
<form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="uname">
    <input type="file" name="imageupload">
    <input type="submit" name="save" value="submit">
</form>
</body>
</html>