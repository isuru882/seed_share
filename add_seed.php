<?php
include("dataBase.php");

$success=$error="";
if(isset($_POST['submit'])){
    error_log("Form submitted");
    
    $seed_name = trim($_POST['seed_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $quantity = trim($_POST['quantity']);

    error_log("Received values - Seed: $seed_name, Email: $email, Quantity: $quantity");

    if($seed_name=="" || $email=="" || $password=="" || $quantity==""){
        $error="All fields are required.";
        error_log("Validation failed: Empty fields");
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error="Please enter a valid email address.";
        error_log("Validation failed: Invalid email");
    } else if(!is_numeric($quantity) || $quantity <= 0) {
        $error="Please enter a valid quantity (positive number).";
        error_log("Validation failed: Invalid quantity");
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO seeds (seed_name, email, password, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $seed_name, $email, $hashed_password, $quantity);
        
        error_log("Executing prepared statement with values: $seed_name, $email, $quantity");
        
        if($stmt->execute()){
            $success="Seed added successfully! 🌱";
            error_log("Seed added successfully");
            
            $seed_name = $email = $password = $quantity = "";
        }else{
            $error="Error adding seed: " . $stmt->error;
            error_log("Database error: " . $stmt->error);
        }
        
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add seed-seedshare</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="overlay"></div>
    <header>
        <div class="logo">
        <img src="logo.png" alt="SeedShare Logo" >
        <h1>Add Seed To Inventory</h1>
        </div>
        <nav>
            <a href="index.html">Home</a>
            <a href="view_seed.php">View seeds</a>
        </nav>
    </header>
    <section class="form-section">
        <h2>Enter seed details</h2>
        <form method="POST" onsubmit="return validateForm()">
            <label>Seed Name:</label>
            <input type="text" id="seed_name" name="seed_name" value="<?php echo isset($seed_name) ? htmlspecialchars($seed_name) : ''; ?>" required>

            <label>Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

            <label>Password:</label>
            <input type="password" id="password" name="password" required>

            <label>Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo isset($quantity) ? htmlspecialchars($quantity) : ''; ?>" min="1" required>

            <input type="submit" name="submit" value="Add Seed">
            <input type="reset" value="Clear">
        </form>
        <?php
        if($success){
            echo "<p class='success'>$success</p>";
        }
        if($error){
            echo "<p class='error'>$error</p>";
        }
        ?>
    </section>
    <footer>
        <p>&copy; 2025 SeedShare. All rights reserved.</p>
    </footer>
</body>
</html>