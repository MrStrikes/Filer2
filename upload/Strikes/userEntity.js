angular.module('apptest').factory('userEntity', ['localStorageService', function (localStorageService) {

    this.login = function (username) {
        localStorageService.set('user', username);
    };

    this.logout = function () {
        console.log('LOGOU');
        localStorageService.remove('user');
    };

    this.isSignedIn = function () {
        return null !== localStorageService.get('user');
    };

    return this;
}]);