<?php
include("dataBase.php");

$message = "";
if(isset($_POST['clear_all'])){
    $delete_query = "DELETE FROM seeds";
    if(mysqli_query($conn, $delete_query)){
        $message = "<p class='success'>All seed data has been cleared successfully! 🗑️</p>";
    } else {
        $message = "<p class='error'>Error clearing data: " . mysqli_error($conn) . "</p>";
    }
}

$result = mysqli_query ( $conn, "SELECT * FROM seeds" );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Seeds</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="overlay"></div>
    <header>
        <div class="logo">
        <img src="logo.png" alt="SeedShare Logo" >
        <h1>Seed Inventory</h1>
        </div>
        <nav>
            <a href="index.html">Home</a>
            <a href="add_seed.php">Add seeds</a>
        </nav>
    </header>
    <section class="table-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Available Seeds</h2>
            <form method="POST" style="margin: 0;">
                <button type="submit" name="clear_all" onclick="return confirm('⚠️ WARNING: This will permanently delete ALL seed data from the database. This action cannot be undone. Are you sure?')" 
                        style="background: linear-gradient(135deg, #f44336, #d32f2f); color: white; padding: 12px 25px; border: none; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 1rem;">
                    🗑️ Clear All Data
                </button>
            </form>
        </div>
        
        <?php echo $message; ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Seed Name</th>
                <th>Email</th>
                <th>Quantity</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0) {
                while($row=mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".htmlspecialchars($row['seed_name'])."</td>";
                    echo "<td>".htmlspecialchars($row['email'])."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No seeds found. <a href='add_seed.php'>Add your first seed!</a></td></tr>";
            }
            ?>
        </table>
    </section>
    <footer>
        <p>&copy; 2025 SeedShare. All rights reserved.</p>
    </footer>
</body>
</html>