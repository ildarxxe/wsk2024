<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Company</title>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
</head>
<body>
    <div class="wrapper">
        <h1>Create a company</h1>
        <form action="/companies/create" method="POST">
            @csrf
            <div class="form_label">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form_label">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address">
            </div>
            <div class="form_label">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number">
            </div>
            <div class="form_label">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email">
            </div>
            <div class="form_label">
                <label for="owner_name">Owner Name:</label>
                <input type="text" name="owner_name" id="owner_name">
            </div>
            <div class="form_label">
                <label for="owner_number">Owner Number:</label>
                <input type="text" name="owner_number" id="owner_number">
            </div>
            <div class="form_label">
                <label for="owner_email">Owner Email:</label>
                <input type="text" name="owner_email" id="owner_email">
            </div>
            <div class="form_label">
                <label for="contact_name">Contact Name:</label>
                <input type="text" name="contact_name" id="contact_name">
            </div>
            <div class="form_label">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" id="contact_number">
            </div>
            <div class="form_label">
                <label for="contact_email">Contact Email:</label>
                <input type="text" name="contact_email" id="contact_email">
            </div>
            <div class="form_button">
                <button type="submit">Create</button>
            </div>
        </form>
    </div>
</body>
</html>
