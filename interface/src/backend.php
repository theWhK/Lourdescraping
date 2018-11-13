<?php
	if(!empty($_POST)){
		$ddd = isset($_POST["ddd"]) ? $_POST["ddd"] : null;
		$modalidade = isset($_POST["modalidade"]) ? $_POST["modalidade"] : null;
		$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
		try{
			$conn = new PDO("mysql:host=localhost;dbname=navarro", "root");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $query = "SELECT * FROM teste WHERE ddd = ? and tipo = ?";
		    if($modalidade != 'Ambos'){
		    	$query = $query . " and modalidade = ?";
		    }
		    $stmt = $conn->prepare($query); 
		    $stmt->bindParam(1, $ddd);
		    $stmt->bindParam(2, $tipo);
		    $modalidade != 'Ambos' ? $stmt->bindParam(3, $modalidade) : '' ;
		    $stmt->execute();

		    $count = $stmt->rowCount();

		    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
	}else{
		try{
			$conn = new PDO("mysql:host=localhost;dbname=navarro", "root");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $conn->prepare("SELECT * FROM teste"); 
		    $stmt->execute();

		    $count = $stmt->rowCount();

		    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
	}
