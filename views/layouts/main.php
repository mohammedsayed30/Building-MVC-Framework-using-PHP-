<?php 
use \app\core\Application;
use \app\models\userLogin;

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> MVC </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" style=" margin-bottom: 20px;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto ">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact">Contact</a>
        </li> 
      </ul> 
      <ul class="navbar-nav ml-auto ">
        <!-- show the logout not login if the user is already loged in -->
     <?php if(! Application::$app->session->getSession('login')):?>      
        <li class="nav-item">
          <a class="nav-link " href="/login" >Login </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/register">Resigter</a>
        </li>
     <?php else: ?>
       <li class="nav-item">
          <a class="nav-link " href="/logout" >Logout </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/profile" >Profile</a>
        </li>
     <?php endif; ?>        

      </ul>
    </div>
  </div>
</nav >

  <div class="container">
     <?php if (Application::$app->session->getFlash('success')): ?>
      <div class="alert alert-success">
        <?php echo Application::$app->session->getFlash('success') ?>
      </div>
    <?php endif; ?> 
        {{content}}
   </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>