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
require '..\..\model\App.php';

$db = App::getDB();
require '..\util.php';
require '..\..\model\ModelUser.php';

?>

<?php

// new admin

  // upload image
  if (!empty($_POST['first_name']) && !isset($_POST['id'])){

    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $email=$_POST['email'];
    $telephone=$_POST['telephone'];
    $admin=0;

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    list($image,$tmpName) = uploadImages('image');

    $u = new ModelUser($last_name,$image,$first_name,$email,$password,$telephone,$admin);
    $u->save($db);

    $target_dir = '../../uploads/users/';
    move_uploaded_file($tmpName, $target_dir.$image);
  }

// update user 
  if (isset($_POST['id']) && !empty($_POST['first_name'])){
    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
      $target_dir = '../../uploads/users/';
      list($image,$tmpName) = uploadImages('image');
      move_uploaded_file($tmpName, $target_dir.$image);
    }
    else{
      $image=$_POST['img'];
    }

    if (isset($_POST['admin'])){
      $admin=$_POST['admin'];
    }
    else{
      $admin=0;
    }

    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $telephone=$_POST['telephone'];

    $u = new ModelUser($last_name,$image,$first_name,$email,$password,$telephone,$admin);
    $u->save($db,$_POST['id']);
  }

// delete user 
  if(isset($_GET['deletedcode'])){
    ModelUser::delete($db,$_GET['deletedcode']);
  }
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
          <li><a href="../produit/index.php">Products</a></li>
          <li><a href="../categorie/index.php">Categorie</a></li>
          <li><a href="../order/index.php">Orders</a></li>
          <li><a class="active"  href="index.php">Users</a></li>
          <li><a href="../admin/index.php">Admin</a></li>
          <li><a href="profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper user-dashboard">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>Image</th>

                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $rows = ModelUser::getAllUser($db);
                if($rows){
                    $i=0;
                    foreach($rows as $row){
                        $i+=1;
                        ?>
                        <tr scope="row">
                          <td><?=$i;?></td>
                          <td><?=$row->first_name;?></td>
                          <td><?=$row->last_name;?></td>
                          <td><?=$row->email;?></td>
                          <td><img src="../../uploads/users/<?=$row->image?>" style="width:60px;height:60px;"></td>
                          <td>
                            <div class="btn-group" role="group">
                              <a href="profile-details.php?code=<?=$row->id?>" class="btn btn-default">View</a>
                              <button onclick="window.location.href = 'edit.php?codeedit=<?=$row->id?>';" type="button" class="btn btn-default"><i class="tf-pencil2" aria-hidden="true"></i></button>
                              <button onclick="window.location.href = 'index.php?deletedcode=<?=$row->id?>';" type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button>
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