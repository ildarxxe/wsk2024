<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
    <link rel="stylesheet" href="{{asset("css/main.css")}}">
</head>
<body>
<div class="wrapper">
    <h1>Create a product</h1>
    <form action="/products/create" method="POST">
        @csrf
        <div class="form_label">
            <label for="GTIN">GTIN:</label>
            <input type="text" name="GTIN" id="GTIN">
        </div>
        <div class="form_label">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="form_label">
            <label for="description">Description:</label>
            <input type="text" name="description" id="description">
        </div>
        <div class="form_label">
            <label for="name_fr">Name in French:</label>
            <input type="text" name="name_fr" id="name_fr">
        </div>
        <div class="form_label">
            <label for="description_fr">Description in French:</label>
            <input type="text" name="description_fr" id="description_fr">
        </div>
        <div class="form_label">
            <label for="country">Country of Origin:</label>
            <input type="text" name="country" id="country">
        </div>
        <div class="form_label">
            <label for="brand_name">Brand Name:</label>
            <input type="text" name="brand_name" id="brand_name">
        </div>
        <div class="form_label">
            <label for="gross_weight">Gross Weight:</label>
            <input type="text" name="gross_weight" id="gross_weight">
        </div>
        <div class="form_label">
            <label for="net_weight">Net Content Weight:</label>
            <input type="text" name="net_weight" id="net_weight">
        </div>
        <div class="form_label">
            <label for="weight_unit">Weight Unit:</label>
            <input type="text" name="weight_unit" id="weight_unit">
        </div>
        <div class="form_button">
            <button type="submit">Create</button>
        </div>
    </form>
</div>
</body>
</html>
