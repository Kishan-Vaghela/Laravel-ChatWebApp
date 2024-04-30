<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
        }

        section {
            padding: 20px;
        }

        .activity {
            background-color: #f4f4f4;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to the Admin Dashboard</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Users</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </nav>
    <section>
        <h2>Recent Activities</h2>
        <div class="activity">
            <p>User John Doe logged in</p>
        </div>
        <div class="activity">
            <p>New user registered: Jane Smith</p>
        </div>
    </section>
    <footer>
        <p>&copy; 2023 Admin Dashboard. All rights reserved.</p>
    </footer>
</body>

</html>
