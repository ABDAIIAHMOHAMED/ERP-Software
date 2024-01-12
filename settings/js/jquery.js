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
      $(".log-btn svg g circle").css({ fill: "#63c667" });
      $(".log-btn ").attr("title", "Connected");
      $(".log-btn svg g path").css({ fill: "#63c667" });
    } else {
      // The browser is offline
      $(".log-btn svg g circle").css({ fill: "#f23131" });
      $(".log-btn ").attr("title", "Disconnected");
      $(".log-btn svg g path").css({ fill: "#f23131" });
    }
  }

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
  $("button.close").click(function () {
    $(".black_screen").fadeOut(200);
    $(".add_new").css({
      height: "0px",
      padding: "0px",
      border: "0px solid #cfcfcf",
    });
  });
  $("button.export").click(function () {
    if ($("ul.export-options").css("height") == "0px") {
      var exportHeight = $("ul.export-options").prop("scrollHeight") + 70;
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
  $("button.filter").click(function () {
    if ($(".filter-section").css("height") == "0px") {
      var filterHeight = $(".filter-section").prop("scrollHeight");
      $(".filter-section").css({
        height: filterHeight + "px",
        padding: "5px 25px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $(".filter-section").css({
        height: "0",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
    }
  });

  $(".transaction-list button.filter").click(function () {
    if ($(".filter-section").css("height") == "0px") {
      $(".transaction-list input.delete-btn").css({ top: "-260px" });
      $(".transaction-list .btns").css({ "margin-bottom": "10px" });
      $(".filter-section").css({ border: "0px solid #cfcfcf" });
    } else {
      $(".transaction-list input.delete-btn").css({ top: "-45px" });
      $(".transaction-list .btns").css({ "margin-bottom": "0px" });
    }
  });
  $("ul.customer li.activity-lnk button#activity-lnk").click(function () {
    $("li.activity-lnk").addClass("active");
    $("li.details-lnk").removeClass("active");
    $("li.transaction-lnk").removeClass("active");
    $(".activity-list").show();
    $(".transaction-list").hide();
    $(".details-list").hide();
    window.localStorage["active-menu"] = "activity";
  });
  $("ul.customer li.transaction-lnk button#transaction-lnk").click(function () {
    $("li.transaction-lnk").addClass("active");
    $("li.activity-lnk").removeClass("active");
    $("li.details-lnk").removeClass("active");
    $(".transaction-list").show();
    $(".details-list").hide();
    $(".activity-list").hide();
    window.localStorage["active-menu"] = "transaction";
  });

  $("ul.customer li.details-lnk button#details-lnk").click(function () {
    $("li.details-lnk").addClass("active");
    $("li.activity-lnk").removeClass("active");
    $("li.transaction-lnk").removeClass("active");
    $(".transaction-list").hide();
    $(".details-list").show();
    $(".activity-list").hide();
    window.localStorage["active-menu"] = "details";
  });

  if (window.localStorage["active-menu"] == "details") {
    $("li.details-lnk").addClass("active");
    $("li.activity-lnk").removeClass("active");
    $("li.transaction-lnk").removeClass("active");
    $(".transaction-list").hide();
    $(".details-list").show();
    $(".activity-list").hide();
  } else if (window.localStorage["active-menu"] == "transaction") {
    $("li.transaction-lnk").addClass("active");
    $("li.activity-lnk").removeClass("active");
    $("li.details-lnk").removeClass("active");
    $(".transaction-list").show();
    $(".details-list").hide();
    $(".activity-list").hide();
  } else {
    $("li.activity-lnk").addClass("active");
    $("li.details-lnk").removeClass("active");
    $("li.transaction-lnk").removeClass("active");
    $(".activity-list").show();
    $(".transaction-list").hide();
    $(".details-list").hide();
  }

  $("button.edit-btn").click(function () {
    var exportHeight = $(".add_new").prop("scrollHeight") + 70;
    $(".add_new").css({
      height: exportHeight + "px",
      padding: "20px 25px",
      border: "1px solid #cfcfcf",
    });
    $(".black_screen").fadeIn(200);
  });

  $("#ck-all").on("change", function () {
    if ($(this).is(":checked")) {
      $('.list-form input[type="checkbox"]').prop("checked", true);
    } else {
      $('.list-form input[type="checkbox"]').prop("checked", false);
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

  $('.list-form input[type="checkbox"]').change(function () {
    if ($('.list-form input[type="checkbox"]:checked').length === 0 && $('.list-form input[type="checkbox"]').length > 1) {
      // All checkboxes are not checked
      $("input.delete-btn").css({ display: "none" });
      $(".employee-section.request-section").css({ "margin-top": "0px" });
    } else if ($('.list-form input[type="checkbox"]:checked').length !== $('.list-form input[type="checkbox"]').length) {
      $("#ck-all").prop("checked", false);
      $("input.delete-btn").css({ display: "block" });
      $(".employee-section.request-section").css({ "margin-top": "50px" });
    } else {
      // Some checkboxes are checked
      $("input.delete-btn").css({ display: "block" });
      $(".employee-section.request-section").css({ "margin-top": "50px" });
    }
  });
  $(".transaction-list input.delete-btn").click(function (event) {
    event.preventDefault();
  });
  $('.transaction-list .list-form input[type="checkbox"]').change(function () {
    if ($('.transaction-list .list-form input[type="checkbox"]:checked').length === 0 && $('.list-form input[type="checkbox"]').length > 1) {
      // All checkboxes are not checked
      $(".employee-section.request-section").css({ "margin-top": "0px" });
      $(".transaction-list input.delete-btn").css({
        opacity: "0.2",
        cursor: "auto",
      });
      $(".transaction-list input.delete-btn").click(function (event) {
        event.preventDefault();
      });
    } else if ($('.list-form input[type="checkbox"]:checked').length !== $('.list-form input[type="checkbox"]').length) {
      $(".employee-section.request-section").css({ "margin-top": "0px" });
      $(".transaction-list input.delete-btn").css({
        opacity: "1",
        cursor: "pointer",
      });
      $(".transaction-list input.delete-btn").unbind("click");
    } else {
      // Some checkboxes are checked
      $(".employee-section.request-section").css({ "margin-top": "0px" });
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
    $(".none-file").css({ display: "flex" });
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

  // $(document).bind("contextmenu", function (e) {
  //   return false;
  // });
});

function previewFile(input) {
  var file = $("#profile-pic").get(0).files[0];

  if (file) {
    var reader = new FileReader();

    reader.onload = function () {
      $(".preview-avatar").attr("src", reader.result);
      $(".none-file").hide();
      $(".exist-file").css({ display: "flex" });
    };

    reader.readAsDataURL(file);
  }
}
