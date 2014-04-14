<?php if($is_admin): ?>
<?php if($groups):?>
<ul>
<?php foreach($groups as $group):?>
<li><?=$group['name']?> <a href='<?=create_url("acp/group/edit/{$group['id']}")?>'>edit</a></li>
<ul>
 <?php foreach($users as $val):?>
    <?php if(in_array($group['id'], array_column($val['groups'], 'id'))):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/profile/{$val['id']}")?>'>edit</a></li>
    <?php endif;?>
  <?php endforeach;?>
 </ul>
<?php endforeach;?>
</ul>
<a href='<?=create_url("acp/group/create")?>'>Create group</a>
<?php endif;?>
<?=$form?>
<?php else: ?>
  
  <p>You do not have permission to view this page.</p>
<?php endif; ?>

