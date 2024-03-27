<?php
 

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=gmi", "root", "");


//fetch_data.php
if (isset($_POST["action"])) {
	$query = "
		SELECT produit.code as id, produit.name as name ,price,produit.is_deleted, image ,categorie.name as categorie FROM produit LEFT JOIN categorie
		ON code_categorie = categorie.code WHERE produit.is_deleted = '0'";

	if (isset($_POST["categorie"])) {
		$categorie_filter = implode("','", $_POST["categorie"]);
		$query .= "
		 AND code_categorie IN('".$categorie_filter."')
		";
	}



	if (isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
		$query .= "
		 AND price BETWEEN '" . $_POST["minimum_price"] . "' AND '" . $_POST["maximum_price"] . "' ORDER BY price asc
		";
	}
	else{
		$query .="ORDER BY id desc";
	}





	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		foreach ($result as $row) {
			$output .= '<div class="col-md-4"> '
                
			.'<div class="product-item"> '

				.'<div class="product-thumb"> '
					."<a href='products.php?code=" . $row['id'] . "'>"
				.'</div> '

				.'<div class="product-content"> '
				.'<img  src="../uploads/produits/' . $row['id'] . '_' . $row['name'] . "/" . $row['image'] . '" height="200px" width="200px"> '

					.'<h4>' . $row['name'] . '</h4> '
					.'<p>' . $row['price'] . ' TND</p> '
				.'</div> '
			.'</div> '

		.'</div> ';
		}

		
	} else {
		$output = '<h3 style ="text-align:center;margin-top: -30px;">No Data Found</h3> <p style ="text-align:center;margin-top: -30px;"><img style="width:50%" src="../images/ajax/nodata.png"></p>';
	}
	echo $output;
}
