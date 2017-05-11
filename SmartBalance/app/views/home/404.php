<?php include 'Header.php'; ?>

<body>
<div class="container">
  <div class="row">

  		<div class="col-lg-3"></div>
  		<div class="col-lg-6">
			<div class="panel panel-danger ops">
				<div class="panel-heading"><h1>404 <i class="fa fa-exclamation-triangle"></i></h1></div>
					<div class="panel-body">						
							<div class="row">
								<div class="col-md-12 "><h3>Pagina inesistente. Verrai reindirizzato alla pagina principale entro 5 secondi.</h3></div>
                                <?php header('refresh:5;url='.$config['path_base'].'home/index');?>
                            </div>
					</div>	
				
			</div>
		</div>
  		<div class="col-lg-3"></div>

  </div>
</div>
  <!-- jQuery -->
    <script src="<?=$config['js']?>jquery.js"></script>
 <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>
</body>

</html> 


