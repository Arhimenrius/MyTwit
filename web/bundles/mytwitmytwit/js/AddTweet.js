myTwit.controller('addTweetController', function($scope, $http, UpdateHelper)
{
    $scope.rows = 1;
    $scope.remaining_chars = 255;
    $scope.content = '';
    
    $scope.numberOfChars = function(content)
    {
        $scope.remaining_chars = $scope.remaining_chars = 255 - content.length;  
        if($scope.remaining_chars < 0)
        {
            $scope.color = 'red';
            $scope.size = '5';
            $scope.remaining_chars = 'Maksymalna długość to 255 znaków. Tweet nie zostanie dodany.'
        }
        else
        {
            $scope.color = 'black';
            $scope.size = '1';
        }
    }
    
    $scope.changeRows = function(rows, content)
    {
        if(rows == 'f')
        {
            $scope.rows = 5;
        }
        
        if(rows == 'b' && $scope.checkButton(content) == true)
        {
            $scope.rows = 1;
        }
    }
    
    $scope.checkButton = function(content)
    {
        if(content.length == 0 || content.length > 255)
        {
            return true;
        }   
        else
        {
            return false;
        }
    }

    $scope.addTweet = function(content)
    {
        if(content.length <= 255)
        {
            $http({
                method: 'POST',
                url: '/app_dev.php/logged/home/addtwit',
                data: {content: content},
                headers: {'Content-Type': 'application/json'},
            })
            .success(function(response)
            {
                angular.element(document.getElementsByClassName('long_box')[0]).scope().updateTweets();
            });
        }
        
        $scope.content = '';
        $scope.remaining_chars = 255;
        $scope.changeRows('');
        $scope.checkButton('');
        
        /* update user data */
    }
}
);