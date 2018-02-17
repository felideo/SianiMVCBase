<?php
/* template head */
if (class_exists('Dwoo\Plugins\Functions\PluginInclude')===false)
	$this->getLoader()->loadPlugin('PluginInclude');
/* end template head */ ob_start(); /* template body */ ?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?php echo $this->scope["app_name"];?></title>

        <meta charset="utf8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">


        <!-- Bootstrap Core CSS -->
        <link href="/public/back/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="/public/back/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="/public/back/dist/css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/public/back/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="/public/back/bower_components/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts CSS -->
        <link href="/public/back/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Custom CSS  -->
        <link href="/public/css/default.css" rel="stylesheet">
        <link href="/public/css/bootstrap.css" rel="stylesheet">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery -->
        <script src="/public/back/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/public/back/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/public/back/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="/public/back/dist/js/sb-admin-2.js"></script>

        <!-- DataTables JavaScript -->
        <script src="/public/back/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/public/back/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="/public/back/dist/js/sb-admin-2.js"></script>

        <!-- Mascaras -->
        <script src="/public/js/jquery.mask.js"></script>
        <script src="/public/js/mascaras.js"></script>
        <script src="/public/js/validacoes.js"></script>

        <!-- Fine Uploader  -->
        <link href="/public/fineuploader/fine-uploader-new.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/public/fineuploader/fine-uploader.js"></script>

        <!-- Sweet Alert -->
        <script src="/public/sweetalert-master/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/public/sweetalert-master/dist/sweetalert.css">

        <!-- Autosize -->
        <script type="text/javascript" src="/public/autosize-master/dist/autosize.js"></script>

        <!-- Select2 3.  -->
        <link rel="stylesheet" type="text/css" href="/public/select2_gj/select2.css">
        <script src="/public/select2_gj/select2.js"></script>

        <script  type="text/javascript"  src="/public/js/default.js"></script>
    </head>
<body>
    <div id="wrapper">
        <div id="content">
            <?php echo $this->classCall('Dwoo\Plugins\Functions\Plugininclude', 
                        array('views/back/cabecalho_rodape_sidebar/sidebar.html', null, null, null, '_root', null));?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="row">
                            <?php if (((isset($this->scope["modulo"]) ? $this->scope["modulo"] : null) !== null)) {
?>
                                <div class="span12">
                                    <h1 class="page-header">
                                        <i class="fa <?php if (($this->readVar("_SESSION.modulos.".(isset($this->scope["modulo"]["modulo"]) ? $this->scope["modulo"]["modulo"]:null).".icone") !== null)) {
?> <?php echo $this->readVar("_SESSION.modulos.".(isset($this->scope["modulo"]["modulo"]) ? $this->scope["modulo"]["modulo"]:null).".icone");?> <?php 
}?>"></i>
                                        <?php echo $this->scope["modulo"]["name"];?>
                                    </h1>
                                </div>
                            <?php 
}
 /* end template body */
return $this->buffer . ob_get_clean();
?>