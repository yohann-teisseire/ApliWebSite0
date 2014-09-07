<h2>Il y a actuellement  <?php echo $nombreNews; ?> news ! En voici la liste :</h2>
<?php require '_form.php'; ?>
<table>
	<tr>
		<th>Auteur</th>
		<th>Titre</th>
		<th>Date d'ajout</th>
		<th>Date de modification</th>
		<th>Action</th>
	</tr>
<?php foreach ($listeNews as $news) {
	echo '<tr>';
	echo '<td>', $news['auteur']; '</td>';
	echo '<td>', $news['titre']; '</td>';
	echo '<td>', $news['dateAjout']->format('d/m/Y à h\hi'); '</td>';
	echo '<td>', $news['dateModif']->format('d/m/Y à h\hi'); '</td>';
	echo '<td><a href="news-update-'.$news['id'].'.php>Modifier</a><a href="news-delete-'.$news['id'].'.php>Supprimer</a></td></tr>';
	echo '\n';
}
?>
</table>