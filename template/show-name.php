
<p>
Nom: <?= $params->lastname ?>
</p>
<p>
Prénom: <?= $params->firstname ?>
</p>

<?php if (!is_null($params->request->params->id)): ?>
<p>
Id: <?= $params->request->params->id ?>
</p>
<?php endif; ?>

