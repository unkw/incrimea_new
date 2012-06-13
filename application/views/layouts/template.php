<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="<?php echo base_url(); ?>js/html5.js"></script><![endif]-->
	<title><?php print $head_title; ?></title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/messages.css" type="text/css" media="screen, projection" />
</head>

<body>

<div id="wrapper">

	<header id="header">
		<strong>Header:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tortor. Praesent dictum, libero ut tempus dictum, neque eros elementum mauris, quis mollis arcu velit ac diam. Etiam neque. Quisque nec turpis. Aliquam arcu nulla, dictum et, lacinia a, mollis in, ante. Sed eu felis in elit tempor venenatis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut ultricies porttitor purus. Proin non tellus at ligula fringilla tristique. Fusce vehicula quam. Curabitur vel tortor vitae pede imperdiet ultrices. Sed tortor.
	</header><!-- #header-->

	<section id="middle">

		<div id="container">
			<div id="content">
                <h1><?php print $title; ?></h1>
                <?php print $this->message->display(); ?>
                <?php print $content; ?>
			</div><!-- #content-->
		</div><!-- #container-->

		<aside id="sideLeft">
            
            <?php print Modules::run('user/userblock'); ?>
            
		</aside><!-- #sideLeft -->

	</section><!-- #middle-->

	<footer id="footer">
		<strong>Footer:</strong> Mus elit Morbi mus enim lacus at quis Nam eget morbi. Et semper urna urna non at cursus dolor vestibulum neque enim. Tellus interdum at laoreet laoreet lacinia lacinia sed Quisque justo quis. Hendrerit scelerisque lorem elit orci tempor tincidunt enim Phasellus dignissim tincidunt. Nunc vel et Sed nisl Vestibulum odio montes Aliquam volutpat pellentesque. Ut pede sagittis et quis nunc gravida porttitor ligula.
	</footer><!-- #footer -->

</div><!-- #wrapper -->

</body>
</html>