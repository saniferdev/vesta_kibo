<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title>GESTION STOCK || KIBO</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="icon" href="theme/kibo/images/favicon.ico" />
	<link rel="stylesheet" href="theme/kibo/plugins/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="theme/kibo/plugins/bootstrap/responsive.bootstrap.min.css">	
	<link rel="stylesheet" href="theme/kibo/plugins/themify-icons/themify-icons.css">
	<link href="theme/kibo/assets/style.css" rel="stylesheet" media="screen" />
	<link rel="stylesheet" href="theme/kibo/plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="theme/kibo/plugins/jquery/jquery-ui.css">
	<link rel="stylesheet" href="theme/kibo/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="theme/kibo/plugins/bootstrap-datepicker/bootstrap-datepicker.standalone.min.css">
	
</head>

<body>
	<div id="loading">
      <img id="loading-image" src="theme/kibo/images/chargement.gif" alt="Chargement..." />
    </div> 
	<header class="banner overlay bg-cover" data-background="theme/kibo/images/banner.jpg">
		<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-red navbar-dark">
	       <div class="wrapper">
          
		   </div>
		  <div class="container-fluid all-show">
		    <a class="navbar-brand" href="#"><img id="logo" src="theme/kibo/images/Logo_kibo.png" alt=""/></a>
		    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="home.php">Mvt Inventaire</a>
		        </li>        
		        
		      </ul>
		      <div class="d-flex flex-column sim">

		        <span></span>
		        <small class="text-primary"></small>
		        
		      </div>
		    </div>
		  </div>
	        <a class="nav-item mr-3 nav-link p-3 aDeconnexion" href="index.php"><img title="Se déconnecter" alt="Se déconnecter" class="deconnexion" src="theme/kibo/images/deconnexion.png"></a>
	    </nav>
		<div class="container section header_">
			<div class="row">
				<div class="col-lg-8 text-center mx-auto margin_t">
					<h1 class="text-titre mb-3">INVENTAIRE KIBO</h1>
					<div class="position-relative">
						<input id="search_" class="form-control" placeholder="N° Inventaire, N° Session"><i class="ti-search search-icon"></i>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		
				<div class="col-12">
					<div class="section px-3 bg-white shadow text-left">
						<button class="btn btn-warning import_csv" type="button" data-toggle="collapse" data-target="#telechargement" aria-expanded="false" aria-controls="telechargement">
							Importer un fichier
						</button>
						<hr/>
						<div class='row collapse' id='telechargement'>
							<div class='col-md-12 border p-3 card card-body'>
								<h4>Import du fichier d'inventaire</h4><hr>  
								<form method='POST' id='frm' enctype="multipart/form-data">
									<div class='form-group'>
									<input type='file' name='file' class='form-control form-control-sm' required>
									</div>
									<div class='form-group'>
									<input type='submit' value='Importer' class='btn btn-primary btn-sm'>
									</div>
									<div class="progress mt-4 mb-3">
									<div class="progress-bar bg-success" id='progress-bar' role="progressbar" style="width:0%;" >0%</div>
									</div>
								</form>
								<div id='result'></div>
							</div>
						</div>
					</div>
					<div class="section s_ px-3 bg-white shadow text-left">
						<h3 class="text-titre">Détail de l'inventaire</h3>
						<table class="table detail table-borderless">
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>

					</div>
				</div>
				<div class="r"></div>
		
	</section>

	<footer class="section pb-4">
			<div class="row">
				<div class="col-md-12 text-md-right">
					<p class="mb-md-0 mb-4" style="margin-right: 70px !important;">Copyright © 2024 <a href="https://www.kibo.mg/" target="_blank">KIBO</a></p>
				</div>
			</div>
	</footer>

	<input type="hidden" id="site" value="<?php echo !empty($_SESSION['site']) ? $site : '';?>">

	<script type="text/javascript" src="theme/kibo/plugins/jquery/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/bootstrap/datatables.min.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/match-height/jquery.matchHeight-min.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="theme/kibo/plugins/bootstrap-datepicker/bootstrap-datepicker.fr.min.js"></script>
	<script type="text/javascript" src="theme/kibo/assets/script.js"></script>
	
</body>

</html>