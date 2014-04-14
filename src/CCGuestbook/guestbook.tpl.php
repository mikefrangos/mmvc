<h1>My Guestbook</h1>
<p>Leave a message and be happy.</p>

<?=$form->GetHTML()?>

<h2>Latest messages</h2>

<?php if(!empty($entries)):?>
<?php foreach($entries as $val):?>
<?php 
if (isset($val['depth'])) {
	if ($val['depth'] > 5) {
		$margin = 25;
	} else {
	  $margin = $val['depth'] * 5;
	}
} else { $margin = 0; }
?>
<div style="background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;margin-left:<?=$margin?>em;">
  <p>At: <?=$val['created']?> </p>
  <p><?=htmlent($val['entry'])?></p>
  <a href='<?=create_url("guestbook/index/{$val['id']}")?>'>reply</a>
</div>
<?php endforeach;?>

<?php else:?>
<?php foreach($unsorted as $val):?>
<div style="background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;margin-left:0em;">
  <p>At: <?=$val['created']?> </p>
  <p><?=htmlent($val['entry'])?></p>
  <a href='<?=create_url("guestbook/index/{$val['id']}")?>'>reply</a>
</div>
<?php endforeach;?>
<?php endif;?>
