$(function() {
  var files = null;
  
  $('#add-file').click(function() {
    $('[type="file"]').trigger('click');
  });
    
  $('[type="file"]').change(function(e) {
    e.stopPropagation();
    e.preventDefault();
    
    if (typeof acceptedExt !== 'undefined') {
      filename = $(this).val();
      if (filename.indexOf(acceptedExt, filename.length - acceptedExt.length) == -1) {
        alert('Only accept ' + acceptedExt + ' file');
        return false;
      }
    }
    
    file = e.target.files[0];
    
    if (typeof maxFileSize !== 'undefined' && file.size > maxFileSize) {
        alert('Maximum allowed file size 2MB');
        return false;
    }
    
    var i = 0;
    
    $('#add-info-name').text(file.name);
    $('#add-info-size').text((Math.round(file.size / 1024 * 10) / 10)+' kB');
    
    $('#add-file').hide();
    $('#add-info').show();
    $('#formFile').find('[type="submit"]').show();
    $('#formFile').find('[type="button"]').show();
  });
  
  $('#formFile').submit(function(e) {
    e.stopPropagation();
    e.preventDefault();
    
    var form = this;
    
    if ($(form).find('input[name="key"]').val() == '') {
      alert('Please provide your secret key');
      return false;
    }
    
    $(form).find('input[name="key"]').hide();
    $(form).find('.progress').show();
    $(form).find('[type="submit"]').prop('disabled', true);
    
    var data = new FormData();
  
    data.append('file', file);
    data.append('key', $(form).find('input[name="key"]').val());
    
    $.ajax({
      url: form.action,
      type: 'POST',
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function(response) {
      
        result = JSON.parse(response);
        
        if (result.message) {
          $(form).find('[type="submit"]').prop('disabled', false);
          alert(result.message);
          window.location.reload();
        }
        else {
          $(form).find('.add-holder').addClass('span2');
          $(form).find('.arrow').show();
          $(form).find('.progress').hide();
          $(form).find('[type="submit"]').prop('disabled', false).hide();
        
          $('#result-info').show();
          $('#result-info-name').text(result.name);
          $('#result-info-size').text((Math.round(result.size / 1024 * 10) / 10)+' kB');
          $('#download-file').attr('href', result.link).show();
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });
  });
});