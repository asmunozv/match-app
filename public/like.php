<?php
require 'config.php';require_login();$me=(int)$_SESSION['user_id'];$other=(int)($_POST['id']??0);
if($other && $other!==$me){
 $st=$pdo->prepare("INSERT INTO likes(user_id,liked_user_id) VALUES(?,?) ON CONFLICT DO NOTHING");$st->execute([$me,$other]);
 $st=$pdo->prepare("SELECT 1 FROM likes WHERE user_id=? AND liked_user_id=?");$st->execute([$other,$me]);
 if($st->fetchColumn()){
  $a=min($me,$other);$b=max($me,$other);
  $st=$pdo->prepare("INSERT INTO matches(user1_id,user2_id) VALUES(?,?) ON CONFLICT DO NOTHING");$st->execute([$a,$b]);
 }
}
header('Location: discover.php');exit;
