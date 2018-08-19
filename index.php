<?php

	require_once 'core/init.php';
	
	$_db = DB::getInstance();

	
?>
<head>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script>
function preview_images() 
{
 var total_file=document.getElementById("images").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<div class='col-md-3'><img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }
}
</script>
</head>
<body>
	<div class="row">
		<div class="col-md-15 col-md-offset-0" >
			<div class="jumbotron">
				<h1 class="text-center">Dobrodošli na web stranicu</h1>
			</div>
		</div>
		<div class="panel-group col-md-10 col-md-offset-1">
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h3 class="panel-title">
					
					Pregled novosti
					</h3>
				</div>
				<div class="panel-body" id="novost" >
					<?php 
					$_db->get('heading,created,id,objava','novosti');
					$array_obavjesti = $_db->results();
					echo'
						<div class="container col-md-10">
							<h2>Novosti</h2>        
							  <table class="table table-hover">
								<thead>
								  <tr>									
									<th>Datum objave</th>
									<th>Naziv objave</th>
									<th></th>
									<th></th>
								  </tr>
								</thead>
								<tbody>';
					krsort($array_obavjesti);					
					foreach($array_obavjesti as $obavjest) {
						if($obavjest['objava']=='1'){
							echo ' <tr>		
									<td>'.mb_substr($obavjest['created'], 0, 10).'</td>
									<td>'.$obavjest['heading'].'</td>									
									<td> <a href="view.php?id='.$obavjest['id'].'">Pregledaj</a></td>
								  </tr>';
						}
					}										
					echo'	</tbody>
						</table>
					</div>';
					?>					
				</div>
			</div>
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h3 class="panel-title">
					
					Pregled galerija
					</h3>
				</div>
				<div class="panel-body" id="galerija" >
					<?php 
					$_db->get('heading,created,id,objava','novosti');
					$array_obavjesti = $_db->results();
					echo'
						<div class="container col-md-10">
							<h2>Galerije</h2>        
							  <table class="table table-hover">
								<thead>
								  <tr>									
									<th>Datum objave</th>
									<th>Naziv objave</th>
									<th></th>
									<th></th>
								  </tr>
								</thead>
								<tbody>';
					krsort($array_obavjesti);					
					foreach($array_obavjesti as $obavjest) {
						if($obavjest['objava']=='2'){
							echo ' <tr>		
									<td>'.mb_substr($obavjest['created'], 0, 10).'</td>
									<td>'.$obavjest['heading'].'</td>									
									<td> <a href="view.php?id='.$obavjest['id'].'">Pregledaj</a></td>
								  </tr>';
						}
					}										
					echo'	</tbody>
						</table>
					</div>';
					?>					
				</div>
			</div>
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h3 class="panel-title">
					
					Pregled događaja
					</h3>
				</div>
				<div class="panel-body" id="dogadjaj" >
					<?php 
					$_db->get('heading,created,id,objava','novosti');
					$array_obavjesti = $_db->results();
					echo'
						<div class="container col-md-10">
							<h2>Događanja</h2>        
							  <table class="table table-hover">
								<thead>
								  <tr>									
									<th>Datum objave</th>
									<th>Naziv objave</th>
									<th></th>
									<th></th>
								  </tr>
								</thead>
								<tbody>';
					krsort($array_obavjesti);					
					foreach($array_obavjesti as $obavjest) {
						if($obavjest['objava']=='3'){
							echo ' <tr>		
									<td>'.mb_substr($obavjest['created'], 0, 10).'</td>
									<td>'.$obavjest['heading'].'</td>									
									<td> <a href="view.php?id='.$obavjest['id'].'">Pregledaj</a></td>
								  </tr>';
						}
					}										
					echo'	</tbody>
						</table>
					</div>';
					?>					
				</div>
			</div>
		</div>
	</div>
</body>
<?php

	Helper::getFooter();

?>	
	
