myTwit.controller('allTweetsController', function($scope, $http)
{
    tweets = {};
    $scope.getTweets = function()
    {
        $http({method: 'POST', url: '/app_dev.php/logged/home/getalltweets'})
        .success(function(data, status, headers, config) {
            $scope.tweets = data;
        });
    };
    
    setInterval(function(){updateTweets()},1000);

    function updateTweets()
    {
        $http({method: 'POST', url: '/app_dev.php/logged/home/updatealltweets'})
        .success(function(data, status, headers, config) {
        console.log(data);
        });
    }
});