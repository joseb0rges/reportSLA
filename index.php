<?php

//require_once 'dataSet.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'conect_zabbix.php';
require_once 'SLA.php';

$data=date('d-m-y');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_mes = strftime('%B/%Y', strtotime('today'));

?>

<html>
<head>
	<meta charset="utf-8">
	<link href="css/estilo.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<script type='text/javascript' src='js/jquery-1.8.3.js'></script>
	<script type='text/javascript' src='js/exportcsv.js'></script>
	<link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
	<script type='text/javascript' src="js/bootstrap-datepicker.min.js"></script>
	<script type='text/javascript'>
		
		$(document).ready(function(){
			var today = new Date();
			$('.input-group.date').datepicker({
				format: 'dd-mm-yyyy ',
				timepicker: true,
				todayHighlight: true,
				autoclose: true,
				
				
			});
		});
	</script>

	<title>Relatório SLA</title>
</head>

<body>
	<div class="navbar navbar-dark bg-primary navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand"><img src="img/zabbix.png" width="50" height="25"/></a>
			</div>	
		</div>
	</div><br/><br/><br/><center>
		<form class="form-inline" method="POST">
			<div class="form-group mb-2">
				<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="container">
						<div class="form-group">
							<label>OS -> </label>
							<select class="form-control" name="OS">
								<option>R005 - SGBD</option>
								<option>R006 - SISTEMAS OPERACIONAIS</option>
								<option>R007 - INFRAESTRUTURA DE REDE</option>
								<option>R008 - BACKUP</option>
								<option>R010 - VIRTUALIZACAO</option>
								<option>R011 - APLICACOES WEB</option>
								<option>R012 - SEGURANCA DA INFORMACAO</option>
								<option>R013 - STORAGE</option>
								<option>R014 - MENSAGERIA</option>
							</select>
						</div>
						From: <div class="input-group date form_datetime">
							<input  name="call01" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						To: <div class="input-group date form_datetime">
							<input  name="call02" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<button type="submit" class="btn btn-primary mb-2">Generate Report</button>

					</div>
				</form>

			</div>

		</form>
	</center>
	<div class="container">
		<div class="principal">


			<?php


			if(isset($_POST["call01"]) && (!empty($_POST["call01"])) && isset($_POST["call02"]) && (!empty($_POST["call02"])) && isset($_POST["OS"]) && (!empty($_POST["OS"]))){

				$dados = new SLA($api);
				$name_OS = $_POST["OS"];

				$serviceParentID = $dados->getSLAID($name_OS);

				$dependencesID = $dados->getchildrens();
				$countdependences = count($dependencesID);


				$hora_date_from = $_POST["call01"].date('H:i:s');
				
				$hora_date_to = $_POST["call02"].date('H:i:s');

				$date_to = new DateTime($hora_date_to);
				$date_from = new DateTime($hora_date_from);
				
				$from = $date_from->getTimestamp();
				$to = $date_to->getTimestamp();
				

				$data_mesp=date('d/m/Y',$from);
				$data_atual=date('d/m/Y',$to); 

				?>
				<center><h3><strong>RELATÓRIO DE SLA</strong></h3></center><br/>
				<form class="form-inline">
					<div class="form-group mb-2 pull-left">
						<p><?=$data_mesp?> a <?=$data_atual?></p></div>
						<div class="form-group mx-sm-3  mb-2 pull-right">
							<input class="form-control" id="myInput" type="text" placeholder="Search..">	
							<button type="button" class="btn btn-primary mb-2" onclick="exportTbToCSVformat('RelatórioSla_<?=$data?>.csv')">Export to CSV</button></div></form><br/><br/>
							<div class="table-wrapper-scroll-y my-custom-scrollbar">
								<table class="table table-striped  table-hover">
									<thead>
										<tr>
											<th style="text-align:center">NOME</th>
											<th style="text-align:center" >DISPONIBILIDADE %</th>
											<th style="text-align:center">DECREMENTO</th>
											<th style="display: none;"><?php echo $data_mes;?></th>
										</tr>
									</thead>
									<?php 


									for ($i = 0; $i < $countdependences; $i++) {

										if ($dependencesID[$i]->parentDependencies[0]->serviceid == $serviceParentID[0]->serviceid){
											
											?>
											<tbody id="myTable">
												<tr>

													<td align='center'><?php echo utf8_encode($dados->getNameSLA($dependencesID[$i]->serviceid)[0]->name); ?></td>
													<td align='center'><?php echo $dados->getSLA($dependencesID[$i]->serviceid,$from,$to);?></td>
													<td align='center'><?php

													if (substr(100 - $dados->getSLA($dependencesID[$i]->serviceid,$from,$to),0,5) == 0){ ?>

														<span class="alert alert-success" role="alert">Não Houve</span>
														<?php

													}else { ?>

														<span class="alert alert-danger" role="alert"><?php echo substr(100 - $dados->getSLA($dependencesID[$i]->serviceid,$from,$to),0,5);?></span>
														<?php 

													}
													?></td>


												</tr>

												<?php
											}
										} 

										?>
									</tbody>
								</table>
							</div> 
						</div>
					</div>
					<script>
						$(document).ready(function(){
							$("#myInput").on("keyup", function() {
								var value = $(this).val().toLowerCase();
								$("#myTable tr").filter(function() {
									$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
								});
							});
						});
					</script>
					<?php

				}

				?>
			</body>
			</html>

