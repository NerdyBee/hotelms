$(document).on("click", "#morePayments", function (e) {
  e.preventDefault();

  var room_id = $(this).data("id");
  console.log(room_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_id: room_id,
      booked_room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#getCustomerName_p").html(response.name);
        $("#getRoomType_p").html(response.room_type);
        $("#getRoomNo_p").html(response.room_no);
        $("#getCheckIn_p").html(response.check_in);
        $("#getCheckOut_p").html(response.check_out);
        $("#getTotalPrice_p").html(response.total_price + "/-");
        $("#getRemainingPrice_p").html(response.remaining_price + "/-");
        $("#getBookingId_p").val(response.booking_id);
        $("#morePaymentModal").modal("show");
      } else {
        alert(response.data);
      }
    },
  });
});

$("#morePayment_p").submit(function () {
  var booking_id = $("#getBookingId_p").val();
  var remaining_amount = $("#more_payment").val();

  console.log(booking_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      booking_id: booking_id,
      remaining_amount: remaining_amount,
      more_payment: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#morePaymentModal").modal("hide");
        window.location.href = "index.php?room_mang";
      } else {
        $(".payment-response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});
