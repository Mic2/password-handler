$(document).ready(function() {

  // Making sure we can use post with Ajax and use validation token for middleware attacks
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // All forms that have this class will send information by ajax
$('.ajax-form').submit(function(e) {

  // Preventing default form behavior
  e.preventDefault();

  // Getting form information
  var url = $(this).attr('action');
  var data = $(this).serialize();

  $.ajax({
      method: "POST",
      async: false,
      url: url,
      data: data
  })
  .done(function( msg ) {
      
      if(url === "/get-password") {

        $('#clipboard-container-overlay').show();

        var copyText = document.getElementById('clipboard-container');
        
        // Storing the text inside of our clipboard container
        $(copyText).attr('value', msg);

        copyText.style.display='block';
        copyText.select();
        document.execCommand("copy");
        copyText.style.display='none';

        $(copyText).attr('value', '');

        $('#clipboard-container-overlay').hide();

      } else {
        $('.password-form-wrapper form').find('input[type=text], input[type=password]').val("");
      }
      console.log("Ajax done");
  });
  
  // Clear form after submit
  //$(this).find('input[type=text], input[type=password]').val("");

});

}); 


