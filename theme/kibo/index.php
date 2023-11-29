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
		        <li class="nav-item">
		          <a class="nav-link" href="sortie.php">Mvt Sortie</a>
		        </li>
		        
		        
		      </ul>
		      <div class="d-flex flex-column sim">

		        <span></span>
		        <small class="text-primary"></small>
		        
		      </div>
		    </div>
		  </div>
	        <a class="nav-item mr-3 nav-link p-3" href="index.php"><img title="Se déconnecter" alt="Se déconnecter" class="deconnexion" src="theme/kibo/images/deconnexion.png"></a>
	    </nav>
		<div class="container section header_">
			<div class="row">
				<div class="col-lg-8 text-center mx-auto margin_t">
					<h1 class="text-titre mb-3">VESTA</h1>
					<div class="position-relative">
						<input id="search" class="form-control" placeholder="Réf.; Desc.; CB; Ref fourn..."><i class="ti-search search-icon"></i>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section>
		
				<div class="col-12">
					<div class="section px-3 bg-white shadow text-right">
						<h3 class="text-titre">Mouvement d'inventaire</h3>
						<form action="./tcpdf/kibo/impression.php" method="post" >
							<table class="table table-hover table-fixed">
							  <thead>
							    <tr>
							      <th>N°</th>
							      <th>Désignation</th>
							      <th>Fam</th>
							      <th>Famille</th>
							      <th>Sous famille</th>
							      <th>Ref Fournisseur</th>
							      <th>Emplacement</th>
							      <th>Lot</th>
							      <th>Date de péremption</th>
							      <th class="KIBO">Stock</th>
							      <th></th>
							    </tr>
							  </thead>
							  <tbody class="articles_">							    
							  </tbody>
							</table>
							<button type="button" class="btn btn-info hidden-print Ajouter">Ajouter</button>
							<button class="btn btn-danger hidden-print supprimer_tout" >Supprimer tout</button>
						</form>
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

	<div class="modal fade edition" id="editModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h5_" id="ModalLabel">INVENTAIRE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data"  method="POST" id="envoi_">
                        <input type="hidden" id="id" value="">
                        <div class="form-group">
                            <label for="Référence">N°</label>
                            <input type="text" name="ref" class="form-control" id="ref" placeholder="Référence" disabled>
                        </div>
                        <div class="form-group">
                            <label for="Emplacement">Emplacement</label>
                            <input type="text" name="emp" class="form-control" id="emp" placeholder="Emplacement">
                        </div>
                        <div class="form-group">
                            <label for="Lot">Lot</label>
                            <input type="text" name="lot" class="form-control" id="lot" placeholder="Lot">
                        </div>
                        <div class="form-group">
                            <label for="Date de péremption">Date de péremption</label>
                            <input type="text" name="date_" class="form-control" id="date_" >
                        </div>
                        <div class="form-group">
                            <label for="Quantité">Quantité</label>
                            <input type="number" name="qte" class="form-control" id="qte" placeholder="Quantité">
                        </div>

                        
                        <div class="modal-footer">
                            <a  class="btn btn-secondary fermer" data-dismiss="modal">Fermer</a>
                            <button type="button"  id="envoi" class="btn btn-primary" data-dismiss="modal">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	

	<footer class="section pb-4">
			<div class="row">
				<div class="col-md-12 text-md-right">
					<p class="mb-md-0 mb-4" style="margin-right: 70px !important;">Copyright © 2022 <a href="https://www.kibo.mg/">KIBO</a></p>
				</div>
			</div>
	</footer>

	<input type="hidden" id="site" value="<?php echo !empty($_SESSION['site']) ? $site : '';?>">

	<script src="theme/kibo/plugins/jquery/jquery-1.12.4.js"></script>
	<script src="theme/kibo/plugins/bootstrap/bootstrap.min.js"></script>
	<script src="theme/kibo/plugins/bootstrap/datatables.min.js"></script>
	<script src="theme/kibo/plugins/match-height/jquery.matchHeight-min.js"></script>
	<script src="theme/kibo/plugins/jquery/jquery-ui.js"></script>
	<script src="theme/kibo/assets/script.js"></script>
</body>

</html>