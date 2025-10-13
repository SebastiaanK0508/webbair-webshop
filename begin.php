<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webbair - Binnenkort beschikbaar</title>
    <style>
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes fadeInScale {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        @keyframes dots {
            0% { content: "."; }
            33% { content: ".."; }
            66% { content: "..."; }
            100% { content: "."; }
        }
        .cta-text-animated::after {
            content: "";
            display: inline-block;
            animation: dots 2s infinite steps(1);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(-45deg, #2ecc71, #3498db, #2980b9, #27ae60);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: #fff;
            text-align: center;
            overflow: hidden;
        }
        .container {
            padding: 40px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 600px;
            animation: fadeInScale 1s ease-out forwards;
        }
        h1 {
            color: #23303cff;
            font-size: 3em;
            margin-bottom: 20px;
            position: relative;
            animation: bounce 2s infinite;
        }
        p {
            color: #34495e;
            font-size: 1.4em;
            margin-bottom: 15px;
        }
        .cta-text {
            font-weight: bold;
            color: #27ae60;
        }
        img {
            width: 100px;
            height: 100px
        }
        input {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 5px #27ae60;
        }
        button {
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
        @media (max-width: 600px){
            body {
                font-size: 14px;
                padding: 2%;
            }
            h1 {
                font-size: 2.5em;
            }
            p {
                font-size: 1.2em;
            }
            .cta-text {
                font-size: 1.2em;
            }
            input {
                font-size: 14px;
            }   
        }
    </style>
    <link rel="icon" href="afbeeldingen/webbair_logo_cut_background_rm.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1><span class="text-webbair-accent">WebbairFramework</span></h1>
        <img src="afbeeldingen/WEBBAIR_20250812_230805_0000.jpg" alt="webbair-logo">
        <p class="cta-text cta-text-animated">In ontwikkeling</p>
        <form method="post">
            <input type="password" name="password" placeholder="Wachtwoord" id="password">
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>

<?php
    session_start();
    $correct_password = "Webbairadmin!"; 
    $password_field_name = "password"   ; 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$password_field_name])) {
            $submitted_password = $_POST[$password_field_name];
        if ($submitted_password === $correct_password) {
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
            echo '<p style="color: green; font-size: 1.2em; margin-top: 20px;">Succesvol ingelogd! Welkom!</p>';
            
        } else {
            echo '<p style="color: red; font-size: 1.2em; margin-top: 20px;">Fout: Onjuist wachtwoord.</p>';
        }
    }
?>