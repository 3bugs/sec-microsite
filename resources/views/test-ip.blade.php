<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>START TO GROW - Test IP Address</title>
  <!--  <link rel="SHORTCUT ICON" href="favicon.ico" type="image/x-icon">-->
  <style>
    html, body {
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
<p style="color: #aaa">{{ date("Y-m-d h:i:sa") }}</p>
<h1><span style="color: blue; font-size: 6rem; font-family: monospace;">{{ $ip }}</span></h1>
</body>
</html>
