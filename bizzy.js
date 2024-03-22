$("#addHall").submit(function () {
  var hall = $("#hall").val();
  var price = $("#price").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      hall: hall,
      price: price,
      add_hall: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#addHall").modal("hide");
        window.location.href = "index.php?halls";
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

$("#hallEditFrom").submit(function () {
  var hall = $("#edit_hall").val();
  var price = $("#edit_price").val();
  var hall_id = $("#edit_hall_id").val();

  //   console.log(hall + " " + price + " " + hall_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      hall_id: hall_id,
      price: price,
      hall: hall,
      edit_hall: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editHall").modal("hide");
        window.location.href = "index.php?halls";
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

$("#laundryEditFrom").submit(function () {
  var apparel = $("#edit_apparel").val();
  var wash = $("#edit_wash").val();
  var iron = $("#edit_iron").val();
  var laundry_id = $("#edit_id").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      laundry_id: laundry_id,
      apparel: apparel,
      wash: wash,
      iron: iron,
      edit_laundry: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editLaundry").modal("hide");
        window.location.href = "index.php?laundry";
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

$("#gymEditFrom").submit(function () {
  var description = $("#edit_description").val();
  var amount = $("#edit_amount").val();
  var gym_id = $("#edit_id").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      gym_id: gym_id,
      description: description,
      amount: amount,
      edit_gym: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editGym").modal("hide");
        window.location.href = "index.php?gym";
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

$(document).on("click", "#gymEdit", function (e) {
  e.preventDefault();

  var gym_id = $(this).data("id");

  console.log(gym_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      gym_id: gym_id,
      gym_edit: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_description").val(response.description);
        $("#edit_amount").val(response.amount);
        $("#edit_id").val(response.id);
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

$(document).on("click", "#laundryEdit", function (e) {
  e.preventDefault();

  var laundry_id = $(this).data("id");

  console.log(laundry_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      laundry_id: laundry_id,
      laundry_edit: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_apparel").val(response.apparel);
        $("#edit_wash").val(response.wash);
        $("#edit_iron").val(response.iron);
        $("#edit_id").val(response.id);
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

$(document).on("click", "#hallEdit", function (e) {
  e.preventDefault();

  var hall_id = $(this).data("id");

  console.log(hall_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      hall_id: hall_id,
      hall_edit: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_hall").val(response.hall);
        $("#edit_price").val(response.price);
        $("#edit_hall_id").val(hall_id);
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

function fetch_hall_price(val) {
  // console.log(val);
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      hall_id: val,
      hall_price: "",
    },
    success: function (response) {
      $("#price").html(response);
      var days = document.getElementById("staying_day").innerHTML;
      $("#total_price").html(response * days);
    },
  });
}

$("#hallBooking").submit(function () {
  var hall_id = $("#hall").val();
  var hall = $("#hall :selected").text();
  var check_in_date = $("#check_in_date").val();
  var check_out_date = $("#check_out_date").val();
  var discount = $("#discount").val();
  var first_name = $("#first_name").val();
  var last_name = $("#last_name").val();
  var contact_no = $("#contact_no").val();
  var email = $("#email").val();
  var id_card_id = $("#id_card_id").val();
  var id_card_no = $("#id_card_no").val();
  var address = $("#address").val();
  var total_p = document.getElementById("total_price").innerHTML;
  var total_price = total_p - discount;

  if (!hall && !first_name && !contact_no && !address) {
    $(".response").html(
      '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Please Fill Cardinality</div>'
    );
  } else if (discount > (40 / 100) * total_p) {
    $(".response").html(
      '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Dsicount Cannot be more than 40%</div>'
    );
  } else {
    console.log(total_price);
    $.ajax({
      type: "post",
      url: "ajax.php",
      dataType: "JSON",
      data: {
        hall_id: hall_id,
        check_in: check_in_date,
        check_out: check_out_date,
        discount: discount,
        total_price: total_price,
        name: first_name + " " + last_name,
        contact_no: contact_no,
        email: email,
        id_card_id: id_card_id,
        id_card_no: id_card_no,
        address: address,
        hall_booking: "",
      },
      success: function (response) {
        if (response.done == true) {
          $("#getCustomerName").html(first_name + " " + last_name);
          $("#getHall").html(hall);
          $("#getCheckIn").html(check_in_date);
          $("#getCheckOut").html(check_out_date);
          $("#getDiscount").html(new Intl.NumberFormat().format(discount));
          $("#getTotalPrice").html(new Intl.NumberFormat().format(total_price));
          $("#getPaymentStaus").html("Unpaid");
          $("#bookingConfirm").modal("show");
          document.getElementById("booking").reset();
        } else {
          $(".response").html(
            '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
              response.data +
              "</div>"
          );
        }
      },
    });
  }

  return false;
});

function myFunction() {
  // console.log("first");
  var x = document.getElementById("discount").value;
  document.getElementById("price").innerHTML =
    document.getElementById("price").innerHTML - x;
  document.getElementById("disco").innerHTML = x;
  document.getElementById("total_pay").innerHTML =
    document.getElementById("total_price").innerHTML - x;
}
