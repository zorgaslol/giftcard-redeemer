<?php
include "database.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    die("INVALID REQUEST");
}

$code = trim($_POST['code'] ?? '');

if($code === ""){
    die("No code entered");
}

$sql = "SELECT g.id, g.code, t.name, t.value
                FROM giftcards g
                JOIN `giftcards-tiers` t ON g.tier_id = t.id
                WHERE g.code = '$code' AND g.status = 0";

$result = mysqli_query($conn, $sql);

if(!$result || $result->num_rows === 0){
    $message = "Code is invalid or already redeemed. ";
}else{
    $card = $result->fetch_assoc();

    $updated_sql = "UPDATE giftcards SET status = 1, redeemed_at = NOW() WHERE id = " . $card['id'];
    mysqli_query($conn, $updated_sql);

    $message = "Success! You redeemed a " . $card["value"] . "€" . $card['name'] . ' giftcard.';

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
        <h1>Redeem result</h1>
        <p><?= htmlspecialchars($message) ?></p>

        <?php if (!empty($success)): ?>
            <p>Tier: <?= htmlspecialchars($card['name']) ?></p>
            <p>Value: €<?= htmlspecialchars($card['value']) ?></p>
        <?php endif; ?>

        <a href="index.php" class="btn-back">Back</a>
    </div>
</body>
</html>