<?php
try{
	$conn = new PDO("mysql:host=localhost;dbname=navarro", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SHOW TABLES";
    $stmt = $conn->query($query);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
}catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}
if(!empty($_POST)){
	$ddd = isset($_POST["ddd"]) ? $_POST["ddd"] : null;
	$modalidade = isset($_POST["modalidade"]) ? $_POST["modalidade"] : null;
	$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
	$formaVenda = isset($_POST["formaVenda"]) ? $_POST["formaVenda"] : null;
	try{
		$rows = array();
		foreach ($tables as $table) {
			$i = 0;
			$conn = new PDO("mysql:host=localhost;dbname=navarro", "root");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $query = "SELECT * FROM " . $table . " WHERE ";
		    if($ddd != 'Todos'){
		    	$i++;
		    	$query = $query . " ddd = '" . $ddd . "'";
		    }   
		    if($tipo != 'Ambos'){
		    	if($i > 0) {
		    		$query = $query . ' AND ';
		    	}
		    	$query = $query . " tipo = '" . $tipo . "'";
		    	$i++;

		    }
		    if($modalidade != 'Ambos'){
		    	if($i > 0) {
		    		$query = $query . ' AND ';
		    	}
		    	$query = $query . "	 modalidade = '" . $modalidade . "'";
		    	$i++;
		    }
		    if($formaVenda != 'Ambos'){
		    	if($i > 0) {
		    		$query = $query . ' AND ';
		    	}
		    	$query = $query . "	 formaVenda = '" . $formaVenda . "'";
		    	$i++;
		    }
		    $stmt = $conn->prepare($query); 
		    $stmt->execute();

		    $count = $stmt->rowCount();

		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			array_push($rows, $result);
		}
	}catch(PDOException $e)
    {
    	echo "Connection failed: " . $e->getMessage();
    }
}else{
	$formaVenda = null;
	try{
		$rows = array();
		foreach ($tables as $table) {
			$conn = new PDO("mysql:host=localhost;dbname=navarro", "root");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM " . $table); 
		    $stmt->execute();

		    $count = $stmt->rowCount();

		    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			array_push($rows, $result);
		}	
	}catch(PDOException $e)
    {
    	echo "Connection failed: " . $e->getMessage();
    }
}

$somaDeTodosPrecosAluguel = 0;
$somaDeTodosPrecosVenda = 0;
$quantidadeDeCasasParaAlugar = 0;
$quantidadeDeCasasParaAlugarComAreaInformada = 0;
$quantidadeDeCasasParaVender = 0;
$quantidadeDeCasasParaVenderComAreaInformada = 0;
$precoMedioDoMetroQuadradoAluguel = 0;
$precoMedioDoMetroQuadradoVenda = 0;

foreach ($rows as $arrays) {
	foreach ($arrays as $value) {
		if($value['formaVenda'] == 'Aluguel'){
			$somaDeTodosPrecosAluguel += $value['preco'];
			if(!empty($value['area'])){
				$precoMedioDoMetroQuadradoAluguel += $value['preco'] / $value['area'];
				$quantidadeDeCasasParaAlugarComAreaInformada++;
			}
			$quantidadeDeCasasParaAlugar++; 
		}else if ($value['formaVenda'] == 'Venda'){
			$somaDeTodosPrecosVenda += $value['preco'];
			if(!empty($value['area'])){
				$precoMedioDoMetroQuadradoVenda += $value['preco'] / $value['area'];
				$quantidadeDeCasasParaVenderComAreaInformada++;
			}
			$quantidadeDeCasasParaVender++; 
		}
	}
}

if($quantidadeDeCasasParaAlugar != 0){
	$precoMedioAluguel = $somaDeTodosPrecosAluguel / $quantidadeDeCasasParaAlugar;
	$precoMedioDoMetroQuadradoAluguelTotal = $precoMedioDoMetroQuadradoAluguel / $quantidadeDeCasasParaAlugarComAreaInformada;
}
if($quantidadeDeCasasParaVender != 0){
	$precoMedioVenda = $somaDeTodosPrecosVenda / $quantidadeDeCasasParaVender;
	$precoMedioDoMetroQuadradoVendaTotal = $precoMedioDoMetroQuadradoVenda / $quantidadeDeCasasParaVenderComAreaInformada;
}
