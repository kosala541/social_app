<?php
// define('ROOT', 'https://wemixt.com/social/');
define('ROOT', 'http://localhost/wemixt/social_app/');
define('ASSETS_ROOT', ROOT . 'assets/');
define('LOGO', ASSETS_ROOT . 'images/favicon.png');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= LOGO ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="<?= ASSETS_ROOT ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ASSETS_ROOT ?>css/style.css">
</head>

<body>