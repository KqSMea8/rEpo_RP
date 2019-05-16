// $Id$
(function ($) {

    Drupal.behaviors.ajaxboxes = {
        attach: function (context, settings) {
      
      $('#edit-num-users', context).change(function(){
                var num_user;
                var user_plan;
                var choose_plan;
                var space_size;
                var space_unit;
                num_user = $('#edit-num-users').val();
                user_plan = $('#edit-plan-duration').val();
                choose_plan = $('input[name=plan]').val();
                space_size = $('#edit-space-size').val();
                space_unit = $('#edit-space-unit').val();
                //console.log(num_user,user_plan);
                var GetCost = function(data) {
                    $('input[name=price]').val(data.totalprice);
                    $('input[name=actprice]').val(data.actualprice);
                    $('input[name=paymenttoken]').val(data.paymenttoken);
                    $('#pricetext').html(data.pricetext);
                }
               $.ajax({
                    type: 'POST',
                    url: '/getprice/' + num_user + '/' + user_plan + '/' + choose_plan + '/' + space_size + '/' + space_unit, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
                    success: GetCost, // The js function that will be called upon success request
                    dataType: 'json', //define the type of data that is going to get back from the server
                    data: 'js=1' //Pass a key/value pair
                });
               return false;
            });
            $('#edit-plan-duration', context).change(function(){
                var num_user;
                var user_plan;
                var choose_plan;
                var space_size;
                var space_unit;
                num_user = $('#edit-num-users').val();
                user_plan = $('#edit-plan-duration').val();
                choose_plan = $('input[name=plan]').val();
                space_size = $('#edit-space-size').val();
                space_unit = $('#edit-space-unit').val();
                //console.log(num_user,user_plan);
                var GetCost = function(data) {
                    $('input[name=price]').val(data.totalprice);
                    $('input[name=actprice]').val(data.actualprice);
                    $('input[name=paymenttoken]').val(data.paymenttoken);
                    $('#pricetext').html(data.pricetext);
                    
                }
               $.ajax({
                    type: 'POST',
                    url: '/getprice/' + num_user + '/' + user_plan + '/' + choose_plan + '/' + space_size + '/' + space_unit, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
                    success: GetCost, // The js function that will be called upon success request
                    dataType: 'json', //define the type of data that is going to get back from the server
                    data: 'js=1' //Pass a key/value pair
                });
               return false;
            });
            
            
            
            
            
            
            
            
            
            
            $('#edit-space-size', context).change(function(){
                var num_user;
                var user_plan;
                var choose_plan;
                var space_size;
                var space_unit;
                num_user = $('#edit-num-users').val();
                user_plan = $('#edit-plan-duration').val();
                choose_plan = $('input[name=plan]').val();
                space_size = $('#edit-space-size').val();
                space_unit = $('#edit-space-unit').val();
               console.log(space_size,space_unit);
                var GetCost = function(data) {
                    $('input[name=price]').val(data.totalprice);
                    $('input[name=actprice]').val(data.actualprice);
                    $('input[name=paymenttoken]').val(data.paymenttoken);
                    $('#pricetext').html(data.pricetext);
                    
                }
               $.ajax({
                    type: 'POST',
                    url: '/getprice/' + num_user + '/' + user_plan + '/' + choose_plan + '/' + space_size + '/' + space_unit, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
                    success: GetCost, // The js function that will be called upon success request
                    dataType: 'json', //define the type of data that is going to get back from the server
                    data: 'js=1' //Pass a key/value pair
                });
               return false;
            });
            $('#edit-space-unit', context).change(function(){
                var num_user;
                var user_plan;
                var choose_plan;
                var space_size;
                var space_unit;
                num_user = $('#edit-num-users').val();
                user_plan = $('#edit-plan-duration').val();
                choose_plan = $('input[name=plan]').val();
                space_size = $('#edit-space-size').val();
                space_unit = $('#edit-space-unit').val();
               console.log(space_size,space_unit);
                var GetCost = function(data) {
                    $('input[name=price]').val(data.totalprice);
                    $('input[name=actprice]').val(data.actualprice);
                    $('input[name=paymenttoken]').val(data.paymenttoken);
                    $('#pricetext').html(data.pricetext);
                    
                }
               $.ajax({
                    type: 'POST',
                    url: '/getprice/' + num_user + '/' + user_plan + '/' + choose_plan + '/' + space_size + '/' + space_unit, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
                    success: GetCost, // The js function that will be called upon success request
                    dataType: 'json', //define the type of data that is going to get back from the server
                    data: 'js=1' //Pass a key/value pair
                });
               return false;
            });
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

     
     
        }
    };

}(jQuery));