<?php

	require_once 'core/init.php';
	
	$_db = DB::getInstance();
	$_db->find($_GET["id"],'novosti');
	$array_obavjesti = $_db->results();	
	$_db->get('path','novosti',array('id','=',$_GET["id"]));
	$array_paht=$_db->results();
	$img_folder=$array_paht[0]['path'];
	$images = glob($img_folder.'/*.*');
		
	
?>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://www.expertphp.in/js/jquery.form.js"></script>
</head>
<body>
	<div class="row">
		<div class="col-md-15 col-md-offset-0" id="accordion">
			<div class="jumbotron">
				<h1 class="text-center"><?php echo $array_obavjesti[0]['heading']?></h1>
			</div>
		</div>
		<div class="col-md-10 col-md-offset-1">
		<a href="index.php"><--Povratak</a>
		</div>
		<div class="panel-group col-md-10 col-md-offset-1">
			<div class="panel panel-primary" >			
					<div class="panel-body">						
					<textarea  type="text" class="form-control" name="sadr" id="sadr" rows="5"><?php echo $array_obavjesti[0]['content']?></textarea>															
					<div class="row" id="image_preview"></div>
					<br>
					<div class="panel-body">								
						<?php
						$i=2;
						echo'<table class="table table-hover">
							<tbody>
							<tr>';
						foreach($images as $image) {									
							$i++;
							if($i==3){
								echo'</tr>
									<tr>';
								$i=0;
							}	
						echo'<td><img src="'.$image.'" style="width:300px;height:200px;" /></td>';									
						}							
						echo'</tr>
							</tbody>
							</table>';
						?>								
					</div>						
				</div>				
			</div>
		</div>
	</div>
</body>
<?php

	Helper::getFooter();

?>	