<?php
require 'config.php';require_login();$me=(int)$_SESSION['user_id'];
$st=$pdo->prepare("SELECT u.id,u.name,u.age,u.city,u.bio FROM matches m JOIN users u ON u.id=CASE WHEN m.user1_id=? THEN m.user2_id ELSE m.user1_id END WHERE m.user1_id=? OR m.user2_id=? ORDER BY m.created_at DESC");
$st->execute([$me,$me,$me]);$matches=$st->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Matches</title><link rel="stylesheet" href="style.css"></head><body><main class="shell"><nav><b>💘 Match</b><a href="discover.php">Descubrir</a></nav><h1>¡Tus matches! 🎉</h1><?php if(!$matches):?><p>Aún no tienes matches mutuos. Sigue descubriendo personas.</p><?php else:foreach($matches as $u):?><article class="profile"><div class="avatar">💞</div><h2><?=e($u['name'])?>, <?=e($u['age'])?></h2><p>📍 <?=e($u['city'])?></p><p><?=e($u['bio'])?></p></article><?php endforeach;endif;?></main></body></html>
