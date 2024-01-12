$(document).ready(function () {
  // Check the initial state of the connection
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

  $(".lside .sidebar ul li div.drop-down-1").click(function () {
    var sideHeight = $(".drop-down-menu-1").prop("scrollHeight");
    if ($(".drop-down-menu-1").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-1").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });

  $(".lside .sidebar ul li div.drop-down-2").click(function () {
    var sideHeight = $(".drop-down-menu-2").prop("scrollHeight");
    if ($(".drop-down-menu-2").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-2").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });

  $(".lside .sidebar ul li div.drop-down-3").click(function () {
    var sideHeight = $(".drop-down-menu-3").prop("scrollHeight");
    if ($(".drop-down-menu-3").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-3").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });

  $(".lside .sidebar ul li div.drop-down-4").click(function () {
    var sideHeight = $(".drop-down-menu-4").prop("scrollHeight");
    if ($(".drop-down-menu-4").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-4").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });

  $(".lside .sidebar ul li div.drop-down-5").click(function () {
    var sideHeight = $(".drop-down-menu-5").prop("scrollHeight");
    if ($(".drop-down-menu-5").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-5").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });

  $(".lside .sidebar ul li div.drop-down-6").click(function () {
    var sideHeight = $(".drop-down-menu-6").prop("scrollHeight");
    if ($(".drop-down-menu-6").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-6").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });
  $(".lside .sidebar ul li div.drop-down-7").click(function () {
    var sideHeight = $(".drop-down-menu-7").prop("scrollHeight");
    if ($(".drop-down-menu-7").css("height") !== sideHeight + "px") {
      $(".drop-down-menu-7").animate({ height: sideHeight + "px" }, 100);
      $(".drop-down-menu-1").animate({ height: "0" }, 100);
      $(".drop-down-menu-2").animate({ height: "0" }, 100);
      $(".drop-down-menu-4").animate({ height: "0" }, 100);
      $(".drop-down-menu-3").animate({ height: "0" }, 100);
      $(".drop-down-menu-6").animate({ height: "0" }, 100);
      $(".drop-down-menu-5").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-1 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-5 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-2 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-3 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-4 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-6 a span.arrow").css({ transform: "rotate(0deg)" });
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(180deg)" });
    } else {
      $(".drop-down-menu-7").animate({ height: "0" }, 100);
      $(".lside .sidebar ul li div.drop-down-7 a span.arrow").css({ transform: "rotate(0deg)" });
    }
  });
  $(".profile").click(function () {
    if ($(".profile ul").css("height") == "0px") {
      var exportHeight = $(".profile ul").prop("scrollHeight") + 20;
      $(".profile ul").css({
        height: exportHeight + "px",
        padding: "5px 20px 10px",
        border: "1px solid #cfcfcf",
      });
    } else {
      $(".profile ul").css({
        height: "0",
        padding: "0px",
        border: "0px solid #cfcfcf",
      });
    }
  });

  $(".lside").hover(
    function () {
      $(":root").css({ "--sidebar-width": "250px" });
      $(".lside .logo .slogan").css({ display: "flex" });
      $(".lside").css({ "box-shadow": "3px 0px 12px 0px rgb(0 0 0 / 12%)" });
      $(".lside .sidebar ul li a span .title").css({ display: "flex" });
      $(".lside .sidebar ul li a span").css({ "justify-content": "flex-start" });
      $(".lside .sidebar ul li a").css({ "justify-content": "flex-start", "padding-left": "25px" });
      $(".lside .sidebar ul li a").addClass("ar");
      $(".lside .sidebar ul li div.drop-down a span.arrow").css({ display: "flex" });
    },
    function () {
      $(":root").css({ "--sidebar-width": "60px" });
      $(".lside .logo .slogan").css({ display: "none" });
      $(".lside").css({ "box-shadow": "none" });
      $(".lside .sidebar ul li a span .title").css({ display: "none" });
      $(".lside .sidebar ul li a span").css({ "justify-content": "center" });
      $(".lside .sidebar ul li a").css({ "justify-content": "center", "padding-left": "0px" });
      $(".lside .sidebar ul li a").removeClass("ar");
      $("ul.drop-down-menu").css({ height: "0px" });
      $(".lside .sidebar ul li div.drop-down a span.arrow").css({ transform: "rotate(0deg)", display: "none" });
    }
  );
  $(".remove-pic").click(function () {
    $(".preview-avatar").attr("src", "");
    $("#profile-pic").val("");
    $(".exist-file").hide();
    $(".none-file").css({ display: "flex" });
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
});
