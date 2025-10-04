<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Money Splitter Dashboard</title>
    <style>
        /* Reset and basic styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f0f2f5; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2f3d4a;
            color: white;
            padding: 20px;
        }
        .sidebar h2 { margin-bottom: 30px; font-size: 22px; text-align: center; }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover { background: #1c262e; }

        /* Main content */
        .main {
            flex: 1;
            padding: 30px;
        }
        .main h1 { margin-bottom: 20px; color: #333; }

        /* Dashboard cards */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card h3 { margin-bottom: 10px; color: #555; }
        .card p { font-size: 24px; font-weight: bold; color: #222; }

        /* Transactions table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }

        /* Buttons */
        .btn {
            padding: 8px 15px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover { background: #45a049; }

        /* Footer */
        .footer {
            text-align: center;
            padding: 15px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Money Splitter</h2>
        <a href="#">Dashboard</a>
        <a href="#">Rooms</a>
        <a href="#">Transactions</a>
        <a href="#">Settlements</a>
        <a href="#">Profile</a>
        <a href="#">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h1>Welcome, Demo User!</h1>

        <!-- Dashboard Cards -->
        <div class="cards">
            <div class="card">
                <h3>Total Balance</h3>
                <p>$120</p>
            </div>
            <div class="card">
                <h3>Money Owed</h3>
                <p>$50</p>
            </div>
            <div class="card">
                <h3>Money to Receive</h3>
                <p>$70</p>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <h2>Recent Transactions</h2>
        <table>
            <tr>
                <th>Transaction</th>
                <th>Room</th>
                <th>Payer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Lunch</td>
                <td>Trip to NYC</td>
                <td>Alex</td>
                <td>$30</td>
                <td>Pending</td>
                <td><a class="btn" href="#">Settle</a></td>
            </tr>
            <tr>
                <td>Hotel</td>
                <td>Trip to NYC</td>
                <td>Emma</td>
                <td>$90</td>
                <td>Paid</td>
                <td><a class="btn" href="#">View</a></td>
            </tr>
            <tr>
                <td>Coffee</td>
                <td>Coworking</td>
                <td>Demo User</td>
                <td>$15</td>
                <td>Pending</td>
                <td><a class="btn" href="#">Settle</a></td>
            </tr>
        </table>

        <div class="footer">
            &copy; 2025 Money Splitter. All rights reserved.
        </div>
    </div>
</body>
</html>
