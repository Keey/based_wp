<?php
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));
header('Content-Type: text/html; charset=utf-8');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header('X-UA-Compatible: IE=Edge,chrome=1');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php seo_title(); ?></title>
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="True"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
<?php wp_head(); ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="row">
            <a href="<?php echo site_url(); ?>/" class="logo"></a>
            <nav>
                <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul id="%1$s" class="box">%3$s</ul>', 'theme_location'  => 'head_menu')); ?>
            </nav>
        </div>
    </header>
<div id="main">