<?php
require 'config.php'; require_login(); $me=(int)$_SESSION['user_id'];
$has=$db->query("SELECT COUNT(*) c FROM answers WHERE user_id=$me")->fetch_assoc()['c'];
if($has<30){header('Location: quiz.php');exit;}
$users=$db->query("SELECT id,name,age,city,bio,photo_url FROM users WHERE id<>$me ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$my=[];$r=$db->query("SELECT question_id,answer FROM answers WHERE user_id=$me");while($x=$r->fetch_assoc())$my[$x['question_id']]=(int)$x['answer'];
foreach($users as &$u){
 $uid=(int)$u['id'];$other=[];$r=$db->query("SELECT question_id,answer FROM answers WHERE user_id=$uid");while($x=$r->fetch_assoc())$other[$x['question_id']]=(int)$x['answer'];
 $sum=0;$n=0;foreach($my as $qid=>$a){if(isset($other[$qid])){$sum+=(5-abs($a-$other[$qid]))/4*100;$n++;}}
 $u['score']=$n?round($sum/$n):0;
 $st=$db->prepare("SELECT 1 FROM likes WHERE user_id=? AND liked_user_id=?");$st->bind_param("ii",$me,$uid);$st->execute();$u['liked']=(bool)$st->get_result()->num_rows;
}
unset($u); usort($users,fn($a,$b)=>$b['score']<=>$a['score']);
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Descubrir</title><link rel="stylesheet" href="style.css"></head><body><main class="shell wide"><nav><b>💘 Match</b><span><a href="matches.php">Mis matches</a> · <a href="logout.php">Salir</a></span></nav><h1>Personas para ti</h1><p class="small">Ordenadas por compatibilidad con tus respuestas.</p><div class="grid">
<?php foreach($users as $u):?><article class="profile"><?php if($u['photo_url']):?><img src="<?=e($u['photo_url'])?>" alt="Foto de <?=e($u['name'])?>"><?php else:?><div class="avatar">👤</div><?php endif;?><h2><?=e($u['name'])?>, <?=e($u['age'])?></h2><p>📍 <?=e($u['city'])?></p><strong>❤️ <?=e($u['score'])?>% compatible</strong><p><?=e($u['bio'])?></p>
<form method="post" action="like.php"><input type="hidden" name="id" value="<?=$u['id']?>"><button class="btn <?=$u['liked']?'ghost':''?>" type="submit"><?=$u['liked']?'💗 Te gusta':'❤️ Me interesa'?></button></form></article><?php endforeach;?>
</div></main></body></html>
