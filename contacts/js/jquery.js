$(document).ready(function () {
  setTimeout(function () {
    $(".loading").fadeOut(100);
  }, 800);
  updateConnectionStatus();
  // Listen for changes in the connection status
  window.addEventListener("online", updateConnectionStatus);
  window.addEventListener("offline", updateConnectionStatus);

  function updateConnectionStatus() {
    if (navigator.onLine) {
      // The browser is online
      $(".log-btn svg g circle").css({
        fill: "#63c667",
      });
      $(".log-btn ").attr("title", "Connected");
      $(".log-btn svg g path").css({
        fill: "#63c667",
      });
    } else {
      // The browser is offline
      $(".log-btn svg g circle").css({
        fill: "#f23131",
      });
      $(".log-btn ").attr("title", "Disconnected");
      $(".log-btn svg g path").css({
        fill: "#f23131",
      });
    }
  }

  $(".item_name1").focus(function () {
    if ($("ul.suggestion").css("height") == "0px") {
      $("ul.suggestion1").css({
        height: "auto",
        border: "1px solid #cfcfcf",
      });
    } else {
      $("ul.suggestion1").css({
        height: "0",
        border: "0px solid #cfcfcf",
      });
    }
  });
  $(".item_name1").blur(function () {
    if ($(".item_id1") !== "") {
      $(this).val("");
      $(".item_id1").val("");
      $(".item_quantity1").val(0);
      $(".item_amount1").val(0);
      $(".item_unit1").val("");
      $(".item_total1").val(0).trigger("change");
    }
    $("ul.suggestion1").css({
      height: "0",
      border: "0px solid #cfcfcf",
    });
  });

  $(".sug").click(function () {
    alert("Clicked");
  });
  $("#customer").focus(function () {
    if ($("ul#customer-sugg").css("height") == "0px") {
      var exportHeight = $("ul#customer-sugg").prop("scrollHeight") + 10;
      $("ul#customer-sugg").css({
        height: exportHeight + "px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $("ul#customer-sugg").css({
        height: "0",
        border: "0px solid #cfcfcf",
      });
    }
  });
  $("#customer").blur(function () {
    $("ul#customer-sugg").css({
      height: "0",
      border: "0px solid #cfcfcf",
    });
  });

  $("#invoice-btn").click(function () {
    if ($(".invoice-page").css("height") == "0px") {
      $(".invoice-page").css({
        height: "100vh",
        "border-bottom": "1px solid #cfcfcf",
      });
      $("#statement").val("فاتوره توريد مع اذن دفع مقدم");
    }
  });
  $("#return-btn").click(function () {
    if ($(".invoice-page").css("height") == "0px") {
      $(".invoice-page").css({
        height: "100vh",
        "border-bottom": "1px solid #cfcfcf",
      });
      $("#statement").val("فاتوره مرتجع");
    }
  });
  $("#payment-btn").click(function () {
    var paymentHeight = $(".pay_payment_section").prop("scrollHeight") + 70;
    $(".pay_payment_section").css({
      height: paymentHeight + "px",
      padding: "20px 25px",
      border: "1px solid #cfcfcf",
    });
    $(".black_screen").fadeIn(200);
  });

  $(".invoice-page #close-btn").click(function () {
    $(".invoice-page").css({
      height: "0px",
      padding: "0",
      "border-bottom": "0px solid #cfcfcf",
    });
  });

  $(".pay_payment_section .close").click(function () {
    $(".pay_payment_section").css({
      height: "0px",
      padding: "0",
      border: "0px solid #cfcfcf",
    });
  });

  $(".invoice-page .cancels-btn").click(function (event) {
    event.preventDefault();
    $(".invoice-page").css({
      height: "0px",
      padding: "0",
      "border-bottom": "0px solid #cfcfcf",
    });
  });
  $(".add_notes").click(function () {
    $("#notes").toggle();
    $("#notes").focus();
    $(this).toggle();
    $(".notes-cont").toggle();
  });

  $(".notes-cont").click(function () {
    $("#notes").toggle();
    $(".add_notes").toggle();
    $("#notes").focus();
    $(this).toggle();
  });

  $("#notes").focusout(function () {
    $(".notes-cont").toggle();
    $(".add_notes").toggle();
    $(this).toggle();
  });

  $("button.transactions").click(function () {
    if ($("ul.transactions-list").css("height") == "0px") {
      var exportHeight = $("ul.transactions-list").prop("scrollHeight") + 30;
      $("ul.transactions-list").css({
        height: exportHeight + "px",
        padding: "10px",
        border: "1px solid #cfcfcf",
        "border-bottom": "2px solid var(--main-color)",
      });
    } else {
      $("ul.transactions-list").css({
        height: "0",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
    }
  });

  $("button.new-btn").click(function () {
    var exportHeight = $(".add_new").prop("scrollHeight") + 70;
    $(".add_new").css({
      height: exportHeight + "px",
      padding: "20px 25px",
      border: "1px solid #cfcfcf",
    });
    $(".black_screen").fadeIn(200);
  });
  $("button.close").click(function (event) {
    event.preventDefault();
    $(".black_screen").fadeOut(200);
    $(".add_new").css({
      height: "0px",
      padding: "0px",
      border: "0px solid #cfcfcf",
    });
    $("#new_item")[0].reset();
    $("#preview_item_img").attr("src", "../assets/items/no-photo.png");
  });

  $(".transaction-list button.export").click(function () {
    if ($("ul.export-options").css("height") == "0px") {
      var exportHeight = $(".transaction-list ul.export-options").prop("scrollHeight") + 70;
      $("ul.export-options").css({
        height: exportHeight + "px",
        padding: "20px",
        border: "1px solid #eeee",
        "border-bottom": "2px solid var(--main-color)",
      });
    } else {
      $("ul.export-options").css({
        height: "0",
        padding: "0px",
        border: "0px solid rgba(238, 238, 238, 0.933)",
      });
    }
  });
  $(".purchase-list button.export").click(function () {
    if ($("ul.export-options").css("height") == "0px") {
      var exportHeight = $(".purchase-list ul.export-options").prop("scrollHeight") + 70;
      $("ul.export-options").css({
        height: exportHeight + "px",
        padding: "20px",
        border: "1px solid #eeee",
        "border-bottom": "2px solid var(--main-color)",
      });
    } else {
      $("ul.export-options").css({
        height: "0",
        padding: "0px",
        border: "0px solid rgba(238, 238, 238, 0.933)",
      });
    }
  });
  $(".mony-list button.export").click(function () {
    if ($("ul.export-options").css("height") == "0px") {
      var exportHeight = $(".mony-list ul.export-options").prop("scrollHeight") + 70;
      $("ul.export-options").css({
        height: exportHeight + "px",
        padding: "20px",
        border: "1px solid #eeee",
        "border-bottom": "2px solid var(--main-color)",
      });
    } else {
      $("ul.export-options").css({
        height: "0",
        padding: "0px",
        border: "0px solid rgba(238, 238, 238, 0.933)",
      });
    }
  });
  $(".transaction-list button.filter").on("click", function () {
    var filterHeight = $(".transaction-list .filter-section").prop("scrollHeight");
    if ($(".transaction-list .filter-section").css("height") == "0px") {
      if ($("html, body").scrollTop() < "50") {
        $("html, body").animate({
          scrollTop: "+=450px",
        });
      }
      $(".transaction-list .btns").css({
        "margin-bottom": "10px",
      });
      $(".transaction-list .filter-section").css({
        border: "0px solid #cfcfcf",
      });
      $(".transaction-list .filter-section").css({
        height: filterHeight + "px",
        padding: "5px 25px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $(".transaction-list .filter-section").css({
        height: "0px",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
      $(".transaction-list .btns").css({
        "margin-bottom": "0px",
      });
    }
  });
  $(".mony-list button.filter").on("click", function () {
    var filterHeight = $(".mony-list .filter-section").prop("scrollHeight");
    if ($(".mony-list .filter-section").css("height") == "0px") {
      if ($("html, body").scrollTop() < "50") {
        $("html, body").animate({
          scrollTop: "+=450px",
        });
      }
      $(".mony-list  .btns").css({
        "margin-bottom": "10px",
      });
      $(".mony-list .filter-section").css({
        border: "0px solid #cfcfcf",
      });
      $(".mony-list .filter-section").css({
        height: filterHeight + "px",
        padding: "5px 25px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $(".mony-list .filter-section").css({
        height: "0",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
      $(".mony-list  .btns").css({
        "margin-bottom": "0px",
      });
    }
  });
  $(".purchase-list button.filter").on("click", function () {
    var filterHeight = $(".purchase-list .filter-section").prop("scrollHeight");
    if ($(".purchase-list .filter-section").css("height") == "0px") {
      if ($("html, body").scrollTop() < "50") {
        $("html, body").animate({
          scrollTop: "+=450px",
        });
      }
      $(".purchase-list  .btns").css({
        "margin-bottom": "10px",
      });
      $(".purchase-list .filter-section").css({
        border: "0px solid #cfcfcf",
      });
      $(".purchase-list .filter-section").css({
        height: filterHeight + "px",
        padding: "5px 25px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $(".purchase-list .filter-section").css({
        height: "0",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
      $(".purchase-list  .btns").css({
        "margin-bottom": "0px",
      });
    }
  });

  $("button.edit-btn").click(function () {
    var exportHeight = $(".edit_supplo").prop("scrollHeight") + 70;
    $(".edit_supplo").css({
      height: exportHeight + "px",
      padding: "20px 25px",
      border: "1px solid #cfcfcf",
    });
    $(".black_screen").fadeIn(200);
  });

  $("#supplierslist").on("change", "#ck-all", function () {
    if ($(this).is(":checked")) {
      $('td input[type="checkbox"]').prop("checked", true);
    } else {
      $('td input[type="checkbox"]').prop("checked", false);
    }
  });

  $("#ask").on("change", function () {
    if ($(this).is(":checked")) {
      $("#company").attr("required", "required");
      $("#fname").removeAttr("required");
    } else {
      $("#fname").attr("required", "required");
      $("#company").removeAttr("required");
    }
  });

  $("#ask1").on("change", function () {
    if ($(this).is(":checked")) {
      $(".user-input").attr("required", "required");
      $(".user-input").show();
    } else {
      $(".user-input").hide();
      $(".user-input").removeAttr("required");
    }
  });

  $("#supplierslist").on("change", 'input[type="checkbox"]', function () {
    if ($('.list-form input[type="checkbox"]:checked').length === 0 && $('.list-form input[type="checkbox"]').length > 1) {
      // All checkboxes are not checked
      $("input.delete-btn").css({
        display: "none",
      });
      $(".employee-section.request-section").css({
        "margin-top": "0px",
      });
    } else if ($('.list-form input[type="checkbox"]:checked').length !== $('.list-form input[type="checkbox"]').length) {
      $("#ck-all").prop("checked", false);
      $("input.delete-btn").css({
        display: "block",
      });
      $(".employee-section.request-section").css({
        "margin-top": "50px",
      });
    } else {
      // Some checkboxes are checked
      $("input.delete-btn").css({
        display: "block",
      });
      $(".employee-section.request-section").css({
        "margin-top": "50px",
      });
    }
  });
  $(".transaction-list input.delete-btn").click(function (event) {
    event.preventDefault();
  });
  $('.transaction-list .list-form input[type="checkbox"]').change(function () {
    if ($('.transaction-list .list-form input[type="checkbox"]:checked').length === 0 && $('.list-form input[type="checkbox"]').length > 1) {
      // All checkboxes are not checked
      $(".employee-section.request-section").css({
        "margin-top": "0px",
      });
      $(".transaction-list input.delete-btn").css({
        opacity: "0.2",
        cursor: "auto",
      });
      $(".transaction-list input.delete-btn").click(function (event) {
        event.preventDefault();
      });
    } else if ($('.list-form input[type="checkbox"]:checked').length !== $('.list-form input[type="checkbox"]').length) {
      $(".employee-section.request-section").css({
        "margin-top": "0px",
      });
      $(".transaction-list input.delete-btn").css({
        opacity: "1",
        cursor: "pointer",
      });
      $(".transaction-list input.delete-btn").unbind("click");
    } else {
      // Some checkboxes are checked
      $(".employee-section.request-section").css({
        "margin-top": "0px",
      });
      $(".transaction-list input.delete-btn").css({
        opacity: "1",
        cursor: "pointer",
      });
      $(".transaction-list input.delete-btn").unbind("click");
    }
  });

  $(".error-mg").delay(2000).fadeOut(1000);
  $(".add_success").delay(2000).fadeOut(500);
  $(".error_field").focus();

  $(".rpassword").keyup(function () {
    if ($(this).val() !== "") {
      if ($(this).val() == $(".password").val()) {
        $(".er_mg").html("Password match");
        $(".er_mg").removeClass("not_iden");
        $(".er_mg").addClass("iden");
      } else {
        $(".er_mg").html("Password doesn't match");
        $(".er_mg").removeClass("iden");
        $(".er_mg").addClass("not_iden");
      }
    } else {
      $(".er_mg").html("");
    }
  });
  $(".password").keyup(function () {
    if ($(".rpassword").val() !== "") {
      if ($(this).val() == $(".rpassword").val()) {
        $(".er_mg").html("Password match");
        $(".er_mg").removeClass("not_iden");
        $(".er_mg").addClass("iden");
      } else {
        $(".er_mg").html("Password doesn't match");
        $(".er_mg").removeClass("iden");
        $(".er_mg").addClass("not_iden");
      }
    } else {
      $(".er_mg").html("");
    }
  });

  $("span.n-char").html(200 - $('textarea[name="notes"]').val().length);
  $('textarea[name="notes"]').keyup(function () {
    $("span.n-char").html(200 - $('textarea[name="notes"]').val().length);
  });

  $(".remove-pic").click(function () {
    $(".preview-avatar").attr("src", "");
    $("#profile-pic").val("");
    $(".exist-file").hide();
    $(".none-file").css({
      display: "flex",
    });
  });

  if ($("#type").val() == "employee") {
    $(".user-only input,.user-only select").removeAttr("require");
    $(".user-only").hide();
  } else {
    $(".user-only input,.user-only select").attr("require", "required");
    $(".user-only").show();
  }
  $("#type").change(function () {
    if ($("#type").val() == "employee") {
      $(".user-only input,.user-only select").removeAttr("require");
      $(".user-only").hide();
    } else {
      $(".user-only input,.user-only select").attr("require", "required");
      $(".user-only").show();
    }
  });

  $(".delete_row").click(function (event) {
    event.preventDefault();
    var row_id = $(this).attr("data-row");
    var selectedrow = document.getElementById(row_id);
    selectedrow.remove();
  });

  $(".invoice-page #add-line").on("click", function () {
    event.preventDefault();

    var randomNumber = Math.floor(Math.random() * (99999999 - 999999 + 1)) + 999999;

    $(".invoice-list .request-body-list").append('<div class="request-row" id="' + randomNumber + '"><div class="handle"><i class="fa-solid fa-ellipsis"></i></div><div><input type="text" class="item_name item_name' + randomNumber + '" name="p[' + randomNumber + '][name]" value=""><input type="number" class="hidden item_id' + randomNumber + '" name="p[' + randomNumber + '][id]" value=""><ul class="suggestion suggestion' + randomNumber + '"></ul></div><div><input type="text" name="p[' + randomNumber + '][description]" value=""></div><div><input type="number" class="item_quantity' + randomNumber + '" name="p[' + randomNumber + '][quantity]" value="0" step="0.01"></div><div><input type="text" class="item_unit' + randomNumber + '" name="p[' + randomNumber + '][unit]" value="" min="0" disabled></div><div><input type="number" class="item_amount' + randomNumber + '" name="p[' + randomNumber + '][amount]" value="0"  step="0.01"></div><div><input type="number" class="item_total item_total' + randomNumber + '" name="p[' + randomNumber + '][total]" value="0" step="0.01"  disabled></div><div><button class="delete_row" data-row="' + randomNumber + '"><i class="fa-solid fa-trash"></i></button></div></div>');

    $(".item_quantity" + randomNumber).on("input", function () {
      var new_amount = $(this).val() * $(".item_amount" + randomNumber).val();
      $(".item_total" + randomNumber)
        .val(new_amount)
        .trigger("change");
    });
    $(".item_amount" + randomNumber).on("input", function () {
      var new_amount = $(this).val() * $(".item_quantity" + randomNumber).val();
      $(".item_total" + randomNumber)
        .val(new_amount)
        .trigger("change");
    });

    $(".suggestion" + randomNumber).on("click", ".sug", function () {
      $.ajax({
        type: "POST",
        url: "functions/core/import_item_details.php",
        data: {
          data_id: $(this).attr("data-id"),
        },
        dataType: "json",
        success: function (data) {
          var name = data.name;
          var amount = data.amount;
          var id = data.id;
          var unit = data.unit;
          $(".item_name" + randomNumber).val(name);
          $(".item_amount" + randomNumber).val(amount);
          $(".item_id" + randomNumber).val(id);
          $(".item_unit" + randomNumber).val(unit);
          $(".item_quantity" + randomNumber).val(1);
          $(".item_total" + randomNumber)
            .val(amount)
            .trigger("change");
        },
      });
    });

    $(".item_name" + randomNumber).focus(function () {
      if ($("ul.suggestion" + randomNumber).css("height") == "0px") {
        $("ul.suggestion" + randomNumber).css({
          height: "auto",
          border: "1px solid #cfcfcf",
        });
      } else {
        $("ul.suggestion" + randomNumber).css({
          height: "0",
          border: "0px solid #cfcfcf",
        });
      }
    });
    $(".item_name" + randomNumber).blur(function () {
      if ($(".item_id" + randomNumber) !== "") {
        $(this).val("");
        $(".item_id" + randomNumber).val("");
        $(".item_quantity" + randomNumber).val(0);
        $(".item_amount" + randomNumber).val(0);
        $(".item_unit" + randomNumber).val("");
        $(".item_total" + randomNumber)
          .val(0)
          .trigger("change");
      }
      $("ul.suggestion" + randomNumber).css({
        height: "0",
        border: "0px solid #cfcfcf",
      });
    });

    $(".item_name" + randomNumber).on("input", function () {
      $.ajax({
        type: "POST",
        url: "functions/core/item-search.php",
        data: {
          item_search: $(this).val(),
        },
        success: function (data) {
          $(".suggestion" + randomNumber).html(data);
        },
      });
    });

    $(".delete_row").click(function (event) {
      event.preventDefault();
      var rowNumber = $(this).attr("data-row");
      $(".item_total" + rowNumber)
        .val(0)
        .trigger("change");
      var row_id = $(this).attr("data-row");
      var selectedrow = document.getElementById(row_id);
      selectedrow.remove();
    });
  });
});
function previewFile(input) {
  var file = $("#profile-pic").get(0).files[0];

  if (file) {
    var reader = new FileReader();

    reader.onload = function () {
      $(".preview-avatar").attr("src", reader.result);
      $(".none-file").hide();
      $(".exist-file").css({
        display: "flex",
      });
    };

    reader.readAsDataURL(file);
  }
}
