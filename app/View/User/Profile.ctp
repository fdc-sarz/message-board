<?php
$this->assign('title', __('meta.title.profile'));
$userDetail = $this->Session->read('userDetail');
?>
<div class="profile-page">
  <?php echo $this->Html->tag('h2', __('label.profile')); ?>
  <div class="row">
    <div class="col-md-4">
      <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture', $userDetail['id']]) ?>" style="width:200px;height:200px;" class="rounded" />
    </div>
    <div class="col-md-8 row">
      <h2 class="col-12"><?php echo $userDetail['name']; ?></h2>
      <div class="col-12">Gender: <?php echo $userDetail['UserDetail']['gender']; ?></div>
      <div class="col-12">Birthdate: <?php echo $userDetail['UserDetail']['gender']; ?></div>
      <div class="col-12">Joined: <?php echo date('F d, Y ga', strtotime($userDetail['created'])); ?></div>
      <div class="col-12">Last Login: <?php echo date('F d, Y ga', strtotime($userDetail['last_login'])); ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <span>Hobby:</span>
    </div>
    <div class="col-12">
      <?php echo nl2br($userDetail['UserDetail']['hubby']); ?>
    </div>
  </div>
  
</div>