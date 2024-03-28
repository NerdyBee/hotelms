$("#addRoom").submit(function () {
  var room_type_id = $("#room_type_id").val();
  var room_no = $("#room_no").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_type_id: room_type_id,
      room_no: room_no,
      add_room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#addRoom").modal("hide");
        window.location.href = "index.php?room_mang";
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

$("#roomEditFrom").submit(function () {
  var room_type_id = $("#edit_room_type").val();
  var room_no = $("#edit_room_no").val();
  var room_id = $("#edit_room_id").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_type_id: room_type_id,
      room_no: room_no,
      room_id: room_id,
      edit_room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#editRoom").modal("hide");
        window.location.href = "index.php?room_mang";
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

$(document).on("click", "#roomEdit", function (e) {
  e.preventDefault();

  var room_id = $(this).data("id");

  console.log(room_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_id: room_id,
      room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#edit_room_type").val(response.room_type_id);
        $("#edit_room_no").val(response.room_no);
        $("#edit_room_id").val(room_id);
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

function fetch_room(val) {
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      room_type_id: val,
      room_type: "",
    },
    success: function (response) {
      $("#room_no").html(response);
    },
  });
}

function fetch_room_checked(val) {
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      room_type_id: val,
      room_type_checked: "",
    },
    success: function (response) {
      $("#room_no_checked").html(response);
    },
  });
}

function validId(val) {
  if (val == 1) {
    document.getElementById("id_card_no").setAttribute("type", "number");
    document.getElementById("id_card_no").setAttribute("data-minlength", "12");
    document
      .getElementById("id_card_no")
      .setAttribute("placeholder", "647510001480");
    document
      .getElementById("id_card_no")
      .setAttribute(
        "data-error",
        "Enter 12 Digit Valid National Identity Card No"
      );
  } else if (val == 2) {
    document.getElementById("id_card_no").setAttribute("type", "text");
    document.getElementById("id_card_no").setAttribute("data-minlength", "11");
    document
      .getElementById("id_card_no")
      .setAttribute("placeholder", "COA/2635100");
    document
      .getElementById("id_card_no")
      .setAttribute(
        "data-error",
        "Enter 11 Character(include '/') Valid Voter ID Card No"
      );
  } else if (val == 3) {
    document.getElementById("id_card_no").setAttribute("type", "text");
    document.getElementById("id_card_no").setAttribute("data-minlength", "10");
    document
      .getElementById("id_card_no")
      .setAttribute("placeholder", "RKCS17878A");
    document
      .getElementById("id_card_no")
      .setAttribute("data-error", "Enter 10 Character Valid Pan Card No");
  } else if (val == 4) {
    document.getElementById("id_card_no").setAttribute("type", "text");
    document.getElementById("id_card_no").setAttribute("data-minlength", "16");
    document
      .getElementById("id_card_no")
      .setAttribute("placeholder", "RJ29 20210040869");
    document
      .getElementById("id_card_no")
      .setAttribute(
        "data-error",
        "Enter 16 Character(include space) Valid Licence Number"
      );
  }
}

function fetch_price(val) {
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      room_id: val,
      room_price: "",
    },
    success: function (response) {
      $("#price").html(response);
      var days = document.getElementById("staying_day").innerHTML;
      $("#total_price").html(response * days);
    },
  });
}
function handleCheckbox(checkbox) {
  if (checkbox.checked) {
    fetch_more_price(checkbox.value);
  } else {
    remove_more_price(checkbox.value);
  }
}

function fetch_more_price(val) {
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      room_id: val,
      room_price: "",
    },
    success: function (response) {
      // $("#price").html(response);
      var currentPrice = parseInt($("#price").html()); // Get the current price
      var newPrice = parseInt(response) + currentPrice; // Calculate the new price
      $("#price").html(newPrice); // Update the price element with the new total price
      var days = document.getElementById("staying_day").innerHTML;
      var currentTotal = parseInt($("#total_price").html());
      var newTotal = parseInt(response * days) + currentTotal;
      $("#total_price").html(newTotal);
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText); // Log any errors to the console
    },
  });
}

function remove_more_price(val) {
  $.ajax({
    type: "post",
    url: "ajax.php",
    data: {
      room_id: val,
      room_price: "",
      remove: true, // indicate that this is a remove operation
    },
    success: function (response) {
      var currentPrice = parseInt($("#price").html()); // Get the current price
      var newPrice = currentPrice - parseInt(response); // Calculate the new price
      $("#price").html(newPrice); // Update the price element with the new total price

      var days = parseInt(document.getElementById("staying_day").innerHTML);
      var currentTotal = parseInt($("#total_price").html());
      var newTotal = currentTotal - parseInt(response) * days; // Subtract from the total price
      $("#total_price").html(newTotal); // Update the total price element with the new total
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText); // Log any errors to the console
    },
  });
}

$("#booking").submit(function () {
  var room_type_id = $("#room_type").val();
  var room_type = $("#room_type :selected").text();
  var room_id = $("#room_no").val();
  var room_no = $("#room_no :selected").text();
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

  if (!room_no && !first_name && !contact_no && !address) {
    $(".response").html(
      '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Please Fill Cardinality</div>'
    );
  } else if (discount > (40 / 100) * total_p) {
    $(".response").html(
      '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Dsicount Cannot be more than 40%</div>'
    );
  } else {
    // console.log(total_price);
    $.ajax({
      type: "post",
      url: "ajax.php",
      dataType: "JSON",
      data: {
        room_type_id: room_type_id,
        room_id: room_id,
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
        booking: "",
      },
      success: function (response) {
        if (response.done == true) {
          $("#getBookID").val(response.book_id);
          $("#getCustomerName").html(first_name + " " + last_name);
          $("#getRoomType").html(room_type);
          $("#getRoomNo").html(room_no);
          $("#getCheckIn").html(check_in_date);
          $("#getCheckOut").html(check_out_date);
          $("#getDiscount").html(new Intl.NumberFormat().format(discount));
          $("#getTotalPrice").html(new Intl.NumberFormat().format(total_price));
          $("#getPaymentStaus").html("Unpaid");
          $("#bookingConfirm").modal("show");
          document.getElementById("booking").reset();

          // Construct the complete URL with parameters
          var url = "index.php?more_rooms&id=" + response.book_id;
          // Set href attribute for the 'More' link
          $("#moreLink").attr("href", url);
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

$("#edit_booking").submit(function () {
  var room_type_id = $("#room_type").val();
  var room_type = $("#room_type :selected").text();
  var room_id = $("#room_no").val();
  var room_no = $("#room_no :selected").text();
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

  if (!room_no && !first_name && !contact_no && !address) {
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
        room_type_id: room_type_id,
        room_id: room_id,
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
        booking: "",
      },
      success: function (response) {
        if (response.done == true) {
          $("#getCustomerName").html(first_name + " " + last_name);
          $("#getRoomType").html(room_type);
          $("#getRoomNo").html(room_no);
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

$(document).on("click", "#invoiceDetails", function (e) {
  e.preventDefault();

  var invoice_id = $(this).data("id");
  // alert(invoice_id);
  console.log(invoice_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      invoice_id: invoice_id,
      invoiceDetails: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#inv_det").html(response.inv_det);
        // $("#invoice_item").html(response.item);
        // $("#invoice_price").html(response.price);
        // $("#invoice_quantity").html(response.quantity);
        // $("#invoice_created_at").html(response.created_at);
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

$(document).on("click", "#cutomerDetails", function (e) {
  e.preventDefault();

  var room_id = $(this).data("id");
  // alert(room_id);
  console.log(room_id);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      room_id: room_id,
      cutomerDetails: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#customer_name").html(response.customer_name);
        $("#customer_contact_no").html(response.contact_no);
        $("#customer_email").html(response.email);
        $("#customer_id_card_type").html(response.id_card_type_id);
        $("#customer_id_card_number").html(response.id_card_no);
        $("#customer_address").html(response.address);
        $("#remaining_price").html(
          new Intl.NumberFormat().format(response.remaining_price)
        );
      } else {
        $(".cust_response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });
});

$(document).on("click", "#checkInRoom", function (e) {
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
        $("#room_id").val(room_id);
        $("#getCustomerName").html(response.name);
        $("#getRoomType").html(response.room_type);
        $("#getRoomNo").html(response.room_no);
        $("#getCheckIn").html(response.check_in);
        $("#getCheckOut").html(response.check_out);
        $("#getTotalPrice").html(
          new Intl.NumberFormat().format(response.total_price)
        );
        $("#getBookingID").val(response.booking_id);
        $("#checkIn").modal("show");
      } else {
        $(".payment-response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });
});

$("#advancePayment").submit(function () {
  var booking_id = $("#getBookingID").val();
  var advance_payment = $("#advance_payment").val();
  var payment_type = $("#payment_type").val();

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      booking_id: booking_id,
      advance_payment: advance_payment,
      payment_type: payment_type,
      check_in_room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#checkIn").modal("hide");
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

$(document).on("click", "#checkOutRoom", function (e) {
  e.preventDefault();

  var room_id = $(this).data("id");

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
        $("#getCustomerName_n").html(response.name);
        $("#getRoomType_n").html(response.room_type);
        $("#getRoomNo_n").html(response.room_no);
        $("#getCheckIn_n").html(response.check_in);
        $("#getCheckOut_n").html(response.check_out);
        $("#getTotalPrice_n").html(response.total_price + "/-");
        $("#getRemainingPrice_n").html(response.remaining_price + "/-");
        $("#getBookingId_n").val(response.booking_id);
        $("#checkOut").modal("show");
      } else {
        alert(response.data);
      }
    },
  });
});

$("#checkOutRoom_n").submit(function () {
  var booking_id = $("#getBookingId_n").val();
  var remaining_amount = $("#remaining_amount").val();
  var payment_type = $("#payment_type").val();
  var remainingPrice = $("#getRemainingPrice_n").val();

  console.log(payment_type);

  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      booking_id: booking_id,
      remaining_amount: remaining_amount,
      payment_type: payment_type,
      check_out_room: "",
    },
    success: function (response) {
      if (response.done == true) {
        $("#checkOut").modal("hide");
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

$("#addEmployee").submit(function () {
  var staff_type = $("#staff_type").val();
  var shift = $("#shift").val();
  var first_name = $("#first_name").val();
  var last_name = $("#last_name").val();
  var contact_no = $("#contact_no").val();
  var id_card_id = $("#id_card_id").val();
  var id_card_no = $("#id_card_no").val();
  var address = $("#address").val();
  var salary = $("#salary").val();

  console.log(staff_type + shift);
  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      staff_type: staff_type,
      shift: shift,
      first_name: first_name,
      last_name: last_name,
      contact_no: contact_no,
      id_card_id: id_card_id,
      id_card_no: id_card_no,
      address: address,
      salary: salary,
      add_employee: "",
    },
    success: function (response) {
      if (response.done == true) {
        document.getElementById("addEmployee").reset();
        $(".emp-response").html(
          '<div class="alert bg-success alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Employee Successfully Added</div>'
        );
      } else {
        $(".emp-response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});

$("#addUser").submit(function () {
  var privilege_id = $("#user_priv").val();
  var name = $("#full_name").val();
  var username = $("#username").val();
  var email = $("#email").val();
  var password = $("#password").val();

  console.log(name + email);
  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      privilege_id: privilege_id,
      name: name,
      username: username,
      email: email,
      password: password,
      add_user: "",
    },
    success: function (response) {
      if (response.done == true) {
        document.getElementById("addUser").reset();
        $(".user-response").html(
          '<div class="alert bg-success alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>User Successfully Added</div>'
        );
      } else {
        $(".user-response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });

  return false;
});

$("#edit_employee").submit(function () {
  var staff_type = $("#staff_type").val();
  var shift = $("#shift").val();
  var first_name = $("#first_name").val();
  var last_name = $("#last_name").val();
  var contact_no = $("#contact_no").val();
  var id_card_id = $("#id_card_id").val();
  var id_card_no = $("#id_card_no").val();
  var joining_date = $("#joining_date").val();
  var address = $("#address").val();
  var salary = $("#salary").val();

  //alert(first_name);
  $.ajax({
    type: "post",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      staff_type: staff_type,
      shift: shift,
      first_name: first_name,
      last_name: last_name,
      contact_no: contact_no,
      id_card_id: id_card_id,
      id_card_no: id_card_no,
      joining_date: joining_date,
      address: address,
      salary: salary,
      add_employee: "",
    },
    success: function (response) {
      alert("Employee Added Successfully");
      document.getElementById("add_employee").reset();
      /* if (response.done == true) {
             $('#getCustomerName').html(first_name+' '+last_name);
             $('#getRoomType').html(room_type);
             $('#getRoomNo').html(room_no);
             $('#getCheckIn').html(check_in_date);
             $('#getCheckOut').html(check_out_date);
             $('#getTotalPrice').html(total_price);
             $('#getPaymentStaus').html("Unpaid");
             $('#bookingConfirm').modal('show');
             document.getElementById("booking").reset();
             } else {
             $('.response').html('<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' + response.data + '</div>');
             }*/
    },
  });

  return false;
});

$(document).on("click", "#complaint", function (e) {
  e.preventDefault();

  var complaint_id = $(this).data("id");
  console.log(complaint_id);
  $("#complaint_id").val(complaint_id);
});

$(document).on("click", "#change_shift", function (e) {
  e.preventDefault();

  var emp_id = $(this).data("id");
  console.log(emp_id);
  $("#getEmpId").val(emp_id);
});

// $("#moreBooking").submit(function () {
//   var customerId = $("#customerId").val();
//   var checkin = $("#checkin").val();
//   var checkout = $("#checkout").val();
//   var discount = $("#discount").val();
//   var total_p = document.getElementById("total_price").innerHTML;
//   var total_price = total_p - discount;
//   // Gather selected checkbox values
//   var selectedRooms = $('input[name="room_no"]:checked')
//     .map(function () {
//       return this.value;
//     })
//     .get();

//   // Send selected rooms to PHP using AJAX
//   $.ajax({
//     type: "POST",
//     url: "ajax.php",
//     dataType: "JSON",
//     data: {
//       moreBook: "",
//       customerId: customerId,
//       checkin: checkin,
//       checkout: checkout,
//       discount: discount,
//       total_price: total_price,
//       rooms: selectedRooms,
//     },
//     success: function (response) {
//       if (response.done == true) {
//         // Handle the response from PHP
//         console.log("Response from PHP:", response);
//         // You can perform any further actions here based on the response
//         window.location.href = "index.php?room_mang";
//       } else {
//         $(".user-response").html(
//           '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
//             response.data +
//             "</div>"
//         );
//       }
//     },
//   });
// });

$("#moreBooking").submit(function (event) {
  event.preventDefault(); // Prevent the form from submitting normally

  var customerId = $("#customerId").val();
  var checkin = $("#checkin").html();
  var checkout = $("#checkout").html();
  var discount = $("#discount").val();
  var total_p = $("#total_price").text(); // Use jQuery to get the text content
  var total_price = parseFloat(total_p) - parseFloat(discount); // Convert to float and calculate total price

  // Gather selected checkbox values
  var selectedRooms = $('input[name="room_no"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  console.log(selectedRooms); // Debug statement to check selected rooms

  // Send selected rooms to PHP using AJAX
  $.ajax({
    type: "POST",
    url: "ajax.php",
    dataType: "JSON",
    data: {
      moreBook: "",
      customerId: customerId,
      checkin: checkin,
      checkout: checkout,
      discount: discount,
      total_price: total_price,
      rooms: selectedRooms,
    },
    success: function (response) {
      if (response.done == true) {
        // Handle the response from PHP
        console.log("Response from PHP:", response);
        // You can perform any further actions here based on the response
        window.location.href = "index.php?room_mang";
      } else {
        $(".user-response").html(
          '<div class="alert bg-danger alert-dismissable" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>' +
            response.data +
            "</div>"
        );
      }
    },
  });
});
