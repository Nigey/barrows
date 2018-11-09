/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

	  var file_frame;

	  $(document).on('click', '#yop_property_room_meta button.gallery-add', function(e) {

	    e.preventDefault();

	    if (file_frame) file_frame.close();

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: $(this).data('uploader-title'),
	      button: {
	        text: $(this).data('uploader-button-text'),
	      },
	      multiple: true
	    });

	    file_frame.on('select', function() {
	      var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last')),
	          selection = file_frame.state().get('selection');

	      selection.map(function(attachment, i) {
	        attachment = attachment.toJSON(),
	        index      = listIndex + (i + 1);

	        $('#gallery-metabox-list').append('<li><input type="hidden" name="meta-project-gallery-id[' + index + '][id]" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.thumbnail.url + '"><input type="text" name="meta-project-gallery-id[' + index + '][title]" value="' + attachment.title + '" /> <textarea name="meta-project-gallery-id[' + index + '][description]" style="width:100%;">' + attachment.description + '</textarea><button class="change-image button button-small" type="button" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</button><br><small><button class="remove-image button button-small" type="button">Remove image</button></small></li>');
	        // console.log(attachment);
	      });
	    });

	    makeSortable();
	    
	    file_frame.open();

	  });

	  $(document).on('click', '#yop_property_room_meta button.change-image', function(e) {

	    e.preventDefault();

	    console.log('change clicked');

	    var that = $(this);

	    if (file_frame) file_frame.close();

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: $(this).data('uploader-title'),
	      button: {
	        text: $(this).data('uploader-button-text'),
	      },
	      multiple: false
	    });

	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();

	      that.parent().find('input:hidden').attr('value', attachment.id);
	      that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
	    });

	    file_frame.open();

	  });

	  function resetIndex() {
	    $('#gallery-metabox-list li').each(function(i) {
	      $(this).find('input:hidden').attr('name', 'meta-project-gallery-id[' + i + '][id]');
	      $(this).find('input:text').attr('name', 'meta-project-gallery-id[' + i + '][caption]');
	    });
	  }

	  function makeSortable() {
	    $('#gallery-metabox-list').sortable({
	      opacity: 0.6,
	      stop: function() {
	        resetIndex();
	      }
	    });
	  }

	  $(document).on('click', '#yop_property_room_meta button.remove-image', function(e) {
	    e.preventDefault();

	    $(this).parents('li').animate({ opacity: 0 }, 200, function() {
	      $(this).remove();
	      resetIndex();
	    });
	  });

	  makeSortable();

	jQuery('#my_upl_button').click(function() {

        window.send_to_editor = function(html) {
            imgurl = jQuery(html).attr('src')
            jQuery('#property-mainphoto').val(imgurl);
            jQuery('#picsrc').attr("src",imgurl);
            tb_remove();
        }

        formfield = jQuery('#property-mainphoto').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

});