<?php
include "database.php";

$sql = "SELECT id, name, value, description FROM `giftcards-tiers` WHERE is_active = 1";

$results = mysqli_query($conn, $sql);

if(!$results){
    die("SQL error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="header-row">
            <h1>Choose a giftcard</h1>

            <div class="redeem">
                <h2>Redeem a giftcard</h2>
                <form action="redeem_giftcard.php" method="POST">
                    <input type="text" name="code" placeholder="Enter your code" required>
                    <button type="submit">Redeem</button>
                </form>
            </div>
        </div>

        <div class="cards">
            <?php if ($results->num_rows > 0): ?>
                <?php while($row = $results->fetch_assoc()): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p class="value">€<?= htmlspecialchars($row['value']) ?></p>
                        <p class="desc"><?= htmlspecialchars($row['description']) ?></p>

                        <form action="create_giftcard.php" method="POST">
                            <input type="hidden" name="tier_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn-primary">Buy</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No active giftcard tiers.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>