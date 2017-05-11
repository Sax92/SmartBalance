<?php global $config;
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="it">
    
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gestionale entrate uscite">
    <meta name="author" content="">
    <link rel="icon" href="../../public/favicon.ico"/>

    <title>SmartBalance</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=$config['css']?>bootstrap.min.css" rel="stylesheet">
    
    <!-- MetisMenu CSS -->
    <link href="<?=$config['css']?>metisMenu.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?=$config['css']?>sb-admin-2.css" rel="stylesheet">
    <link href="<?=$config['css']?>bootstrap-colorpicker.css" rel="stylesheet">
    <link href="<?=$config['css']?>dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?=$config['css']?>style.css" rel="stylesheet">
    
    <!-- Custom JS -->
    <script src="<?=$config['js']?>js-webshim/minified/polyfiller.js"></script> 
    <script> 
        webshims.polyfill();
    </script>
    

    <!-- Custom Fonts -->
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link href="<?=$config['fontaw']?>font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

