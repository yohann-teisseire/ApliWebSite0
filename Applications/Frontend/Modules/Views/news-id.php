<p> par <em><?php echo $news['auteur']; ?></em>, le <?php echo
$news['dateAjout']->format('d/m/Y à H/hi'); ?></p>
<h2><?php echo $news['titre']; ?></h2>
<p><?php echo $news['contenu']; ?></p>

<?php if($news['dateAjout'] != $news['dateModif']){ ?>
<p style="text-align:right"><small><em>Modifiée le <?php echo $news['dateModif']->format('d/m/Y à H\hi')?></em></small></p>
<?php } ?>

<p><a href="commenter-<?php echô $news['id'];?>.php">Ajouter un commentaire</a></p>

<?php if(empty($comment)){ ?>
	<p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php } 
foreach($comment as $comment){ ?>
<fieldset>
	<legend>Posté par <strong><?php echo htmlspecialchars($comment['auteur'];)?></strong> le <?php echo $comment['date']->format('d/m/Y H\i'); ?></legend>
	<p><?php echo nl2br(htmlspecialchars($comment['contenu'])); ?></p>
</fieldset>
<?php } ?>

<a href="commenter-<?php echo $news['id'];?>.php">Ajouter un commentaire</a>