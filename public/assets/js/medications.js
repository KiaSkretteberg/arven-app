

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
			data: {medication_id: id.replace("medicine-", ""), method: 'ajax'},
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
		newRow.addClass("js-schedule-row");
		$("#schedules-form ul").append(newRow);
    });

	$(document).on("change", ".js-schedule-row select, .js-schedule-row input", (e) => {
		let row = $(e.target).parents("li");
		let id = row.data("id").replace("schedule-", "");
		let medicineId = $("#schedules-form").data("id").replace("medicine-", "");

        $.ajax({
			type: "POST",
			url: "/schedules/" + (id == "new" ? "edit/" : "add"),
			dataType: 'json',
			data: {
				medication_id: medicineId,
				id: id,
				frequency: row.find("[name=frequency]").val(),
				date: row.find("[name=date]").val(),
				time: row.find("[name=time]").val(),
				method: 'ajax'
			},
			beforeSend: function() {
				$('.load-content').addClass('loading');
			},
			success: function(id) {
				$('.load-content').removeClass('loading');
				row.data('id', "schedule-" + id);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.load-content').removeClass('loading');
				console.log(jqXHR, textStatus, errorThrown);
			}
		});
	});
});