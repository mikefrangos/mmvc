<h1>Admin Control Panel Index</h1>
 <p>One controller to manage the admin related stuff. This far it should list all users and all groups
 and enable to add, modify, delete users and add, modify, delete groups.</p>
 <?php if($users != null):?>
  <ul>
  <?php foreach($users as $val):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/profile/{$val['id']}")?>'>edit</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No users exists.</p>
<?php endif;?>
  <?php if($groups != null):?>
  <ul>
  <?php foreach($groups as $val):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/group/{$val['id']}")?>'>edit</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No groups exist.</p>
  
<?php endif;?>
