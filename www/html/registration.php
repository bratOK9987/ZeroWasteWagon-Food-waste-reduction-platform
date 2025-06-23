<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ZeroWasteWagon</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        ZeroWasteWagon

            <select name="country"> 
                <?php 
                    $languages = array("English", "Lietuvių", "Русский", "Українська"); 
                    foreach($languages as $language) { 
                        echo "<option value='$language'>$language</option>"; 
                    } 
                ?> 
            </select> 
    </header>

    <!-- Form pointing to register.php for processing -->
    <form id="registrationForm" action="register.php" method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phoneNumber" placeholder="Phone Number" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="text" name="city" placeholder="City" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>

