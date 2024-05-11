<?php
$conn = mysqli_connect("localhost", "root", "gU2N@ndA$", "billspark");

$query = "SELECT date_time, recharge_amount FROM history";
$result = mysqli_query($conn, $query);

$historyData = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $historyData[] = $row;
  }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($historyData);
?>
