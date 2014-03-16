<h1>Menu Config</h1>
<p>Here you should be able to view and edit the site's config.</p>

<?php if($is_authenticated): ?>
<?=$menu_form?>
<?php else: ?>
  
  <p>User is anonymous and not authenticated.</p>
<?php endif; ?>
