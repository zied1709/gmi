<?php 
if(session_status()== PHP_SESSION_NONE){
    session_start();
}
if ($_SESSION['admin'] == 0) {
  $_SESSION['flash']['danger']="Vous n'avez pas le droit d'accéder à cette page";
    header('Location: ..\login.php');
}
?>

<?php 
require '..\..\model\App.php';
$db = App::getDB();
require '..\util.php';
require '..\..\model\ModelUser.php';

require '..\..\model\ModelProduit.php';

// Compter le nb de produits existants

if (!isset($_COOKIE['nbprod'])){
  $row = ModelProduit::product_get_last($db);
  setcookie('nbprod', $row->code , time() + (86400 * 30 * 30), "/"); // 86400 = 1 day
}
if (isset($_SESSION['auth'])){
	$res = ModelUser::getbyCode($db,$_SESSION['auth']);
}
?>



<?php  
// new product  

  // upload image
  if (!empty($_POST['name']) && !isset($_POST['code'])){
    $name=$_POST['name'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $categorie=$_POST['code_categorie'];
    
    list($image,$tmpName) = uploadImages('image');
    list($image2,$tmpName2) = uploadImages('image2');
    list($image3,$tmpName3) = uploadImages('image3');
    list($image4,$tmpName4) = uploadImages('image4');
    
    $p = new ModelProduit($name,$price,$image,$categorie,$description,$image2,$image3,$image4);
    $p->save($db);
    setcookie('nbprod', $_COOKIE['nbprod'] +1 , time() + (86400 * 30 * 30), "/"); // 86400 = 1 day

    $lastInsert = ModelProduit::product_get_last($db);
    $code = $lastInsert->code;
    $target_dir = '../../uploads/produits/'.$code.'_'.$name.'/';

    if (!is_dir($target_dir)) {
      mkdir($target_dir);
    }

    move_uploaded_file($tmpName, $target_dir.$image);
    move_uploaded_file($tmpName2, $target_dir.$image2);
    move_uploaded_file($tmpName3, $target_dir.$image3);
    move_uploaded_file($tmpName4, $target_dir.$image4);


  }

// update produit 
  if (isset($_POST['code']) && !empty($_POST['name'])){
    $name=$_POST['name'];
    $name2=$_POST['name2'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $categorie=$_POST['code_categorie'];

    $target_dir = '../../uploads/produits/'.$_POST['code'].'_'.$name.'/';

    if (!is_dir($target_dir)) {
      mkdir($target_dir);
    }

    // image 1
    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
      list($image,$tmpName) = uploadImages('image');
      move_uploaded_file($tmpName, $target_dir.$image);
    }
    elseif($name==$name2){
      $image=$_POST['img'];
    }
    else{
      $image=$_POST['img'];
      copy('../../uploads/produits/'.$_POST['code'].'_'.$name2.'/'.$image, '../../uploads/produits/'.$_POST['code'].'_'.$name.'/'.$image);
    }

    // image 2
    if(isset($_FILES['image2']) && !empty($_FILES['image2']['name'])){
      list($image2,$tmpName2) = uploadImages('image2');
      move_uploaded_file($tmpName2, $target_dir.$image2);

    }
    elseif($name==$name2){
      $image2=$_POST['img2'];
    }
    else{
      $image2=$_POST['img2'];
      copy('../../uploads/produits/'.$_POST['code'].'_'.$name2.'/'.$image2, '../../uploads/produits/'.$_POST['code'].'_'.$name.'/'.$image2);
    }

    // image 3
    if(isset($_FILES['image3']) && !empty($_FILES['image3']['name'])){
      list($image3,$tmpName3) = uploadImages('image3');
      move_uploaded_file($tmpName3, $target_dir.$image3);
    }
    elseif($name==$name2){
      $image3=$_POST['img3'];
    }
    else{
      $image3=$_POST['img3'];
      copy('../../uploads/produits/'.$_POST['code'].'_'.$name2.'/'.$image3, '../../uploads/produits/'.$_POST['code'].'_'.$name.'/'.$image3);
    }

    // image 4
    if(isset($_FILES['image4']) && !empty($_FILES['image4']['name'])){
      list($image4,$tmpName4) = uploadImages('image4');
      move_uploaded_file($tmpName4, $target_dir.$image4);
    }
    elseif($name==$name2){
      $image4=$_POST['img4'];
    }
    else{
      $image4 = $_POST['img4'];
      copy('../../uploads/produits/'.$_POST['code'].'_'.$name2.'/'.$image4, '../../uploads/produits/'.$_POST['code'].'_'.$name.'/'.$image4);
    }

    $p = new ModelProduit($name,$price,$image,$categorie,$description,$image2,$image3,$image4);

    $p->save($db,$_POST['code']);

  }


// delete product
  if(isset($_GET['deletedcode'])){
    ModelProduit::delete($db,$_GET['deletedcode']);
  }


  require '..\..\inc\header2.php';

?>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">my account</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="user-dashboard page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="list-inline dashboard-menu text-center">
          <li><a class="active"  href="index.php">Products</a></li>
          <li><a href="../categorie/index.php">Categorie</a></li>
          <li><a href="../order/index.php">Orders</a></li>
          <li><a href="../user/index.php">Users</a></li>
          <li><a href="../admin/index.php">Admin</a></li>
          <li><a href="../user/profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper user-dashboard">
		  <div class="media">
			<div class="pull-left">
				<img class="media-object user-img" src="../../uploads/users/<?=$res->image?>" alt="Image">
			</div>
			<div class="media-body">
				<h2 class="media-heading">Welcome <?=$res->first_name?> <?=$res->last_name?></h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde, iure, est. Sit mollitia est maxime! Eos
					cupiditate tempore, tempora omnis. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim, nihil. </p>
			</div>
		  </div>
		  <br><br>
          <div class="table-responsive">
            <table class="table">
              <thead>

                <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Categorie</th>
                  <th class="col-md-2 col-sm-3">Image</th>
                  <th>Actions</th>
                </tr>

              </thead>
              <tbody>
                <?php
                $rows = ModelProduit::getAll($db);
                if($rows){
                    $i=0;
                    foreach($rows as $row){
                        $i+=1;
                        ?>
                        <tr scope="row">
                          <td><?=$row->code;?></td>
                          <td><?=$row->name;?></td>
                          <td style="width:25%;"><?=$row->description;?></td>
                          <td><?=$row->price;?></td>
                          <td><?=$row->categorie;?></td>
                          <td><img src="../../uploads/produits/<?=$row->code?>_<?=$row->name?>/<?=$row->image?>" style="width:60px;height:60px;"></td>
                          <td>
                            <div class="btn-group" role="group">
                              <a href="../products.php?code=<?=$row->code?>" class="btn btn-default">View</a>
                              <button onclick="window.location.href = 'edit.php?codeedit=<?=$row->code?>';" type="button" class="btn btn-default"><i class="tf-pencil2" aria-hidden="true"></i></button>
                              <button onclick="window.location.href = 'index.php?deletedcode=<?=$row->code?>';" type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button>
                            </div>
                          </td>
                        </tr>
                <?php
                    }
                }?>
              
              </tbody>
            </table>		
            <hr>	
          </div>
          <a href="new.php" class="btn btn-default">Create new</a>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require '..\..\inc\footer2.php' ?>