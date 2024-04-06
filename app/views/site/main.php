<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>index.css" />
    <?=$this->section('css') ?>
  </head>

  <body>
    <header>
      <?=$this->partial('site.header') ?>
    </header>

    <section class="content">
      <?=$this->section('content') ?>
    </section>

    <script src="<?php echo JS_PATH; ?>xhttp.js"></script>
    <script src="<?php echo JS_PATH; ?>index.js"></script>
    <?=$this->section('scripts') ?>
  </body>
</html>