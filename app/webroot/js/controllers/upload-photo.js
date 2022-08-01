app = app || angular.module('app', []);

app.controller('UploadPhotoController', uploadPhotoController);

function uploadPhotoController($scope) {
  
  $scope.photo = null;
  $scope.originalPhoto = angular.copy(window.uploadPhoto.originalPhoto);
  $scope.generating = false;
  
  $scope.onSelectPicture = function(e) {
    e.preventDefault();
    $("#profile_picture").trigger("click");
  }
  
  $scope.onUploadPicture = function(e) {
    if(!$scope.photo) {
      e.preventDefault();
    }
  }
  
  $(document).on("change", "#profile_picture", function(e) {
    var file = e.currentTarget.files[0];
    if(file) {
      $scope.generating = true;
      $scope.photo = null;
      $scope.$digest();
      var reader = new FileReader();
      reader.onload = function() {
        $scope.generating = false;
        $scope.photo = angular.copy(reader.result);
        console.log("$scope.photo", $scope.photo);
        $scope.$digest();
      };
      reader.readAsDataURL(file);
    }
  });
  
}