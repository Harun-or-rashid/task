<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Employee Report' }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        h3 { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>{{ $title ?? 'Employee Report' }}</h2>

    @foreach($organizations as $orgName => $orgData)
        <h3>{{ $orgName }} (Total Employees: {{ $orgData['total_employees'] }})</h3>

        @foreach($orgData['teams'] as $teamName => $teamData)
            <h4>Team: {{ $teamName }} (Avg Salary: ${{ number_format($teamData['average_salary'], 2) }})</h4>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Salary</th>
                    <th>Role</th>
                </tr>
                @foreach($teamData['employees'] as $employee)
                    <tr>
                        <td>{{ $employee['name'] }}</td>
                        <td>{{ $employee['email'] }}</td>
                        <td>${{ number_format($employee['salary'], 2) }}</td>
                        <td>{{ $employee['role'] }}</td>
                    </tr>
                @endforeach
            </table>
        @endforeach
    @endforeach
</body>
</html>
