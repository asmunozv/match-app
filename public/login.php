<?php
require 'config.php'; $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $email=strtolower(trim($_POST['email']??'')); $pass=$_POST['password']??'';
 $st=$pdo->prepare("SELECT id,password_hash FROM users WHERE email=?"); $st->execute([$email]); $u=$st->fetch();
 if($u && password_verify($pass,$u['password_hash'])){session_regenerate_id(true);$_SESSION['user_id']=(int)$u['id'];header('Location: discover.php');exit;}
 $error='Correo o contraseña incorrectos.';
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Entrar</title><link rel="stylesheet" href="style.css"></head><body><main class="shell"><section class="card"><h1>Bienvenida/o 💘</h1><?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?><form method="post"><label>Correo<input type="email" name="email" required></label><label>Contraseña<input type="password" name="password" required></label><button class="btn" type="submit">Entrar</button></form><a href="register.php">Crear cuenta</a></section></main></body></html>
