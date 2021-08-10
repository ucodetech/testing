update_admin_login();

        function update_admin_login()
        {
            var action = 'update_admin';
            $.ajax({
               url:"script/initate.php",
               method:"POST",
               data:{action:action},
               success:function(response)
               {
                 console.log(response);

               },
               error:function(){alert("something went wrong admin update")}

            });
        }
   setInterval(function(){
     update_admin_login();
  }, 1000);


// FEcth active users
fetch_user_login();

setInterval(function(){
    fetch_user_login();
}, 1000);

function fetch_user_login()
{
    var action = 'fetch_data';
    $.ajax({
        url:"script/initate.php",
        method:"POST",
        data:{action:action},
        success:function(data)
        {
            console.log(data);
            $('#showCurrentLoggedInM').html(data);

        },
        error:function(){alert("something went wrong fetch user login")}

    });
}
