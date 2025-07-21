<!DOCTYPE html>
<html>
<head>
    <title>User CRUD - Laravel UI + API</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 300px;
        }
    </style>
</head>
<body>

    <h2>{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>

    {{--  Success --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    {{-- Error --}}
    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Create or Update Form --}}
    <form action="{{ isset($user) ? url('/update-user/' . $user->id) : url('/submit-user') }}" method="POST">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required><br><br>

        <label>Password (leave blank to keep same):</label><br>
        <input type="password" name="password"><br><br>
        <button type="submit">{{ isset($user) ? 'Update' : 'Create' }}</button>
    </form>

    {{--User List --}}
    <h3>All Users</h3>
    @if(isset($users) && count($users))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="200px">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <a href="{{ url('/edit-user/' . $u->id) }}">Edit</a> |
                        <a href="{{ url('/delete-user/' . $u->id) }}" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No users found.</p>
    @endif

</body>
</html>
