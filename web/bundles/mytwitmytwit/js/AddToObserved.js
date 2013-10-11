myTwit.controller('ToObservedController', function($scope, $http)
{
    var id = '';
    $('.observedlink').click(function(){
        id = $(this).attr("id"); 
    });
    $scope.changeObserved = function()
    {
        var change = '';

        if($('a#'+id).text() == 'Obserwuj')
        {
            $('a#'+id).text('Przestań obserwować');
            change = 'add';
        }
        else
        {
            $('a#'+id).text('Obserwuj');
            change = 'delete';
        }
        console.log(id);
        $http({
                method: 'POST',
                url: '/app_dev.php/logged/observed/change',
                data: {
                id:id,
                change:change,
            },
                headers: {'Content-Type': 'application/json'},
            })
            .success(function(response, data)
            {
            });
    }
});