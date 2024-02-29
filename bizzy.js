$("#addRoomType").submit(function () {
  var room_type = $("#room_type").val();
  var price = $("#price").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_type: room_type,
      price: price,
      add_room_type: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#addRoomType").modal("hide");
        window.location.href = "index.php?room_type";
      } else {
        $(".response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});

$("#roomTypeEditFrom").submit(function () {
  var room_type = $("#edit_room_type").val();
  var price = $("#edit_price").val();
  var room_type_id = $("#edit_room_type_id").val();

  //   console.log(room_type + " " + price + " " + room_type_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_type_id: room_type_id,
      price: price,
      room_type: room_type,
      edit_room_type: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editRoomType").modal("hide");
        window.location.href = "index.php?room_type";
      } else {
        $(".edit_response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});

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
  var payment_type = $("#payment_type").val();

  console.log(payment_type);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      booking_id: booking_id,
      remaining_amount: remaining_amount,
      payment_type: payment_type,
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

$("#itemEditFrom").submit(function () {
  var item = $("#edit_item").val();
  var category = $("#edit_category").val();
  var price = $("#edit_price").val();
  var item_id = $("#edit_item_id").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      item_id: item_id,
      item: item,
      category: category,
      price: price,
      edit_item: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editItem").modal("hide");
        window.location.href = "index.php?inventory";
      } else {
        $(".response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});

$(document).on("click", "#itemEdit", function (e) {
  e.preventDefault();

  var item_id = $(this).data("id");

  console.log(item_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      item_id: item_id,
      item_edit: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_item").val(response.item);
        $("#edit_category").val(response.category);
        $("#edit_price").val(response.price);
        $("#edit_quantity").val(response.quantity);
        $("#edit_item_id").val(item_id);
      } else {
        $(".edit_response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });
});

$(document).on("click", "#roomTypeEdit", function (e) {
  e.preventDefault();

  var room_type_id = $(this).data("id");

  console.log(room_type_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_type_id: room_type_id,
      room_type_edit: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_room_type").val(response.room_type);
        $("#edit_price").val(response.price);
        $("#edit_room_type_id").val(room_type_id);
      } else {
        $(".edit_response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });
});

function myFunction() {
  console.log("first");
  var x = document.getElementById("discount").value;
  document.getElementById("price").innerHTML =
    document.getElementById("price").innerHTML - x;
  document.getElementById("disco").innerHTML = x;
  document.getElementById("total_pay").innerHTML =
    document.getElementById("total_price").innerHTML - x;
}
