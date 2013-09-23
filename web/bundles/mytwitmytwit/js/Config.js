var myTwit = angular.module('myTwit', []);

myTwit.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  }]);
  
myTwit.service('AllHelper', function($http) {
    this.realMerge = function (to, from) {

    for (n in from) {
        if (typeof to[n] != 'object') {
            to[n] = from[n];
        } else if (typeof from[n] == 'object') {
            to[n] = this.realMerge(to[n], from[n]);
        }
    }

    return to;
    };
});

myTwit.service('UpdateHelper', function($http, AllHelper) {
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