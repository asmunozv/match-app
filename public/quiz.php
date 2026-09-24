<?php
require 'config.php'; require_login(); $user=(int)$_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']==='POST'){
 $questions=$pdo->query("SELECT id FROM questions ORDER BY id")->fetchAll();
 if(count($_POST['a']??[])===count($questions)){
  $st=$pdo->prepare("INSERT INTO answers(user_id,question_id,answer) VALUES(?,?,?) ON CONFLICT(user_id,question_id) DO UPDATE SET answer=EXCLUDED.answer");
  foreach($questions as $q){$id=(int)$q['id'];$ans=max(1,min(5,(int)($_POST['a'][$id]??0)));$st->execute([$user,$id,$ans]);}
  header('Location: discover.php');exit;
 }
}
$qs=$pdo->query("SELECT * FROM questions ORDER BY id")->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Preguntas</title><link rel="stylesheet" href="style.css"></head><body><main class="shell wide"><section class="card"><h1>Conócete mejor 💗</h1><p>30 preguntas. No hay respuestas correctas: buscamos compatibilidad de preferencias.</p><form method="post">
<?php foreach($qs as $i=>$q):?><fieldset><legend><?=($i+1)?>. <?=e($q['question'])?></legend><div class="scale"><?php foreach([1=>'Nada',2=>'Poco',3=>'Neutral',4=>'Bastante',5=>'Mucho'] as $v=>$txt):?><label class="choice"><input type="radio" name="a[<?=$q['id']?>]" value="<?=$v?>" required><span><?=$txt?></span></label><?php endforeach;?></div></fieldset><?php endforeach;?>
<button class="btn" type="submit">Guardar mis respuestas ✨</button></form></section></main></body></html>
