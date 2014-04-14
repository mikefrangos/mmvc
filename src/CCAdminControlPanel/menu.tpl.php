<?php if($is_admin): ?>
<?php if($menus):?>
<h1>Menu list</h1>
<ul>
<?php foreach($menus as $menu):?>
<li><?=$menu['label']?> <a href='<?=create_url("acp/menu/edit/" . array_search($menu, $menus))?>'>edit</a></li>
<?php endforeach;?>
</ul>
<a href='<?=create_url("acp/menu/create")?>'>Create Menu</a>
<?php endif;?>
<?=$form?>
<?php else: ?>
  
  <p>You do not have permission to view this page.</p>
<?php endif; ?>
