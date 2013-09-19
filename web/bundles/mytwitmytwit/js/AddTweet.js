myTwit.controller('TweetController', function($scope, $http)
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
            $scope.remaining_chars = 'Maksymalna długość to 255 znaków. Tweet nie zostanie dodany.'
        }
        else
        {
            $scope.color = 'black';
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
        if(content.length == 0)
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
                url: '/app_dev.php/logged/addtwit',
                data: {content: content},
                headers: {'Content-Type': 'application/json'},
            })
            .success(function(response)
            {
            });
        }
    }
}
);