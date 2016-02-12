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

					// The FormData API provides very easy file uploads.
					// (Required e.g. by the File and Video plugins.)
					var formData = new FormData($(this)[0]);

					// For some reason FormData does not pick the content added
					// through a wysiwyg editor, so we need to add it manually
					var desc = $(this).find('textarea[name=description]').val();
					formData.append('description', desc);

					// Firefox doesn't include submit button to the data, so
					// this makes sure it is always included. The button is
					// used by the blog plugin to tell apart automatic saving
					// of draft and the actual submit.
					var submit = $(this).find('input[type=submit]');
					if (submit.attr('name') !== undefined) {
						formData.append(submit.attr('name'), submit.attr('value'));
					}

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
