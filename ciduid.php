<?php
$db = mysqli_connect('localhost', 'root', 'gU2N@ndA$', 'billspark');

if (!$db) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$uid = $_GET['uid'];

$query = "SELECT * FROM ciduid WHERE uid = '$uid'";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $cid = $row['cid1'];
    echo json_encode(["status" => "success", "cid" => $cid]);
} else {
    echo json_encode(["status" => "error", "message" => "CID not found"]);
}

mysqli_close($db);
?>
