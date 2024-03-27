<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require('..\model\App.php');

$db = App::getDB();
require 'util.php';
require '..\model\ModelUser.php';



// for admin 
if (!empty($_POST) && !empty($_POST['email'] && !empty($_POST['password']) && empty($_POST['register']))) {

  $user = null;
  $res = ModelUser::getbyEmail($db, $_POST['email']);

  if (($res != null) && ($res->email == $_POST['email']) && (password_verify($_POST['password'], $res->password)) && ($res->admin == 1)) {
    $user = $res->id;
    $_SESSION['admin']= 1;
  }
  elseif (($res != null) && ($res->email == $_POST['email']) && (password_verify($_POST['password'], $res->password)) && ($res->admin == 0)) {
    $user = $res->id;
    $_SESSION['admin']= 0;
  }

  if ($user == null) {
    $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
  } else {
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';

    if ($_POST['remember']) {
      setcookie('email', $user['email'], time() + 60 * 60 * 24 * 7);
      setcookie('password', $user['password'], time() + 60 * 60 * 24 * 7);
    } elseif (!$_POST['remember']) {
      if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        setcookie('email', null, -1);
        setcookie('password', null, -1);
      }
    }
    if ($res->admin == 1){
      header('Location: produit/index.php');
    }
    else{
      header('Location: products.php');
    }
    exit();
  }
}
?>


<?php

// register new simple user (not admin)

// upload image
if (!empty($_POST['first_name']) && !isset($_POST['id'])) {

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $telephone = $_POST['telephone'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $admin = 0;

  list($image, $tmpName) = uploadImages('image');

  $u = new ModelUser($last_name, $image, $first_name, $email, $password, $telephone, $admin);
  $u->save($db);

  $target_dir = '../uploads/users/';
  move_uploaded_file($tmpName, $target_dir . $image);
}
?>

<?php require '..\inc\header.php'; ?>

<body id="body">

  <section class="signin-page account">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <a class="logo" href="login.php">
              <img src="../images/logo2.png" height="80px">
            </a>
            <h2 class="text-center">Welcome Back</h2>

            <?php if (isset($_SESSION['flash'])) : ?>
              <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="alert alert-<?= $type; ?>">
                  <?= $message; ?>
                </div>
              <?php endforeach; ?>
              <?php unset($_SESSION['flash']) ?>
            <?php endif; ?>

            <form class="text-left clearfix" action="login.php" method="POST">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
              <br>
              <div class="text-center" style="display: flex; justify-content: space-around; ">
                <button type="submit" class="btn btn-main text-center">Login</button>
                <button onclick="window.location.href = 'register.php';" type="button" class="btn btn-main text-center"> Register now ! </button>
              </div>
            </form>
            <br><br>

          </div>
        </div>
      </div>
    </div>
  </section>
  <?php require '..\inc\footer.php'; ?>