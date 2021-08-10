


  $('#hideBtn').click(function(e){
    e.preventDefault();
    $('#approveForm').toggle();
  })


  totUsers();

  function totUsers()
  {
      var action = 'totMembers';
      $.ajax({
          url:"script/initate.php",
          method:"POST",
          data:{action:action},
          success:function(response)
          {
              $('#totMembers').html(response);

          },
          error:function(){alert("something went wrong total members")}

      });
  }
  setInterval(function(){
      totUsers();
  }, 1000);



  totSermons();

  function totSermons()
  {
      var action = 'totsermon';
      $.ajax({
          url:"script/initate.php",
          method:"POST",
          data:{action:action},
          success:function(response)
          {
              $('#totSermon').html(response);

          },
          error:function(){alert("something went wrong admin update")}

      });
  }
  setInterval(function(){
      totSermons();
  }, 1000);


// //
// // fetch_totUsers();
// //
// // setInterval(function(){
// //    fetch_totUsers();
// // }, 5000);
// //
// // function fetch_totUsers()
// // {
// //     var action = 'totUsers';
// //     $.ajax({
// //        url:"script/initate.php",
// //        method:"POST",
// //        data:{action:action},
// //        success:function(data)
// //        {
// //          $('#totUsers').html(data);
// //
// //        }
// //     });
// // }
// //
// //Fetch total verified email
//
// fetch_totVdemail();
//
// setInterval(function(){
//    fetch_totVdemail();
// }, 5000);
//
// function fetch_totVdemail()
// {
//     var action = 'totVdemail';
//     $.ajax({
//        url:"script/initate.php",
//        method:"POST",
//        data:{action:action},
//        success:function(data)
//        {
//          $('#totVemails').html(data);
//
//        }
//
//
//     });
// }
//
//
// //Fetch total verified email
//
// fetch_totnVemail();
//
// setInterval(function(){
//    fetch_totnVemail();
// }, 5000);
// function fetch_totnVemail()
// {
//     var action = 'totVemail';
//     $.ajax({
//        url:"script/initate.php",
//        method:"POST",
//        data:{action:action},
//        success:function(data)
//        {
//          $('#totVdemails').html(data);
//
//        },
//        error:function(){alert("something went wrong tot v email 2")}
//
//     });
// }
//
// //Fetch total verified email
//
// fetch_totnAvemail();
//
// setInterval(function(){
//    fetch_totnAvemail();
// }, 5000);
//
// function fetch_totnAvemail()
// {
//     var action = 'totAemail';
//     $.ajax({
//        url:"script/initate.php",
//        method:"POST",
//        data:{action:action},
//        success:function(data)
//        {
//          $('#totAemails').html(data);
//
//        }
//
//
//     });
// }
//
// //Fetch total verified email
//
// fetch_totnAUvemail();
//
// setInterval(function(){
//    fetch_totnAUvemail();
// }, 5000);
//
// function fetch_totnAUvemail()
// {
//     var action = 'totAUemail';
//     $.ajax({
//        url:"script/initate.php",
//        method:"POST",
//        data:{action:action},
//        success:function(data)
//        {
//          $('#totAUemails').html(data);
//
//        }
//
//
//     });
// }
//
//
// //Fetch Password reset
//
// fetch_totPwdReset();
//
// setInterval(function(){
//    fetch_totPwdReset();
// }, 5000);
//
// function fetch_totPwdReset()
// {
//     var action = 'totPwdReset';
//     $.ajax({
//        url:"script/initate.php",
//        method:"POST",
//        data:{action:action},
//        success:function(data)
//        {
//          $('#totpwD').html(data);
//
//        }
//
//     });
// }
//


//Fetch total feed back

fetch_totFeed();

setInterval(function(){
   fetch_totFeed();
}, 1000);

function fetch_totFeed()
{
    var action = 'totfeed';
    $.ajax({
       url:"script/initate.php",
       method:"POST",
       data:{action:action},
       success:function(data)
       {
         $('#totFeedback').html(data);

       }

    });
}
//Fetch total notifactions

fetch_totNewReg();

setInterval(function(){
   fetch_totNewReg();
}, 5000);

function fetch_totNewReg()
{
    var action = 'totNewReg';
    $.ajax({
       url:"script/initate.php",
       method:"POST",
       data:{action:action},
       success:function(data)
       {
         $('#totNewMembers').html(data);

       }

    });
}



