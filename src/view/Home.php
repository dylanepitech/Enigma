<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
</head>

<body>
    <h1>Sa marche</h1>
    <?php
    use Form\user_tableform;
    $user = new user_tableform();
    $user->start("","POST");
    $user->firstname();
    $user->lastname();
    $user->age();
    $user->birthdate();
    $user->end();
            ?>
</body>

</html>