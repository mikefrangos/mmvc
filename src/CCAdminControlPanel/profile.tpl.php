<?php if($is_admin): ?>
<?php if($user): ?>
<h1>User Profile</h1>
<p>Here you should be able to view and edit a user's profile information.</p>
<?php else: ?>
<h1>Create user account</h1>
<p>Create a new user by filling in below values.</p>
<?php endif; ?>
<?=$profile_form?>
<?php if($user): ?>
 <p>This user was created at <?=$user['created']?> and last updated at <?=$user['updated']?>.</p>
  <p>This user is member of <?=count($user['groups'])?> group(s).</p>
  <ul>
  <?php foreach($user['groups'] as $group): ?>
    <li><?=$group['name']?>
  <?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php else: ?>
  
  <p>You do not have permission to view this page.</p>
<?php endif; ?>
