<?php
require 'config.php'; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??'')); $age=(int)($_POST['age']??0);
  $city=trim($_POST['city']??''); $pass=$_POST['password']??'';
  if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || $age<18 || $age>100 || $city==='' || strlen($pass)<8) {
    $error='Completa los datos correctamente. La contraseña debe tener al menos 8 caracteres.';
  } else {
    try {
      $st=$pdo->prepare("INSERT INTO users(name,email,password_hash,age,city) VALUES(?,?,?,?,?)");
      $st->execute([$name,$email,password_hash($pass,PASSWORD_DEFAULT),$age,$city]);
      session_regenerate_id(true); $_SESSION['user_id']=(int)$pdo->lastInsertId();
      header('Location: quiz.php'); exit;
    } catch (Throwable $e) { $error='Ese correo ya está registrado.'; }
  }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Crear cuenta</title><link rel="stylesheet" href="style.css"></head><body><main class="shell"><section class="card"><h1>Crear cuenta 💕</h1><?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?><form method="post"><label>Nombre<input name="name" required maxlength="80"></label><label>Correo<input type="email" name="email" required></label><label>Edad<input type="number" name="age" min="18" max="100" required></label><label>Ciudad<input name="city" required maxlength="100"></label><label>Contraseña<input type="password" name="password" minlength="8" required></label><button class="btn" type="submit">Crear cuenta</button></form><a href="index.php">Volver</a></section></main></body></html>
