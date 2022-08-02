<?php
$this->Html->script('controllers/message-lists', ['inline' => false, 'block' => 'script']);
$this->assign('title', 'Message > Message Lists');
?>
<div ng-controller="MessageListsController" class="message-lists-page">
  <div class="container">
    <h2>Message Lists</h2>
  </div>
  <div class="container mb-3 text-end">
    <?php echo $this->Html->link('New Message', ['controller' => 'message', 'action' => 'addMessage'], ['class' => 'btn btn-secondary']); ?>
  </div>
  <div class="container">
    <input type="text" ng-model="search" />
  </div>
  <div class="container">
    <div class="message-lists-container">
      <div id="message-{{ message.Message.id }}" ng-repeat="message in messages" class="card flex-row flex-wrap mb-2">
        <div ng-if="loggedId == message.User.id" class="card-header border-0">
          <a href="<?php echo Router::url(['controller' => 'user', 'action' => 'profile']); ?>/{{ message.User.id }}">
            <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture']); ?>/{{ message.User.id }}" class="rounded" style="width:200px; height: 200px;" />
          </a>
        </div>
        <div class="card-block px-2">
          <p class="card-text">{{ message.MessageThread.message | limitTo: 250 }}{{message.MessageThread.message.length > 250 ? '...' : '' }}</p>
          <a href="<?php echo Router::url(['controller' => 'message', 'action' => 'show']); ?>/{{ message.Message.id }}" class="btn btn-primary btn-sm">View Message</a>
          <a ng-click="onDeleteMessage(message, $index)" class="btn btn-danger btn-sm">Delete Message</a>
        </div>
        <div ng-if="loggedId != message.User.id" class="card-header border-0">
          <a href="<?php echo Router::url(['controller' => 'user', 'action' => 'profile']); ?>/{{ message.User.id }}">
            <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture']); ?>/{{ message.User.id }}" class="rounded" style="width:200px; height: 200px;" />
          </a>
        </div>
        <div class="w-100"></div>
        <div class="card-footer w-100 text-muted text-end">
          {{ formatDate(message.MessageThread.created) | date: 'yyyy/MM/dd hh:mma' }}
        </div>
      </div>
      <div ng-if="isFetching" class="message-lists-fetching">Fetching message data...</div>
      <div ng-if="!isFetching && hasMoreData" class="message-lists-showmore"><a ng-click="loadMoreData()">Show More</a></div>
    </div>
  </div>
</div>
