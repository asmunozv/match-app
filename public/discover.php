<?php
require 'config.php'; require_login(); $me=(int)$_SESSION['user_id'];
$has=(int)$pdo->query("SELECT COUNT(*) FROM answers WHERE user_id=$me")->fetchColumn();
$total=(int)$pdo->query("SELECT COUNT(*) FROM questions")->fetchColumn();
if($has<$total){header('Location: quiz.php');exit;}
$users=$pdo->query("SELECT id,name,age,city,bio,photo_url FROM users WHERE id<>$me ORDER BY created_at DESC")->fetchAll();
$st=$pdo->prepare("SELECT question_id,answer FROM answers WHERE user_id=?");$st->execute([$me]);$my=[];foreach($st as $x)$my[$x['question_id']]=(int)$x['answer'];
$otherQ=$pdo->prepare("SELECT question_id,answer FROM answers WHERE user_id=?");
$likedQ=$pdo->prepare("SELECT 1 FROM likes WHERE user_id=? AND liked_user_id=?");
foreach($users as &$u){
 $uid=(int)$u['id'];$otherQ->execute([$uid]);$other=[];foreach($otherQ as $x)$other[$x['question_id']]=(int)$x['answer'];
 $sum=0;$n=0;foreach($my as $qid=>$a){if(isset($other[$qid])){$sum+=(5-abs($a-$other[$qid]))/4*100;$n++;}}
 $u['score']=$n?round($sum/$n):0;
 $likedQ->execute([$me,$uid]);$u['liked']=(bool)$likedQ->fetchColumn();
}
unset($u);usort($users,fn($a,$b)=>$b['score']<=>$a['score']);
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Descubrir</title><link rel="stylesheet" href="style.css"></head><body><main class="shell wide"><nav><b>💘 Match</b><span><a href="matches.php">Mis matches</a> · <a href="logout.php">Salir</a></span></nav><h1>Personas para ti</h1><p class="small">Compatibilidad calculada a partir de tus respuestas.</p><div class="grid">
<?php if(!$users):?><div class="notice">Todavía no hay otras personas registradas. Comparte tu enlace cuando publiques la aplicación.</div><?php endif;?>
<?php foreach($users as $u):?><article class="profile"><?php if($u['photo_url']):?><img src="<?=e($u['photo_url'])?>" alt="Foto de <?=e($u['name'])?>"><?php else:?><div class="avatar">👤</div><?php endif;?><h2><?=e($u['name'])?>, <?=e($u['age'])?></h2><p>📍 <?=e($u['city'])?></p><strong>❤️ <?=e($u['score'])?>% compatible</strong><p><?=e($u['bio'])?></p><form method="post" action="like.php"><input type="hidden" name="id" value="<?=$u['id']?>"><button class="btn <?=$u['liked']?'ghost':''?>" type="submit"><?=$u['liked']?'💗 Te gusta':'❤️ Me interesa'?></button></form></article><?php endforeach;?>
</div></main></body></html>
