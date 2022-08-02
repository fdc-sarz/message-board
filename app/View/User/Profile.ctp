<?php
$this->assign('title', __('meta.title.profile'));
?>
<div class="profile-page">
  <?php echo $this->Html->tag('h2', __('label.profile')); ?>
  <div class="row">
    <div class="col-md-4">
      <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture', $user['User']['id']]) ?>" style="width:200px;height:200px;" class="rounded" />
    </div>
    <div class="col-md-8 row">
      <h2 class="col-12"><?php echo $user['User']['name']; ?></h2>
      <div class="col-12">Gender: <?php echo $user['UserDetail']['gender']; ?></div>
      <div class="col-12">Birthdate: <?php echo !is_null($user['UserDetail']['birth_date']) ? date('F d, Y', strtotime($user['UserDetail']['birth_date'])) : 'N/A'; ?></div>
      <div class="col-12">Joined: <?php echo date('F d, Y ga', strtotime($user['User']['created'])); ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <span>Hubby:</span>
    </div>
    <div class="col-12">
      <?php echo nl2br($user['UserDetail']['hubby']); ?>
    </div>
  </div>
  
</div>