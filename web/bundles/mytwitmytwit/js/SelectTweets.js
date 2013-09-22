myTwit.controller('allTweetsController', function($scope, $http, UpdateHelper)
{
    tweets = {};
    $scope.getTweets = function()
    {
        $http({method: 'POST', url: '/app_dev.php/logged/home/getalltweets'})
        .success(function(data, status, headers, config) {
            $scope.tweets = data;
        });
    };
    
    setInterval(function(){updateTweets()},60000);

    updateTweets = function()
    {
        $http({method: 'POST', url: '/app_dev.php/logged/home/updatealltweets'})
        .success(function(data, status, headers, config) {
        if(data != 0)
        {
            UpdateHelper.mergeRecursive($scope.tweets, data);
        }
        });
    }
});