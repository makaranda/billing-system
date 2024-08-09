<!DOCTYPE html>
<html>
<head>
    <title>System Users Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>System Users Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Last Login Time</th>
                <th>Last Login IP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($systemUsers as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->last_login_time }}</td>
                <td>{{ $user->last_login_ip }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
