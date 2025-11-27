<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Weekend Wear - Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Weekend wear.png" type="image/x-icon">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(to bottom right, #f2f2f2, #cccccc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }

        .login h2 {
            font-family: "Anton", Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            margin-bottom: 15px;
            color: #333;
            font-size: 28px;
        }

        .login p {
              font-family: "Poppins", sans-serif; /* للنصوص العادية */
            margin-bottom: 25px;
            color: #666;
            font-size: 16px;
        }

        .login input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .login input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #333;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login input[type="submit"]:hover {
            background-color: #555;
        }

        /* Responsive */
        @media (max-width: 400px) {
            .login {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Signup</h2>
        <p>Enter your email</p>
        <form method="post" action="temp_login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="submit" value="Continue">
        </form>
    </div>
</body>
</html>
