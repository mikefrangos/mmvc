<?php if($is_admin): ?>
<h1>Admin Control Panel Index</h1>
 <p>One controller to manage the admin related stuff. This far it should list all users and all groups
 and enable to add, modify, delete users and add, modify, delete groups.</p>
 <?php if($users != null):?>
 <p>The following users exist:</p>
  <ul>
  <?php foreach($users as $val):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/profile/{$val['id']}")?>'>edit</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No users exists.</p>
<?php endif;?>
  <?php if($groups != null):?>
  <p>The following groups exist:</p>
  <ul>
  <?php foreach($groups as $val):?>
    <li><?=$val['id']?>, <?=$val['acronym']?>, <?=$val['name']?> <a href='<?=create_url("acp/group/view/{$val['id']}")?>'>view</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No groups exist.</p>
  
<?php endif;?>
<a href='<?=create_url("acp/profile/")?>'>Create User</a>
 <a href='<?=create_url("acp/group/create")?>'>Create group</a>
<?php else: ?>
  
  <p>You do not have permission to view this page.</p>
<?php endif; ?>
