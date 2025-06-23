<!DOCTYPE <!DOCTYPE html>
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

        <div class="containerText">
            <p>Welcome to ZeroWasteWagon, where we believe in transforming the way we approach food consumption and waste. In a world where food resources are precious, our platform is dedicated to revolutionizing the journey from farm to table, ensuring that every bite counts. As a global community, we recognize the urgent need to address food waste and its environmental impact.</p>

            <p>At ZeroWasteWagon, we bring together individuals, businesses, and communities to foster a sustainable food culture. Our mission is to empower you to make informed choices, reduce food waste, and contribute to a healthier planet. Through innovative solutions, educational resources, and collaborative initiatives, we aspire to create a ripple effect that positively influences the entire food ecosystem.</p>

            <p>Join us on this journey toward a more sustainable future. Explore our platform, discover practical tips, connect with like-minded individuals, and be a part of the movement to minimize food waste. Together, let's turn the tide and make a significant impact on the way we eat, live, and nourish our world.ZWW</p>

        </div>

        <div class="containerButtons">
            <form method="post" action="registration.php">
                <button type="submit">Start Eating</button>
            </form>
    
            <form method="post" action="registration_company.php">
                <button type="submit">Start Selling</button>
            </form>
        </div>

        
        <script src="" async defer></script>
    </body>
</html>
