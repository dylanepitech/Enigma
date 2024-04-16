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
    use Form\userform;
    $form = new userform();
    $form->start('','POST');
    $form->firstname();
    $form->lastname();
    $form->age();
    $form->end();
            ?>
</body>

</html>