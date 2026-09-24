<?php
require 'config.php';require_login();$me=(int)$_SESSION['user_id'];$other=(int)($_POST['id']??0);
if($other && $other!==$me){
 $st=$db->prepare("INSERT IGNORE INTO likes(user_id,liked_user_id) VALUES(?,?)");$st->bind_param("ii",$me,$other);$st->execute();
 $st=$db->prepare("SELECT 1 FROM likes WHERE user_id=? AND liked_user_id=?");$st->bind_param("ii",$other,$me);$st->execute();
 if($st->get_result()->num_rows){
  $a=min($me,$other);$b=max($me,$other);
  $st=$db->prepare("INSERT IGNORE INTO matches(user1_id,user2_id) VALUES(?,?)");$st->bind_param("ii",$a,$b);$st->execute();
 }
}
header('Location: discover.php');exit;
