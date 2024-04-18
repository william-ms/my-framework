<?=$this->extends('site.main') ?>

<?=$this->section_start('css') ?>
  <link rel="stylesheet" href="<?php echo PATH['CSS']; ?>home.css" />
<?=$this->section_end() ?>

<?=$this->section_start('scripts') ?>
  <script src="<?php echo PATH['JS']; ?>home.js"></script>
<?=$this->section_end() ?>

<div class="home">
  <h2>Site Home</h2>
</div>
