myTwit.controller('allTweetsController', function($scope, $element, $http, UpdateHelper, AllHelper, $compile)
{   
    $scope.getTweets = function()
    {
        UpdateHelper.updateAllTweets().then(function(response){
            $scope.tweets = response.data;
        });
    };
    
    setInterval(function(){$scope.updateTweets();},60000);

    $scope.updateTweets = function()
    {
        UpdateHelper.updateAllTweets().then(function(response){           
            for (tweet in response.data) {                
                $scope.tweets.push(response.data[tweet]);
            }
        });
        
    };
});