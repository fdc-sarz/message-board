<?php
if($this->Session->read('userDetail')) {
?>
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <?php echo __('label.welcome'); ?> <?php echo $this->Session->read('userDetail.name'); ?>!
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li>
        <?php echo $this->Html->link(__('label.profile'), ['controller' => 'user', 'action' => 'dashboard'], ['class' => 'dropdown-item']); ?>
      </li>
      <li>
        <?php echo $this->Html->link(__('label.message_lists'), ['controller' => 'message', 'action' => 'index'], ['class' => 'dropdown-item']); ?>
      </li>
      <li><span class="dropdown-item">Account Settings</span></li>
      <li>
        <?php echo $this->Html->link(__('label.upload_photo'), ['controller' => 'account', 'action' => 'uploadPhoto'], ['class' => 'dropdown-item']); ?>
      </li>
      <li>
        <?php echo $this->Html->link(__('label.edit_profile'), ['controller' => 'account', 'action' => 'editProfile'], ['class' => 'dropdown-item']); ?>
      </li>
      <li>
        <?php echo $this->Html->link(__('label.change_email'), ['controller' => 'account', 'action' => 'editEmail'], ['class' => 'dropdown-item']); ?>
      </li>
      <li>
        <?php echo $this->Html->link(__('label.change_password'), ['controller' => 'account', 'action' => 'changePassword'], ['class' => 'dropdown-item']); ?>
      </li>
      <li>
        <?php echo $this->Html->link(__('label.upload_photo'), ['controller' => 'account', 'action' => 'uploadPhoto'], ['class' => 'dropdown-item']); ?>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <?php echo $this->Html->link(__('label.logout'), ['controller' => 'user', 'action' => 'logout'], ['class' => 'dropdown-item']); ?>
      </li>
    </ul>
  </li>
</ul>
<?php
}
?>