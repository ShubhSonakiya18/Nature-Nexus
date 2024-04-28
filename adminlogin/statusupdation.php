<!DOCTYPE html>
<html>
<head>
    <title>Status Completion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('nature1.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 200px;
            z-index: 9999;
            opacity: 0.8; /* Reduce opacity to 0.4 */
        }
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 20px;
            border-radius: 10px;
            animation: slideIn 1s ease;
            opacity: 0.8; /* Reduce opacity to 0.4 */
        }
        h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #333;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #2980b9;
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
    <img src="nn.jpg" alt="Nature Nexus Logo" class="logo">
    <div class="container">
        <h1>Status Update</h1>
        <p>We are pleased to inform you that the status of your complaint has been successfully updated.</p>
        <p>Please refer to the <a href="admin-dashboard.php">Admin Dashboard</a> for detailed information regarding your complaint.</p>
    </div>
</body>
</html>