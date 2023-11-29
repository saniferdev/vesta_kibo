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
		        <li class="nav-item" style="display: none;">
		          <a class="nav-link" aria-current="page" href="home.php">Mvt Inventaire</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link active" href="sortie.php">Mvt Sortie</a>
		        </li>
		        
		        
		      </ul>
		      <div class="d-flex flex-column sim">

		        <span></span>
		        <small class="text-primary"></small>
		        
		      </div>
		    </div>
		  </div>
	        <a class="imprim" href="#Impression" role="button" data-toggle="modal"><img title="Imprimer les sorties" alt="Imprimer les sorties" class="print" src="theme/kibo/images/print.png"></a>
	        <a class="nav-item mr-3 nav-link p-3 aDeconnexion" href="index.php"><img title="Se déconnecter" alt="Se déconnecter" class="deconnexion" src="theme/kibo/images/deconnexion.png"></a>
	    </nav>
		<div class="container section header_">
			<div class="row">
				<div class="col-lg-8 text-center mx-auto margin_t">
					<h1 class="text-titre mb-3">VESTA</h1>
					<div class="position-relative">
						<input id="search_" class="form-control" placeholder="Réf.; Desc.; CB; Ref fourn..."><i class="ti-search search-icon"></i>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		
				<div class="col-12">
					<div class="section px-3 bg-white shadow text-right">
						<h3 class="text-titre">Mouvement de sortie</h3>
						<form action="#" method="post" >
							<table class="table table-hover table-fixed">
							  <thead>
							    <tr>
							      <th>N°</th>
							      <th>Désignation</th>
							      <th>Emplacement</th>
							      <th>Lot</th>
							      <th>Quantité</th>
							      <th></th>
							    </tr>
							  </thead>
							  <tbody class="articles_">							    
							  </tbody>
							</table>
							<button type="button" class="btn btn-info hidden-print Ajouter_sortie">Valider</button>
							<button class="btn btn-danger hidden-print supprimer_tout" >Supprimer tout</button>
						</form>
						<div class="alert alert-info message" role="alert"></div>
					</div>
				</div>
				<div class="r"></div>
		
	</section>

	<div class="modal fade Articlemodal-lg" tabindex="-1" role="dialog" aria-labelledby="Listes articles KIBO" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <h5 class="modal-title" id="ModalCenterTitle">Listes des articles KIBO</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
			    <div class="modal-body">
			    	<table id="datatable_" class="table table-striped table-bordered dt-responsive nowrap">
						<thead>
							<tr>
							   	<th scope="col">N°</th>
							    <th scope="col">Désignation</th>
							    <th scope="col">Famille</th>
							    <th scope="col">Ref fournisseur</th>
							</tr>
						</thead>
						<tbody class="resultat">
						</tbody>
					</table>
			    </div>
			    <div class="modal-footer">
			    </div>
			</div>
		</div>
	</div>

	<div class="modal fade detail" tabindex="-1" role="dialog" aria-labelledby="Détail" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	<form class="ajout_ligne">
			      	<div class="modal-header">
				        <h5 class="modal-title" id="ModalCenterTitle">Détail</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
				    <div class="modal-body">
				    	<div class="container">
	  						<div class="row">
	  							 <div class="col resultat_">
	  							 </div>
	  							 <div class="col">
	  							 	<div class="form-outline">
									  <input type="number" name="qte_sortie" id="qte_sortie" class="form-control float-end text-end" min="1"/>
									  <label class="form-label" for="qte_sortie">Quantité à sortir</label>
									</div>
	  							 </div>
	  						</div>
	  						<div class="alert alert-danger info">
							  <strong>Veuillez renseigner la quantité et l'emplacement svp.</strong>
							</div>
						</div>
				    </div>
				    <div class="modal-footer">
	                    <input type="submit" id="valid_sortie" name="valider_sortie" class="btn btn-primary" value="Valider" >
				    </div>
				</form>
			</div>
		</div>
	</div>

	<div id="Impression" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Mvt_Sortie" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		    	<div class="modal-header">
				    <h5 class="modal-title" id="Mvt_Sortie">Impression des mvt de sorties</h5>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				        <span aria-hidden="true">&times;</span>
				    </button>
			    </div>
				  <div class="modal-body">
				  	<div class="container">
		  				<div class="row dateRange">
						  <div class="col-sm-6">
						    <label for="startDate">Début</label>
						    <div class="input-group mb-3">
						      <input type="text" class="form-control dateRangeInput" id="startDate" placeholder="Date de début">
						      <div class="input-group-append input-group-addon">
						        <button class="btn btn-outline-secondary dateRangeTrigger" type="button"><i aria-label="Date de début" class="fa fa-calendar" aria-hidden="true"></i></button>
						      </div>
						    </div>
						  </div>
						  <div class="col-sm-6">
						    <label for="endDate">Fin</label>
						    <div class="input-group mb-3">
						      <input type="text" class="form-control dateRangeInput" id="endDate" placeholder="Date de fin">
						      <div class="input-group-append input-group-addon">
						        <button class="btn btn-outline-secondary dateRangeTrigger" type="button"><i aria-label="Date de fin" class="fa fa-calendar" aria-hidden="true"></i></button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				  </div>
				<div class="modal-footer">
	                <input type="submit" id="print_" name="print_" class="btn btn-primary" value="Imprimer" >
				</div>
			</div>
		</div>
	</div>


	<footer class="section pb-4">
			<div class="row">
				<div class="col-md-12 text-md-right">
					<p class="mb-md-0 mb-4" style="margin-right: 70px !important;">Copyright © 2023 <a href="https://www.kibo.mg/" target="_blank">KIBO</a></p>
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