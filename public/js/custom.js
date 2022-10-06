$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/customer/all",
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);
                var id = value.customer_id;
                var tr = $("<tr>");
                tr.append($("<td>").html(value.customer_id));
                tr.append($("<td>").html(value.title));
                tr.append($("<td>").html(value.lname));
                tr.append($("<td>").html(value.fname));
                tr.append($("<td>").html(value.addressline));
                tr.append($("<td>").html(value.phone));
                tr.append(
                    "<td align='center'><a href=" +
                        "/api/customer/" +
                        id +
                        "/edit" +
                        "><i class='fa fa-pencil' aria-hidden='true' style='font-size:24px' ></a></i></td>"
                );
                tr.append(
                    "<td><a href='#'  class='deletebtn' data-id=" +
                        id +
                        "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>"
                );

                $("#cbody").append(tr);
            });
        },
        error: function () {
            console.log("AJAX load did not work");
            alert("error");
        },
    });

    $("#myFormSubmit").on("click", function (e) {
        e.preventDefault();
        var data = $("#cform").serialize();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/api/customer",
            data: data,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                // $("myModal").modal("hide");
                $("#myModal").each(function () {
                    $(this).modal("hide");
                });
                // $.each(data, function (key, value) {
                var tr = $("<tr>");
                tr.append($("<td>").html(data.customer_id));
                tr.append($("<td>").html(data.title));
                tr.append($("<td>").html(data.lname));
                tr.append($("<td>").html(data.fname));
                tr.append($("<td>").html(data.addressline));
                tr.append($("<td>").html(data.phone));
                tr.append(
                    "<td align='center'><a href=" +
                        "/api/customer/" +
                        data.customer_id +
                        "/edit" +
                        "><i class='fa fa-pencil' aria-hidden='true' style='font-size:24px' ></a></i></td>"
                );
                $("#ctable").prepend(tr);
                // });
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#cbody").on("click", ".deletebtn", function (e) {
        var id = $(this).data("id");
        var $tr = $(this).closest("tr");
        // var id = $(e.relatedTarget).attr('id');
        console.log(id);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this customer",
            buttons: {
                confirm: {
                    label: "yes",
                    className: "btn-success",
                },
                cancel: {
                    label: "no",
                    className: "btn-danger",
                },
            },
            callback: function (result) {
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: "/api/customer/" + id,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            // bootbox.alert('success');
                            $tr.find("td").fadeOut(2000, function () {
                                $tr.remove();
                            });
                        },
                        error: function (error) {
                            console.log("error");
                        },
                    });
            },
        });
    });
});
