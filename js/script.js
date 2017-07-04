'use strict';

$(function(){
  $('#add-note').on('click', function(event) {
    event.preventDefault();
    let subject  = $('#subject').val();
    let message = $('#message').val();
    if(!subject && !message) {
      $('.error').html("You must fill in at least one field.");
    } else {
      $.ajax ({
          url: 'inc/save_handler.php',
          type: 'POST',
          data: { subject: subject, message: message },
          dataType: 'json',
          success: function(new_note){
            let currentCount = parseInt($('.notecount').text().replace(/\D/g, ''), 10);
            let newCount = currentCount + 1;
            let d = new Date(new_note['published_date']);
            let nm = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            let suffixes = ['','st','nd','rd','th','th','th','th','th','th','th','th','th'];
            let day = d.getDate();
            let month = d.getMonth();
            let year = d.getFullYear();
            let hours = d.getHours();
            let minutes = d.getMinutes();
            let ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0'+minutes : minutes;
            let time = hours + ':' + minutes + ampm;
            let monthname = nm[month];
            let daysuffixe = day + suffixes[day];
            $('.notecount').text(newCount);
               $('<div class="column">'
              + '<div class="sticky">'
                + '<button class="remove">-</button>'
                + '<h2>'+ new_note['subject'] +'</h2>'
                + '<h3>'+ monthname+' '+daysuffixe+', '+year+'<span>'+time+'</span>'+'</h3>'
                + '<p>'+ new_note['message'] +'</p>'
              + '</div>'
             + '</div>')
            .insertAfter($('.column:first-child'));
            $('form')[0].reset();
            $('.error').html("Sticky note successfully saved.").delay(3000).fadeOut();
          }
      });
    }
  });

  $('#dropdown').on('click', function() {
    $('#dropdown ul').slideToggle('show');
  });

});
