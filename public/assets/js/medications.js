

$(document).ready(function() {
	// when the modify-schedules button is clicked, make an ajax request to load of the schedules view
    $(document).on("click", ".js-modify-schedules", (e) => {
        let id = $(e.target).parents("tr").data("id");
		let modal = $(".modal").clone();
		modal.addClass("schedules");
		modal.insertAfter(".modal:not(.schedules)");

        $.ajax({
			type: "POST",
			url: "/schedules",
			dataType: 'json',
			data: {medicationId: id.replace("medicine-", ""), method: 'ajax'},
			beforeSend: function() {
				$('.load-content').addClass('loading');
			},
			success: function(html) {
				$('.load-content').removeClass('loading');
				$('.schedules .modal-content').html(html);
				closeModal($(".schedules"));
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.load-content').removeClass('loading');
				console.log(jqXHR, textStatus, errorThrown);
			}
		});
    });

	$(document).on("click", ".js-add-schedule", (e) => {
		let newRow = $("#template").clone();
		newRow.removeClass("template").attr("id", "");
		$("#schedules-form ul").append(newRow);
    });
});