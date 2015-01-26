/**
 * Get and submit forms using ajax
 */
define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');

	$('.elgg-activity-tabs > li').click(function(e) {
		e.preventDefault();

		// Unselect the tab and hide the form in case clicked tab is active
		if ($(this).hasClass('elgg-state-selected')) {
			$(this).removeClass('elgg-state-selected');
			$('#elgg-activity-create-form .elgg-form').toggle();
			return;
		}

		$('.elgg-activity-tabs > li').removeClass('elgg-state-selected');
		$(this).addClass('elgg-state-selected');

		var type = $(this).find('a').attr('data-type');

		elgg.ajax('ajax/view/forms/activity/create?type=' + type, {
			success: function (form) {
				$('#elgg-activity-create-form').html(form);

				$('#elgg-activity-create-form .elgg-form').submit(function(e) {
					e.preventDefault();

					var formData = new FormData($(this)[0]);

					elgg.post($(this).attr('action'), {
						data: formData,
						dataType: 'json',
        				contentType: false,
        				processData: false,
						success: function (json) {
							if (json && json.system_messages) {
								elgg.register_error(json.system_messages.error);
								elgg.system_message(json.system_messages.success);
							}

							if (json.status == 0) {
								window.location = 'activity';
							}
						}
					});
				});
			}
		});
	});
});
