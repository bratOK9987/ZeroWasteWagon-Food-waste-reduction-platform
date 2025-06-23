<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="alert alert-success">
            <h4>Payment Successful!</h4>
            <p>Thank you for your purchase. Your order is being processed.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Return Home</a>
        </div>
    </div>
</body>
</html>
