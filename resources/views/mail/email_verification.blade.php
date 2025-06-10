<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f3f8;
    }
    .container {
      padding: 20px;
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
   
    .header1 {
      text-align: center;
    }
    .logo {
      height: 50px;
      width: auto;
      margin-top:30px;
    }
    .content {
      padding: 5px 0;
      text-align: center;
    }
    .message {
      font-size: 16px;
      line-height: 1.5;
    }
    .reset-btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .reset-btn:hover {
      background-color: #2980b9;
    }
    .footer {
      text-align: center;
      padding-top: 20px;
    }
  </style>
</head>
<body>
    <div class="header1">
         <img src="{{ asset(getSetting('primary_logo')) }}" alt="Logo" class="logo">
    </div>
  <div class="container">
    <h2 style="text-align: center">Email Verification</h2>    
    <div class="content">
      <p class="message">
        Hello {{ $user->name }}, <br/>
        You are receiving this email so we can confirm this email address for your account. to finish verifying your email address. 
        Please use the following one time (OTP) : <strong>{{ $user->otp }}</strong>
      </p>
      
    </div>
   
  </div>
</body>
</html>
