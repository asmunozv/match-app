<?php
require 'config.php'; require_login();
$user=(int)$_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']==='POST'){
 $questions=$db->query("SELECT id FROM questions ORDER BY id")->fetch_all(MYSQLI_ASSOC);
 if(count($_POST['a']??[])===count($questions)){
  $st=$db->prepare("INSERT INTO answers(user_id,question_id,answer) VALUES(?,?,?) ON DUPLICATE KEY UPDATE answer=VALUES(answer)");
  foreach($questions as $q){$id=(int)$q['id'];$ans=max(1,min(5,(int)($_POST['a'][$id]??0)));$st->bind_param("iii",$user,$id,$ans);$st->execute();}
  header('Location: discover.php');exit;
 }
}
$qs=$db->query("SELECT * FROM questions ORDER BY id")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Tu perfil de compatibilidad</title><link rel="stylesheet" href="style.css"></head><body><main class="shell wide"><section class="card"><h1>Conócete mejor 💗</h1><p>30 preguntas. No hay respuestas correctas: el objetivo es encontrar personas con respuestas compatibles.</p><form method="post">
<?php foreach($qs as $i=>$q):?><fieldset><legend><?=($i+1)?>. <?=e($q['question'])?></legend><div class="scale"><?php foreach([1=>'Nada',2=>'Poco',3=>'Neutral',4=>'Bastante',5=>'Mucho'] as $v=>$txt):?><label class="choice"><input type="radio" name="a[<?=$q['id']?>]" value="<?=$v?>" required><span><?=$txt?></span></label><?php endforeach;?></div></fieldset><?php endforeach;?>
<button class="btn" type="submit">Guardar mis respuestas ✨</button></form></section></main></body></html>
