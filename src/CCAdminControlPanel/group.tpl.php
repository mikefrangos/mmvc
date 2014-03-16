<h1><?=$group['name']?></h1>
 <p>List of group members</p>
 <?php if($users != null):?>
  <ul>
  <?php foreach($users as $val):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/profile/{$val['id']}")?>'>edit</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No users exists.</p>
<?php endif;?>
