<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to Zero Waste Wagon</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
    }
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #6AAB9C;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #fff;
        background-image: linear-gradient(135deg, #56CCF2 0%, #3A95DD 100%);
        text-align: center;
    }
    .container {
        max-width: 700px;
        padding: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }
    h1 {
        font-size: 3rem;
        color: #FFFFFF;
        margin-bottom: 10px;
    }
    p {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .badge {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        background-color: #FFD700;
        border-radius: 20px;
        color: #333;
        margin-top: 20px;
        font-weight: 700;
    }
    .notify-btn {
        margin-top: 30px;
        padding: 10px 25px;
        font-size: 1.1rem;
        border: none;
        border-radius: 25px;
        background-color: #FFD700;
        color: #333;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: 700;
    }
    .notify-btn:hover {
        background-color: #f9e076;
    }
    .email-form {
        display: none;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }
    .email-input {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 20px;
        border: none;
        outline: none;
        width: 80%;
    }
    .submit-btn {
        padding: 10px 25px;
        border-radius: 20px;
        border: none;
        background-color: #FFD700;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: 700;
    }
    .submit-btn:hover {
        background-color: #f9e076;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Zero Waste Wagon</h1>
        <p>Join us on the journey to reduce food waste and embrace sustainability.</p>
        <div class="badge">Coming Soon</div>
        <p>Our team is working passionately to launch the platform that will revolutionize the way we think about food waste.</p>
        <!-- Button triggers the JavaScript function to show the form -->
        <button class="notify-btn" onclick="toggleEmailForm()">Notify Me</button> 
        <!-- The form where the email will be entered -->
        <form class="email-form" action="subscribe.php" method="post">
            <input type="email" name="email" placeholder="Enter your email" class="email-input" required>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

    <script>
        // This function toggles the display of the email form
        function toggleEmailForm() {
            var form = document.querySelector('.email-form');
            var notifyBtn = document.querySelector('.notify-btn');
            if (form.style.display === 'none') {
                form.style.display = 'block'; // Show the form
                notifyBtn.style.display = 'none'; // Hide the notify button
            } else {
                form.style.display = 'none'; // Hide the form
            }
        }
    </script>
</body>
</html>