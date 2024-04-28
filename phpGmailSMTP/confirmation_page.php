<!DOCTYPE html>
<html>
<head>
    <title>Report Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('nature1.jpg'); /* Set nature1.jpg as the background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* Light gray background with transparency */
            animation: slideIn 0.5s ease;
            position: relative;
            padding: 20px;
            border-radius: 10px;
        }
        .logo-top-left {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 200px;
            z-index: 9999;
            opacity: 0.8; /* Make the logo more translucent */
        }
        .verification-badge {
            width: 80px; /* Adjust the width for a bigger badge */
            opacity: 0.5; /* Match the opacity of the container */
        }
        h1 {
            font-size: 32px;
            margin-bottom: 5px; /* Reduce the space between title and text */
            color: #333;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px; /* Reduce the space between text and button */
            color: #666;
        }
        a.button {
            display: inline-block;
            margin-top: 40px; /* Increase the space above the button */
            background-color: #fff; /* White button background */
            padding: 5px 10px;
            border-radius: 5px;
        }
        a.button img {
            width: 100px; /* Adjust the width of the button image */
            opacity: 0.4; /* Match the opacity of the container */
        }
        a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #2980b9;
        }
        .button-text {
            margin-top: 0; /* Remove the margin between button and text */
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <img src="nn.jpg" alt="Nature Nexus Logo" class="logo-top-left">
    <div class="container">
        <img src="verification.png" alt="Verification Badge" class="verification-badge">
        <h1>Report Published</h1>
        <p>Your report has been successfully published. Thank you for helping keep our community clean!</p>
        <a href="home.php" class="button"><img src="home.jpg" alt="Home"></a>
        <p class="button-text"><a href="http://localhost/waste-management-system-main/index.html">Go back to Home</a></p>
    </div>
</body>
</html>