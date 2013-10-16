myTwit.controller('ToObservedController', function($scope, $http)
{
    var id = '';
    jQuery('.observedlink').click(function(){
        id = $(this).attr("id"); 
    });
    $scope.changeObserved = function()
    {
        var change = '';

        if(jQuery('a#'+id).text() == 'Obserwuj')
        {
            jQuery('a#'+id).text('Przestań obserwować');
            if(jQuery('a#'+id).parent().parent().attr("class") != 'short_box')
            {
                jQuery('a#'+id).parent().parent().css("opacity", "1");
            }
            change = 'add';
        }
        else
        {
            jQuery('a#'+id).text('Obserwuj');
            if(jQuery('a#'+id).parent().parent().attr("class") != 'short_box')
            {
                jQuery('a#'+id).parent().parent().css("opacity", "0.5");
            }
            change = 'delete';
        }
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