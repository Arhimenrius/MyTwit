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
            if($('a#'+id).parent().parent().attr("class") != 'short_box')
            {
                $('a#'+id).parent().parent().css("opacity", "1");
            }
            change = 'add';
        }
        else
        {
            $('a#'+id).text('Obserwuj');
            if($('a#'+id).parent().parent().attr("class") != 'short_box')
            {
                $('a#'+id).parent().parent().css("opacity", "0.5");
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