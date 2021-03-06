<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="<?php echo $this->base->global_classes(); ?>">
<head>

<meta charset="utf-8" />
<!--[if IE]><script src="<?php echo base_url(); ?>asset/js/html5.js"></script><![endif]-->
<title><?php echo Modules::run('metatags/title'); ?></title>
<?php echo Modules::run('metatags/html'); ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/layout.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/main.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/messages.css" type="text/css" media="screen, projection" />

<!-- Libraries -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/libs/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/libs/html5.js"></script>

<!-- Debug mode -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/debug.js"></script>

<!-- Application core  -->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/App.js"></script>

</head>

<body>

<div class="l-wrapper">

	<header class="l-header">
		<strong>Header:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tortor. Praesent dictum, libero ut tempus dictum, neque eros elementum mauris, quis mollis arcu velit ac diam. Etiam neque. Quisque nec turpis. Aliquam arcu nulla, dictum et, lacinia a, mollis in, ante. Sed eu felis in elit tempor venenatis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut ultricies porttitor purus. Proin non tellus at ligula fringilla tristique. Fusce vehicula quam. Curabitur vel tortor vitae pede imperdiet ultrices. Sed tortor.
	</header><!-- #header-->

	<section class="l-columns">

		<div class="l-content">
			<div class="l-content-h">
                <h1><?php print $title; ?></h1>
                <?php print $this->message->display(); ?>
                <?php print $content; ?>
			</div><!-- #content-->
		</div><!-- #container-->

		<aside class="l-left">

            <?php print Modules::run('user/userblock'); ?>

		</aside><!-- #sideLeft -->

	</section><!-- #middle-->

	<footer class="l-footer">
		<strong>Footer:</strong> Mus elit Morbi mus enim lacus at quis Nam eget morbi. Et semper urna urna non at cursus dolor vestibulum neque enim. Tellus interdum at laoreet laoreet lacinia lacinia sed Quisque justo quis. Hendrerit scelerisque lorem elit orci tempor tincidunt enim Phasellus dignissim tincidunt. Nunc vel et Sed nisl Vestibulum odio montes Aliquam volutpat pellentesque. Ut pede sagittis et quis nunc gravida porttitor ligula.
	</footer><!-- #footer -->

</div><!-- #wrapper -->

</body>
</html>