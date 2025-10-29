<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php echo $this->session->userdata('site_title');?> My Namibia&trade; CMS</title>
	<meta name="description" content="">
	<meta name="author" content="Roland Ihms">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="<?php echo base_url('/');?>admin_src/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link id="base-style" href="<?php echo base_url('/');?>admin_src/css/style.css?v1" rel="stylesheet">
	<link id="base-style-responsive" href="<?php echo base_url('/');?>admin_src/css/style-responsive.css" rel="stylesheet">
	<link  href="<?php echo base_url('/');?>admin_src/css/bootstrap-select.css" rel="stylesheet">
	
	<!--[if lt IE 7 ]>
	<link id="ie-style" href="<?php echo base_url('/');?>admin_src/css/style-ie.css" rel="stylesheet">
	<![endif]-->
	<!--[if IE 8 ]>
	<link id="ie-style" href="<?php echo base_url('/');?>admin_src/css/style-ie.css" rel="stylesheet">
	<![endif]-->
	<!--[if IE 9 ]>
	<![endif]-->
	
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- start: Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('/');?>admin_src/img/favicon.ico">
	<!-- end: Favicon -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.9.1/tinymce.min.js"></script>

	
	<script>
		tinymce.init({
			selector: 'textarea#tinymce',
			plugins: [
			// Core editing features
			'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
			// Your account includes a free trial of TinyMCE premium features
			// Try the most popular premium features until Jun 3, 2025:
			'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
			],
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
			tinycomments_mode: 'embedded',
			tinycomments_author: 'Author name',
			mergetags_list: [
			{ value: 'First.Name', title: 'First Name' },
			{ value: 'Email', title: 'Email' },
			],
			ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
		});
    </script>
</head>
