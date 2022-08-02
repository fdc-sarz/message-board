app = app || angular.module('app', []);

app.controller('MessageListsController', messageListsController);

function messageListsController($scope) {
  var baseUrl = angular.copy(window.app_config.base_url);
  $scope.isFetching = false;
  $scope.messages = [];
  $scope.last_mtid = ''
  $scope.hasMoreData = true;
  $scope.loggedId = angular.copy(window.app_config.loggedId);
  
  $scope.loadMoreData = function() {
    $.get(baseUrl + 'message/getUserMessages', { 'last_mtid': $scope.last_mtid }, null, 'json').then(function(response) {
      if(response.success) {
        $scope.messages = $scope.messages.concat(response.messages);
        if(response.last_mtid) {
          $scope.last_mtid = angular.copy(response.last_mtid);
        }
        $scope.hasMoreData = angular.copy(response.more_message);
      }
      $scope.$digest();
    }, function() {
      $scope.isFetching = false;
      $scope.$digest();
      alert(window.app_messages.cannot_connect_msg);
    });
  }
  
  $scope.onDeleteMessage = function(message, idx) {
    var mid = message.Message.id;
    $("#message-" + mid).fadeOut(500, function() {
      $scope.messages.splice(idx, 1);
      $scope.$digest();
    });
    $.post(baseUrl + 'message/deleteUserMessage/' + mid);
  }
  
  $scope.formatDate = function(date){
    var dateOut = new Date(date);
    return dateOut;
  }
  
  $scope.loadMoreData();
}