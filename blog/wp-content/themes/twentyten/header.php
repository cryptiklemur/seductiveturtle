<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>

    

    <meta http-equiv="CACHE-CONTROL" content="PUBLIC" />

    <meta http-equiv="EXPIRES" content="Fri, 15 Apr 2011 13:15:44 +0000" />

    <meta name="keywords" content="javascript,php, mysql, zend framework, website, development, design, st. paul, minnesota, phil gapp, dennis gapp, tim stave, aaron scherer, jack westman" />

    <meta name="description" content="Seductive Turtle is an open source, non-profit web development company looking to build a new standard for php websites" />

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <meta name="robots" content="all">

    <title>Seductive Turtle</title>

    <link href="/css/layout" rel="stylesheet" type="text/css" media="screen" />

    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css' /> 

        <link href="/css/custom" rel="stylesheet" type="text/css" media="screen" />

	<script type='text/javascript'>

    function addLoadEvent(func) {

      var oldonload = window.onload;

      if (typeof window.onload != 'function') {

        window.onload = func;

      } else {

        window.onload = function() {

          if (oldonload) {

            oldonload();

          }

          func();

        }

      }

    }

    </script>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
    </head>





    <body>

			

        <div class='wrap'>

            <div class='content'>

                <div class='menu'>

                	<ul id="mainnav">

	<li id='home'><a href="/">home</a></li>

	<li id='about us'><a href="/about">about</a></li>

	<li id='contact'><a href="/contact">contact</a></li>

</ul>                </div>

                <div id='header' onclick='window.location.href="/"'>

                        <span id='seductive'>seductive</span><span id='turtle'>turtle</span>

                </div>
	<div id="main">