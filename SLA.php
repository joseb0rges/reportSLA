<?php

class SLA {
	private $con;
	function __construct($con){ //Construtor
		$this->con = $con;
	}

//Metodo  para exibição do percentual de SLA

	public function getSLA($idsla,$from,$to) {
		$dadosla = $this->con->serviceGetSla(array(

			"serviceids" => $idsla,
			'intervals' => array(
				'from' => $from,
				'to' =>  $to
			)
		));

		foreach ($dadosla as $value)
			$percslas = (string) $value->sla[0]->sla;
		$percsla = substr($percslas,0,5);
		return $percsla;

	}

// Metodo para Exibição do nome SLA de acordo com ID do mesmo.

	public function getNameSLA($serviceID) {

		$nameSLA = $this->con->serviceGet(array(


			"filter" => array(

				"serviceid" => $serviceID

			),
				"output" => array("name")
		));

		return $nameSLA;
	}



// Metodo que exibe o ID do SLA

	public function getSLAID($nameSLA){
		$Slaid = $this->con->serviceGet(array(
			"filter" => array(
				"name" => $nameSLA
			),
			"output" => array("serviceid")

		));

		return $Slaid;

	}



// Discovery Filhos de acordo com o Parent Service

public function getchildrens(){

	$childremID = $this->con->serviceGet(array(
	
		 "selectParentDependencies" => "extend",
		 "output" => "dependencies"

	));

	return $childremID;

}


// Metodo para Exibição do nome SLA que começão com R
		
	public function getNameParent() {  
		$dataset = $this->con->serviceGet(array(

			"filter" => array("triggerid" => "0"),
			'output' => array("name")
		));

		$nameParentftl = array();
		for($i=0;$i<sizeof($dataset);$i++){

			$contains = preg_match('/^R/',$dataset[$i]->name); // Parametro de busca dos Grupo de SLA (Parent Service)

			if($contains === 1) {

				$nameParentftl[]= $dataset[$i]->name;
			}
		} 

		return $nameParentftl;
	}

}

?>