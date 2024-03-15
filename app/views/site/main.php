<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>index.css" />
  </head>

  <body>
    <header>
      <?php include_partial('site.header'); ?>
    </header>

    <section class="content">
      <?php include_view(); ?>
    </section>

    <script src="<?php echo JAVASCRIPT_PATH; ?>index.js"></script>
  </body>
</html>