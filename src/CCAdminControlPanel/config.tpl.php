<h1>Site Config</h1>
<p>Here you should be able to view and edit the site's config.</p>

<?php if($is_admin): ?>
<?=$config_form?>

<?php else: ?>
  
  <p>You do not have permission to view this page.</p>
<?php endif; ?>
