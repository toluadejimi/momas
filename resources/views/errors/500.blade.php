<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Server Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f8f9fa;
            color: #333;
        }
        h1 {
            font-size: 50px;
        }
        p {
            font-size: 18px;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #d9534f;
        }
    </style>
</head>
<body>
<h1>Something Went Wrong</h1>
<p class="error-code">500</p>

<h5>Error Message</h5>
<p>{{ $exception->getMessage() ?: 'We are experiencing an issue. Please try again later.' }}</p>

</body>
</html>
