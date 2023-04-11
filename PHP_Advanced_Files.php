<?php

$errors = [];
$images = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $authorizedExtensions = ["jpg", "png", "gif", "webp"];
    $maxFileSize = 1000000;

    $uploadDir = "public/uploads/";
    $extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    $uploadFile = $uploadDir . uniqid() . "." . $extension;



    if (!in_array($extension, $authorizedExtensions)) {
        $errors[] = "Veuillez sélectionner une image de type jpg, png, gif ou webp.";
    }

    if (file_exists($_FILES["avatar"]["tmp_name"]) && filesize(($_FILES["avatar"]["tmp_name"])) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 2MO.";
    }

    if (empty($errors)) {
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadFile);
    }


    $images = scandir($uploadDir);
    $images = array_splice($images, 2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label for="imageUpload">Upload a profile picture</label><br>
        <input type="file" name="avatar" id="imageUpload"><br>
        <button type="submit">Send</button>
    </form>

    <section>
        <?php foreach ($errors as $error) : ?>
            <h3><?= $error ?></h3>
        <?php endforeach ?>
    </section>

    <?php foreach ($images as $image) : ?>
        <img src=<?= $uploadDir . $image; ?> alt="">
        <h1> <?= $image; ?> </h1>
    <?php endforeach ?>
</body>

</html>
