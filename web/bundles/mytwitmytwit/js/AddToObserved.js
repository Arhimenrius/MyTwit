myTwit.controller('ToObservedController', function($scope, $http)
{
    $scope.changeObserved = function()
    {
        var change = '';
        if($('.observedlink').text() == 'Obserwuj')
        {
            $('.observedlink').text('Przestań obserwować');
            change = 'add';
        }
        else
        {
            $('.observedlink').text('Obserwuj');
            change = 'delete';
        }
        
        $http({
                method: 'POST',
                url: '/app_dev.php/logged/observed/change',
                data: {
                id:$('.observedlink').attr("id"),
                change:change,
            },
                headers: {'Content-Type': 'application/json'},
            })
            .success(function(response, data)
            {
                console.log(response);
            });
    }
});