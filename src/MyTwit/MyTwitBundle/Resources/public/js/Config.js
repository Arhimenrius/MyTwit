var myTwit = angular.module('myTwit', ['ngSanitize']);

myTwit.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  }]);

myTwit.service('UpdateHelper', function($http) {
    this.updateAllTweets = function()
    {
        var request = $http({method: 'POST', url: '/app_dev.php/logged/home/updatealltweets'})
        .success(function(data, status, headers, config) {
        if(data != 0)
        {
            return tweets = data;
        }
        });
        return request;
    };
    
});