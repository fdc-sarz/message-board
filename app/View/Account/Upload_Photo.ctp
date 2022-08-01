<?php
$this->Html->script('controllers/upload-photo', ['inline' => false, 'block' => 'script']);
$this->assign('title', __('label.account') . ' > ' . __('label.upload_photo'));
?>
<script type="text/javascript">
  window.uploadPhoto = {
    originalPhoto: 'https://cdnb.artstation.com/p/assets/images/images/028/602/621/original/sweet-waffles-frame-logocustom.gif?1594932860'
  }
</script>
<div ng-controller="UploadPhotoController" class="upload-photo-page">
  <h2><?php echo __('label.upload_photo'); ?></h2>
  <div class="text-center">
    <?php
      echo $this->Form->create('User', ['type' => 'file', 'class' => 'row']);
    ?>
    <div class="col-12 mb-2">
      <img ng-if="(photo || originalPhoto) && !generating" ng-src="{{ photo || originalPhoto }}" class="rounded" alt="200x200" style="width:200px;height:200px;" />
      <span ng-if="generating"><?php echo __('label.generating'); ?></span>
    </div>
    <div class="col-12">
      <?php
        echo $this->Form->file('profile_picture', ['id' => 'profile_picture', 'accept' => '.png, .jpg, .gif', 'class' => 'd-none']);
        echo $this->Form->button(__('label.select_picture'), ['class' => 'btn btn-info mx-2', 'ng-click' => 'onSelectPicture($event)']);
        echo $this->Form->button(__('label.upload_picture'), ['ng-if' => 'photo && !generating', 'class' => 'btn btn-success', 'ng-click' => 'onUploadPicture($event)']);
      ?>
    </div>
  </div>
</div>