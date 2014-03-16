<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
  <p><?=$content->GetFilteredData()?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>edit</a> <a href='<?=create_url("content")?>'>view all</a></p>
  <p>This content is limited to <?=count($content['groups'])?> group(s).</p>
  <ul>
  <?php foreach($content['groups'] as $group): ?>
    <li><?=$group['name']?></li>
  <?php endforeach; ?>
  </ul>
  <?php if (empty($content['public'])): ?>
      <p>This content is public.</p>
  <?php endif;?>
  <?php else:?>
  <p>404: No such page exists.</p>
<?php endif;?>
