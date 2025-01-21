<?php
require_once("connection.php");
if (isset($_GET['bpid'])) {
    $bpid = $_GET['bpid'];
    try {
        $query = "DELETE FROM `tblbookpurchase` where bpid=" . $bpid;
        $result = $connect->query($query);
        header("Location: book_purchase_list.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo '<h1 style="color: red;">ID not Found</h1>';

}
?>