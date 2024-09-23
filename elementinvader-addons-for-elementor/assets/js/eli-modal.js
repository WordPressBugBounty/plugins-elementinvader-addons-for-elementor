/*

html example:

<a href="#" "
	class="button button-primary">
	Open
</a>


<div class="eli-modal eli-fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-notice">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo esc_html__('How Add Link Calendar Into Google?', 'wpdirectorykit'); ?>
                </h5>
                <button type="button" class="close" data-eli-dismiss="modal" aria-hidden="true">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
            <div class="modal-body">
              <div class="instruction">
                  <h4><strong><?php echo esc_html__('1. Open Settings On Google Calendar', 'wpdirectorykit'); ?></strong>
                  </h4>
                  <br>
                  <img src="<?php echo esc_url( . 'public/img/google_calendar_guide.jpg'); ?>"
                      alt="Thumbnail Image">
              </div>
              <br>
              <div class="instruction">
                  <h4><strong><?php echo esc_html__('2. Copy Past Event Link', 'wpdirectorykit'); ?></strong></h4>
                  <p class="description">
                      <textarea row="5" style="width:100%"
                          class="wp-editor-area"><?php echo get_admin_url() . "admin.php?page=eli-bookings-calendar&function=export_icl_calendar&hash=" . substr(md5(wmvc_show_data('idcalendar', $db_data, '-') . 'ms1f5c06b3b3e34'), 0, 10); ?></textarea>
                  </p>
              </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="button button-secondary"
                data-eli-dismiss="modal"><?php echo esc_html__('Close', 'wpdirectorykit'); ?></button>
        </div>
    </div>
</div>


*/


const eli_log_modal = () => {
	var $ = jQuery; 

	$('*[data-eli-toggle="modal"][data-eli-target]:not(.init)').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		$('.eli-modal'+$(this).attr('data-eli-target')).show().toggleClass("active");
		$("body").addClass("eli-overlay-bgg");
	}).addClass('init');

	$("html").on("click", function (e) {
        if ($(e.target).closest('.modal-content').length) return;
		if ($(e.target).closest('.select2-container').length) return;
		if ($(e.target).closest('.daterangepicker').length) return;
		
		
		$('.eli-modal').hide().removeClass("active");
		$("body").removeClass("eli-overlay-bgg");
	});

	$('*[data-eli-dismiss="modal"]:not(.init)').on('click', function(e){
		e.preventDefault();

		if($(this).attr('data-eli-target')) {
			$('.eli-modal'+$(this).attr('data-eli-target')).hide().removeClass("active");
		} else {
			$(this).closest('.eli-modal').hide().removeClass("active");
		}

		$("body").removeClass("eli-overlay-bgg");
	}).addClass('init');

    $('.eli-modal:not(.init)').each(function () { 
        if($(this).hasClass('nodetach')) {
            $(this).addClass('init');
        } else {
            $('body').append($(this).detach().addClass('init'));
        }

    })
}

jQuery(document).on('ready', function(){
	eli_log_modal();
});