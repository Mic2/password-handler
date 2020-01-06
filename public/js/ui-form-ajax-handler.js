$(document).ready(function() {

  // Making sure we can use post with Ajax and use validation token for middleware attacks
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
}); 


// All forms that have this class will send information by ajax
$('.ajax-form').submit(function(e) {

  e.preventDefault();

  var url = $(this).attr('action');
  var data = $(this).serialize();

  $.ajax({
    method: "POST",
    url: url,
    data: data
  })
  .done(function( msg ) {
    alert( "Data Saved: " + msg );
  });

  $(this).find('input[type=text], input[type=password]').val("");

});