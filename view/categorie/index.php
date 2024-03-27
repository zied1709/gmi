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
require '..\..\inc\header2.php';
require '..\..\model\ModelCategorie.php';
require '..\..\model\App.php';

$db = App::getDB();
?>

<?php
// new categorie
  if (!empty($_POST['name']) && !isset($_POST['code'])){
    $name=$_POST['name'];
    
    $c = new ModelCategorie($name);
    $c->save($db);
  }

// update categorie 
  if (isset($_POST['code']) && !empty($_POST['name'])){
    $name=$_POST['name'];
    $c = new ModelCategorie($name);
    $c->save($db,$_POST['code']);
  }

// delete categorie
  if(isset($_GET['deletedcode'])){
    ModelCategorie::delete($db,$_GET['deletedcode']);
    }
?>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Categorie</h1>
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
          <li><a href="../produit/index.php">Products</a></li>
          <li><a class="active"  href="index.php">Categorie</a></li>
          <li><a href="../order/index.php">Orders</a></li>
          <li><a href="../user/index.php">Users</a></li>
          <li><a href="../admin/index.php">Admin</a></li>
          <li><a href="../user/profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper user-dashboard">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $rows = ModelCategorie::getAll($db);
                if($rows){
                    $i=0;
                    foreach($rows as $row){
                        $i+=1;
                        ?>
                        <tr scope="row">
                          <td><?=$i;?></td>
                          <td><?=$row->name;?></td>
      
                          <td>
                            <div class="btn-group" role="group">
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