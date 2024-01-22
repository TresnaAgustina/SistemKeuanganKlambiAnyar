<!-- FILEPATH: /d:/Personal Project/UD Klambi Anyar/SistemKeuangan/resources/views/test.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>My Blade Template</title>
</head>
<body>
    <h1>Welcome to My Blade Template</h1>

    <form method="POST" action="/submit-form">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>