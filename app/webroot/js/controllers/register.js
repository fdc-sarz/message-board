app = app || angular.module('app', []);

app.controller('RegisterController', registerController);

function registerController($scope) {
  var baseUrl = angular.copy(window.app_config.base_url);
  var unableToConnectMsg = angular.copy(window.app_messages.cannot_connect_msg);
  
  $scope.errors = [];
  
  $scope.validateSubmit = function(e) {
    e.preventDefault();
    clearErrors();
    var data = $("#UserRegisterForm").serializeArray();
    var url = $("#UserRegisterForm").attr('action') + '/json';
    $.post(url, data, null, 'json').then(function(response) {
      if(response.success) {
        window.location.href = response.redirect;
      } else {
        $(".form-errors").show();
        $scope.errors = angular.copy(response.errors);
      }
      $scope.$digest();
    }, function() {
      alert(unableToConnectMsg);
    });
  }
  
  function clearErrors() {
    $scope.errors = [];
    $(".form-errors li").remove();
    $(".form-errors").hide();
  }
}