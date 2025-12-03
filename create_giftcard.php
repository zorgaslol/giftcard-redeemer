<?php
include "database.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("Invalid request");
}

if(!isset($_POST['tier_id'])){
    die("TIER NOT SELECTED");
}

$tier_id = (int)$_POST["tier_id"];

$sql = "SELECT id, name, value FROM `giftcards-tiers` WHERE id = $tier_id and is_active = 1";
$result = mysqli_query($conn, $sql);

if(!$result || $result->num_rows === 0){
    die("TIER NOT FOUND OR INACTIVE");
}

$tier = $result->fetch_assoc();

$code = bin2hex(random_bytes(6));

$insert_sql = "INSERT INTO giftcards (code, tier_id, status, created_at) VALUES ('$code', $tier_id, 0, NOW())";

$insert_result = mysqli_query($conn, $insert_sql);

if(!$insert_result){
    die("INSERT ERROR: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="page.css">
    <title>Document</title>
</head>
<body>
    <div class="page-box">
        <h1>Giftcard created!</h1>
        <p>Tier: <?= htmlspecialchars($tier['name']) ?> (<?= htmlspecialchars($tier['value']) ?> €)</p>
        <p>Your code:</p>

        <div class="code-box"><?= htmlspecialchars($code) ?></div>

        <a href="index.php" class="btn-back">Back</a>
    </div>
</body>
</html>

