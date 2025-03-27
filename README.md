<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>Task Project Installation Process</h1>

<h2> Project Overview</h2>
<p>This Laravel-based API project manages organizations, teams, and employees with authentication and role-based access control using Laravel Sanctum. It includes features such as employee management, team management, reporting, and CSV imports.</p>

<hr>

<h2>🔧 Installation Guide</h2>

<h3>Step 1: Clone the Repository</h3>
<pre><code>git clone https://github.com/Harun-or-rashid/task.git
cd task
</code></pre>

<h3>Step 2: Install Dependencies</h3>
<pre><code>composer install
</code></pre>


<h3>Step 3: Configure Environment</h3>
<p>Copy the <code>.env.example</code> file and update your database credentials.</p>
<pre><code>cp .env.example .env</code></pre>
<h3>NB: Direct Copy data from the .env.example
(I have included all the necessary data in the .env.example file for the tester.)</h3>
<h3>Or</h3>
<p>Update <code>.env</code> with your local database setup:</p>
<pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task
DB_USERNAME=root
DB_PASSWORD=
</code></pre>

<h3>Step 4: Generate App Key</h3>
<pre><code>php artisan key:generate</code></pre>

<h3>Step 5: Run Migrations and Seed Database</h3>
<pre><code>php artisan migrate --seed</code></pre>

<h3>Step 6: Start the Laravel Server</h3>
<pre><code>php artisan serve</code></pre>

<p>By default, the API will be available at <code>http://127.0.0.1:8000</code>.</p>

<hr>

<h2>🔐 Authentication</h2>
<p>This project uses Laravel Sanctum for API authentication.</p>

<ul>
    <li><strong>Login:</strong> <code>/api/admin-login</code> (POST)</li>
    <li><strong>Logout:</strong> <code>/api/logout</code> (POST, requires auth)</li>
</ul>

<p>To authenticate requests, send the <code>Authorization: Bearer &lt;token&gt;</code> header.</p>

<hr>

<h2>API Endpoints</h2>

<h3>Public Routes</h3>
<table border="1">
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>POST</td>
        <td><code>/api/admin-login</code></td>
        <td>Admin login</td>
    </tr>
</table>

<h3>Protected Routes (Requires Authentication & Role Permissions)</h3>

<h4>Organizations</h4>
<table border="1">
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/organizations</code></td>
        <td>List organizations</td>
    </tr>
    <tr>
        <td>POST</td>
        <td><code>/api/v1/organizations</code></td>
        <td>Create organization</td>
    </tr>
    <tr>
        <td>PUT</td>
        <td><code>/api/v1/organizations/{id}</code></td>
        <td>Update organization</td>
    </tr>
    <tr>
        <td>DELETE</td>
        <td><code>/api/v1/organizations/{id}</code></td>
        <td>Delete organization</td>
    </tr>
</table>

<h4>Teams</h4>
<table border="1">
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/teams</code></td>
        <td>List teams</td>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/teams/organization/{organization_id}</code></td>
        <td>Get teams by organization</td>
    </tr>
    <tr>
        <td>POST</td>
        <td><code>/api/v1/teams</code></td>
        <td>Create team</td>
    </tr>
    <tr>
        <td>PUT</td>
        <td><code>/api/v1/teams/{id}</code></td>
        <td>Update team</td>
    </tr>
    <tr>
        <td>DELETE</td>
        <td><code>/api/v1/teams/{id}</code></td>
        <td>Delete team</td>
    </tr>
</table>

<h4>Employees</h4>
<table border="1">
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/employees</code></td>
        <td>List employees</td>
    </tr>
    <tr>
        <td>POST</td>
        <td><code>/api/v1/employees</code></td>
        <td>Create employee</td>
    </tr>
    <tr>
        <td>PUT</td>
        <td><code>/api/v1/employees/{id}</code></td>
        <td>Update employee</td>
    </tr>
    <tr>
        <td>DELETE</td>
        <td><code>/api/v1/employees/{id}</code></td>
        <td>Delete employee</td>
    </tr>
</table>

<h4>Reports</h4>
<table border="1">
    <tr>
        <th>Method</th>
        <th>Endpoint</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/teams/average/salary</code></td>
        <td>Get average team salary report</td>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/organizations/employee/count</code></td>
        <td>Get organization-wise employee count</td>
    </tr>
    <tr>
        <td>GET</td>
        <td><code>/api/v1/employee-report/{id}</code></td>
        <td>Generate employee report PDF</td>
    </tr>
</table>

<hr>

<h2>🛠️ Tech Stack</h2>
<ul>
    <li><strong>Backend:</strong> Laravel 11</li>
    <li><strong>PHP:</strong> 8.2</li>
    <li><strong>Authentication:</strong> Laravel Sanctum</li>
    <li><strong>Database:</strong> MySQL</li>
    <li><strong>Queue:</strong> Database Queue Driver</li>
</ul>

<hr>

<h2>📞 Contact</h2>
<ul>
    <li><strong>GitHub:</strong> <a href="https://github.com/Harun-or-rashid">Harun-or-rashid</a></li>
    <li><strong>Email:</strong> <a href="mailto:harunrashid.se@gmail.com">harunrashid.se@gmail.com</a></li>
</ul>

<hr>

</body>
</html>
