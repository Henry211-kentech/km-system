<!DOCTYPE html>
<html>
<head>
    <title>Clients</title>
</head>
<body>

<h2>Add Client</h2>

<form method="POST" action="/clients">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="phone" placeholder="Phone">
    <button type="submit">Save</button>
</form>

</body>
</html>