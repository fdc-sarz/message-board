<?php
$this->Html->script('controllers/edit-profile', ['inline' => false, 'block' => 'script']);
$this->assign('title', 'Account > Edit Profile');
?>
<script type="text/javascript">
  window.uploadPhoto = {
    originalPhoto: '<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture', $this->Session->read('userDetail.id')]); ?>'
  }
</script>
<div ng-controller="EditProfileController" class="edit-profile-page">
  <h2>Edit Profile</h2>
    <?php
      echo $this->element('FormError');
      echo $this->Form->create('UserDetail', ['type' => 'file', 'class' => 'row', 'autocomplete' => 'off']);
    ?>
    <div class="col-12 mb-2">
      <img ng-if="(photo || originalPhoto) && !generating" ng-src="{{ photo || originalPhoto }}" class="rounded" alt="200x200" style="width:200px;height:200px;" />
      <span ng-if="generating"><?php echo __('label.generating'); ?></span>
    </div>
    <div class="col-12">
      <?php
        echo $this->Form->file('profile_picture', ['id' => 'profile_picture', 'accept' => '.png, .jpg, .gif', 'class' => 'd-none']);
        echo $this->Form->button(__('label.select_picture'), ['class' => 'btn btn-info mx-2', 'ng-click' => 'onSelectPicture($event)']);
      ?>
    </div>
    <div class="col-12">
      <?php echo $this->Form->input('User.name', ['label' => __('label.name'), 'class' => 'form-control', 'required' => false, 'error' => false]); ?>
      <?php echo $this->Form->input('birth_date', ['type' => 'text', 'label' => __('label.birthdate'), 'class' => 'form-control d-none', 'required' => false, 'error' => false]); ?>
      <input id="birthdate-temp" type="text" value="<?php echo $birth_date; ?>" class="form-control" />
      <?php echo $this->Form->input('gender', ['type' => 'radio', 'options' => ['Male' => 'Male', 'Female' => 'Female'], 'class' => 'form-check-input', 'required' => false, 'error' => false]); ?>
      <label><?php echo __('label.hubby'); ?></label>
      <?php echo $this->Form->textarea('hubby', ['class' => 'form-control', 'required' => false, 'error' => false]); ?>
    </div>
    <?php echo $this->Form->end(['label' => 'Edit Profile', 'class' => 'btn btn-success mt-3']); ?>
</div>