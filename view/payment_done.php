<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url=../index.php">
    <title>Payment Successful</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .success-container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.5s ease-in-out;
        }

        .success-animation {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            border-radius: 50%;
            border: 10px solid #4caf50; /* Circle border */
            background-color: white; /* Background for circle */
        }

        .checkmark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            font-size: 60px;
            color: #4caf50;
            animation: bounce 0.5s ease infinite; /* Animation applied only to checkmark */
        }

        h1 {
            font-size: 32px;
            color: #333;
            margin: 0;
        }

        p {
            font-size: 18px;
            color: #666;
        }

        .redirect-message {
            margin-top: 20px;
            font-size: 16px;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #4caf50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #45a049;
        }

        @keyframes bounce {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.2); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-animation">
            <div class="checkmark">&#10003;</div> <!-- Checkmark symbol -->
        </div>
        <h1>Payment Successful!</h1>
        <p>Your order has been placed successfully.</p>
        <div class="redirect-message">
            You will be redirected shortly. If not, click the button below.
        </div>
        <a href="../index.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>
