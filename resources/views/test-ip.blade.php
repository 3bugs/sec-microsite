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

    h1 > span {
      color: blue;
      font-family: monospace;
      font-size: 12rem;
    }

    @media (max-width: 1400px) {
      h1 > span {
        font-size: 10rem;
      }
    }

    @media (max-width: 1000px) {
      h1 > span {
        font-size: 8rem;
      }
    }

    @media (max-width: 800px) {
      h1 > span {
        font-size: 6rem;
      }
    }

    @media (max-width: 500px) {
      h1 > span {
        font-size: 4rem;
      }
    }

    @media (max-width: 400px) {
      h1 > span {
        font-size: 3rem;
      }
    }
  </style>
</head>

<body>
<p style="color: #aaa">{{ date("Y-m-d h:i:sa") }}</p>
<h1><span>{{ $ip }}</span></h1>
</body>
</html>
