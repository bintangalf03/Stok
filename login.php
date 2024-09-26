<?php
include('proses.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="aset/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            height: 100vh;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background: linear-gradient(270deg, #000000, #007bff, #000000);
            background-size: 400% 400%;
        }
        .card {
            background-color: rgba(73, 80, 87, 0.9);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }
        
        .btn-primary {
            position: relative;
            background-color: #6c757d;
            border-color: #6c757d; 
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary::before,
        .btn-primary::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 100%;
            background: #007bff;
            transition: transform 0.3s ease;
        }

        .btn-primary::before {
            top: 0;
            left: 100%;
        }

        .btn-primary::after {
            bottom: 0; 
            left: 100%; 
        }

        .btn-primary:hover::before {
            transform: translateX(-100%);
        }

        .btn-primary:hover::after {
            transform: translateX(-100%); 
        }

        .btn-primary:hover {
            background-color: #5a6268; 
            border-color: #545b62; 
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); 
        }
        
        label {
            color: #f8f9fa;
        }

        input {
            background-color: #343a40;
            color: white;
            border: 1px solid #6c757d;
            transition: border-color 0.3s ease;
        }

        input::placeholder {
            color: #adb5bd;
        }

        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 350px;">
            <h2 class="text-center mb-4 text-light">LOGIN</h2>
            <form action="proses.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <br>
                <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
            </form>
        </div>
    </div>

    <script src="../aset/bootstrap.bundle.min.js"></script>
</body>
</html>
