<?php
$pg_name = "Wonder - Dashboard";
session_start();
include "includes/header.inc";
if (login_redirect() == 1) {

  $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
  $path .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["PHP_SELF"]);
  $user_info = login_info();
  header("location:" . $path . "/../contacts/index.php");
  exit();
?>
  <!-- #F1DDCA -->
  <!-- #AD6420-->
  <div class="att-part">
    <div class="title-head">
      <div class="headso">
        <h3>Dashboard - Inventory</h3>
        <hr class="head-line" />
      </div>
    </div>
    <div class="widgets-section">
      <div class="widgets-grid">
        <a href="<?= $path . "/warehouses.php" ?>" class="widget-bx" target="_blank">
          <div class="widget-txt">
            <div class="widget-head">Warehouses</div>
            <span class="info">Total warehouses count</span>
            <div class="widget-value"><span class="w-value" data-value="<?= get_number('warehouses') ?>">0</span> <span class="unit">Warehouses</span></div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
            <g>
              <path fill="#ffffff" d="M504.484 504.484H7.516V111.72L256 7.516l248.484 104.203zm0 0" data-original="#50b2d2" class="" opacity="1"></path>
              <path fill="#ffffff" d="M504.484 504.484H7.516V111.72L256 7.516l248.484 104.203zm0 0" data-original="#50b2d2" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M301.781 26.71 256 7.517 7.516 111.719v392.765h56.109V127.75zm0 0" data-original="#249fc7" class="" opacity="1"></path>
              <path fill="#ffffff" d="M63.625 191.875h384.75v312.61H63.625zm0 0" data-original="#518bb0" class="" opacity="1"></path>
              <path fill="#ffffff" d="M191.875 376.234h128.25v128.25h-128.25zm0 0" data-original="#ffde7c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M191.875 376.234h24.047v128.25h-24.047zm0 0" data-original="#ffc824" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M239.969 376.234h32.062v48.094H239.97zm0 0" data-original="#ffbd85" class="" opacity="1"></path>
              <path fill="#f0efef" d="M215.922 448.375h48.094v24.047h-48.094zm0 0" data-original="#f0efef" class=""></path>
              <path fill="#ffffff" d="M320.125 376.234h128.25v128.25h-128.25zm0 0" data-original="#ffde7c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M320.125 376.234h24.047v128.25h-24.047zm0 0" data-original="#ffc824" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M368.219 376.234h32.062v48.094H368.22zm0 0" data-original="#ffbd85" class="" opacity="1"></path>
              <path fill="#f0efef" d="M344.172 448.375h48.094v24.047h-48.094zm0 0" data-original="#f0efef" class=""></path>
              <path fill="#ffffff" d="M63.625 376.234h128.25v128.25H63.625zm0 0" data-original="#ffde7c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M63.625 376.234h24.047v128.25H63.625zm0 0" data-original="#ffc824" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M111.719 376.234h32.062v48.094H111.72zm0 0" data-original="#ffbd85" class="" opacity="1"></path>
              <path fill="#f0efef" d="M87.672 448.375h48.094v24.047H87.672zm0 0" data-original="#f0efef" class=""></path>
              <path fill="#ffffff" d="M256 247.984h128.25v128.25H256zm0 0" data-original="#ffde7c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M256 247.984h24.047v128.25H256zm0 0" data-original="#ffc824" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M304.094 247.984h32.062v48.094h-32.062zm0 0" data-original="#ffbd85" class="" opacity="1"></path>
              <path fill="#f0efef" d="M280.047 320.125h48.094v24.047h-48.094zm0 0" data-original="#f0efef" class=""></path>
              <path fill="#ffffff" d="M127.75 247.984H256v128.25H127.75zm0 0" data-original="#ffde7c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M127.75 247.984h24.047v128.25H127.75zm0 0" data-original="#ffc824" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M175.844 247.984h32.062v48.094h-32.062zm0 0" data-original="#ffbd85" class="" opacity="1"></path>
              <path fill="#f0efef" d="M151.797 320.125h48.094v24.047h-48.094zm0 0" data-original="#f0efef" class=""></path>
              <path d="M507.39 104.79 258.907.585a7.5 7.5 0 0 0-5.812 0L4.609 104.789A7.51 7.51 0 0 0 0 111.72v392.765A7.514 7.514 0 0 0 7.516 512h496.968a7.514 7.514 0 0 0 7.516-7.516V111.72a7.51 7.51 0 0 0-4.61-6.93zM71.14 383.75h33.063v40.578a7.516 7.516 0 0 0 7.516 7.516h32.062a7.519 7.519 0 0 0 7.516-7.516V383.75h33.062v113.219H71.141zM183.36 255.5h17.03v33.063h-17.03zm-7.516 48.094h32.062a7.519 7.519 0 0 0 7.516-7.516V255.5h33.062v113.219H135.266V255.5h33.062v40.578a7.516 7.516 0 0 0 7.516 7.516zm87.672-48.094h33.062v40.578a7.519 7.519 0 0 0 7.516 7.516h32.062a7.516 7.516 0 0 0 7.516-7.516V255.5h33.062v113.219H263.516zm48.093 0h17.032v33.063h-17.032zm64.125 128.25h17.032v33.063h-17.032zm-128.25 0h17.032v33.063h-17.032zm-111.218 0v33.063h-17.032V383.75zm63.125 0h33.062v40.578a7.519 7.519 0 0 0 7.516 7.516h32.062a7.519 7.519 0 0 0 7.516-7.516V383.75h33.062v113.219H199.391zm128.25 113.219V383.75h33.062v40.578a7.519 7.519 0 0 0 7.516 7.516h32.062a7.516 7.516 0 0 0 7.516-7.516V383.75h33.062v113.219zm169.328 0H455.89V293.07a7.513 7.513 0 0 0-7.516-7.511 7.515 7.515 0 0 0-7.516 7.511v75.649h-49.093V247.984a7.514 7.514 0 0 0-7.516-7.515h-256.5a7.514 7.514 0 0 0-7.516 7.515V368.72H71.141V199.39h369.718V256a7.516 7.516 0 0 0 15.031 0v-64.125a7.514 7.514 0 0 0-7.515-7.516H63.625a7.514 7.514 0 0 0-7.516 7.516v305.094H15.031V116.715L256 15.665l240.969 101.05zm0 0" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
              <path d="M192.375 87.672a7.515 7.515 0 0 0 7.516 7.512h112.218a7.515 7.515 0 0 0 7.516-7.512 7.516 7.516 0 0 0-7.516-7.516H199.891a7.516 7.516 0 0 0-7.516 7.516zM312.11 112.219H199.89a7.516 7.516 0 0 0-7.515 7.515 7.515 7.515 0 0 0 7.516 7.512h112.218a7.515 7.515 0 0 0 7.516-7.512 7.516 7.516 0 0 0-7.516-7.515zM312.11 144.281H199.89a7.516 7.516 0 0 0 0 15.031h112.22a7.516 7.516 0 0 0 0-15.031zM264.016 440.86h-48.094a7.519 7.519 0 0 0-7.516 7.515v24.047a7.516 7.516 0 0 0 7.516 7.515h48.094a7.516 7.516 0 0 0 7.515-7.515v-24.047a7.519 7.519 0 0 0-7.515-7.516zm-7.516 24.046h-33.063v-9.015H256.5zM392.266 440.86h-48.094a7.519 7.519 0 0 0-7.516 7.515v24.047a7.516 7.516 0 0 0 7.516 7.515h48.094a7.514 7.514 0 0 0 7.515-7.515v-24.047a7.516 7.516 0 0 0-7.515-7.516zm-7.516 24.046h-33.063v-9.015h33.063zM135.766 440.86H87.672a7.516 7.516 0 0 0-7.516 7.515v24.047a7.514 7.514 0 0 0 7.516 7.515h48.094a7.516 7.516 0 0 0 7.515-7.515v-24.047a7.519 7.519 0 0 0-7.515-7.516zm-7.516 24.046H95.187v-9.015h33.063zM280.047 351.688h48.094a7.519 7.519 0 0 0 7.515-7.516v-24.047a7.519 7.519 0 0 0-7.515-7.516h-48.094a7.519 7.519 0 0 0-7.516 7.516v24.047a7.519 7.519 0 0 0 7.516 7.515zm7.515-24.047h33.063v9.015h-33.063zM144.281 320.125v24.047a7.516 7.516 0 0 0 7.516 7.515h48.094a7.519 7.519 0 0 0 7.515-7.515v-24.047a7.519 7.519 0 0 0-7.515-7.516h-48.094a7.516 7.516 0 0 0-7.516 7.516zm15.031 7.516h33.063v9.015h-33.063zm0 0" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
            </g>
          </svg>
        </a>
        <a href="<?= $path . "/inventory.php" ?>" class="widget-bx" style="animation-delay:0.08s" target="_blank">
          <div class="widget-txt">
            <div class="widget-head">Items</div>
            <span class="info">Total Unique Items count</span>
            <div class="widget-value"><span class="w-value" data-value="<?= get_number_unique("av_items") ?>">0</span> <span class="unit">Items</span></div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
            <g>
              <defs>
                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                  <path d="M0 512h512V0H0Z" fill="#ad6420" data-original="#000000" opacity="1"></path>
                </clipPath>
              </defs>
              <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                <path d="M0 0h-166.515a3 3 0 0 0-3 3v212.251a3 3 0 0 0 3 3H0a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(475.868 240.93)" fill="#ffffff" data-original="#eaf6ff" class="" opacity="1"></path>
                <path d="M0 0v212.251a3 3 0 0 0 3 3h-41.646a3 3 0 0 1-3-3V0a3 3 0 0 1 3-3H3a3 3 0 0 0-3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(348 243.93)" fill="#f1ddca" data-original="#d8ecfe" class="" opacity="1"></path>
                <path d="M0 0v109.182a3 3 0 0 1-3 3h-166.516a3 3 0 0 1-3-3v-212.251a3 3 0 0 1 3-3H-3a3 3 0 0 1 3 3V-35" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(478.87 347)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h78.646" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(353.288 406.64)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h78.646" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(353.288 368.918)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h78.646" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(353.288 331.195)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h51.963" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(353.288 293.473)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-155.158v144.062H-3a3 3 0 0 0 3-3z" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(446.084 39.555)" fill="#ffffff" data-original="#fed2a4" class="" opacity="1"></path>
                <path d="M290.926 39.555h33.916v144.062h-33.916z" style="fill-opacity:1;fill-rule:nonzero;stroke:none" fill="#f1ddca" data-original="#ffbd86" class="" opacity="1"></path>
                <path d="M0 0h-155.158v152.617H-3a3 3 0 0 0 3-3z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(446.084 31)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-37.654a3 3 0 0 0-3 3v36.308H3V3a3 3 0 0 0-3-3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(387.332 144.31)" fill="#ffffff" data-original="#fe646f" class="" opacity="1"></path>
                <path d="M0 0v36.308h-16.668V0a3 3 0 0 1 3-3H3a3 3 0 0 0-3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(363.346 147.31)" fill="#f1ddca" data-original="#fd4755" class="" opacity="1"></path>
                <path d="M0 0h-37.654a3 3 0 0 0-3 3v36.308H3V3a3 3 0 0 0-3-3Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(387.332 144.31)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-155.159v141.062a3 3 0 0 0 3 3H-3a3 3 0 0 0 3-3z" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(256 160.283)" fill="#ffffff" data-original="#fed2a4" class="" opacity="1"></path>
                <path d="M0 0h-34a3 3 0 0 1-3-3v-141.062h34V-3a3 3 0 0 0 3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(137.842 304.346)" fill="#f1ddca" data-original="#ffbd86" class="" opacity="1"></path>
                <path d="M0 0v52.346a3 3 0 0 1-3 3h-149.158a3 3 0 0 1-3-3V-88.717H0V-35" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(256 249)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-37.654a3 3 0 0 0-3 3v36.307H3V3a3 3 0 0 0-3-3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(197.248 265.038)" fill="#ffffff" data-original="#fe646f" class="" opacity="1"></path>
                <path d="M0 0v36.308h-16.752V0a3 3 0 0 1 3-3H3a3 3 0 0 0-3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(173.346 268.038)" fill="#f1ddca" data-original="#fd4755" class="" opacity="1"></path>
                <path d="M0 0h-37.654a3 3 0 0 0-3 3v36.307H3V3a3 3 0 0 0-3-3Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(197.248 265.038)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-225.01v141.062a3 3 0 0 0 3 3H0Z" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(290.926 39.555)" fill="#ffffff" data-original="#f6a96c" class="" opacity="1"></path>
                <path d="M0 0h-33.084a3 3 0 0 1-3-3v-141.062H-3V-3a3 3 0 0 0 3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(102 183.617)" fill="#f1ddca" data-original="#ea9b58" class="" opacity="1"></path>
                <path d="M0 0h-225.01v141.062a3 3 0 0 0 3 3H0Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(290.926 39.555)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-42.65a3 3 0 0 0-3 3v36.308H3V3a3 3 0 0 0-3-3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(199.746 144.31)" fill="#ffffff" data-original="#fe646f" class="" opacity="1"></path>
                <path d="M0 0v36.308h-16.904V0a3 3 0 0 1 3-3H3a3 3 0 0 0-3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(171 147.31)" fill="#f1ddca" data-original="#fd4755" class="" opacity="1"></path>
                <path d="M0 0h-42.65a3 3 0 0 0-3 3v36.308H3V3a3 3 0 0 0-3-3Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(199.746 144.31)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0h-479.91a3 3 0 0 0-3 3v31.5a3 3 0 0 0 3 3H0a3 3 0 0 0 3-3V3a3 3 0 0 0-3-3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(495.955 7.5)" fill="#ffffff" data-original="#fac600" class="" opacity="1"></path>
                <path d="M0 0v31.5a3 3 0 0 0 3 3h-47.045a3 3 0 0 1-3-3V0a3 3 0 0 1 3-3H3a3 3 0 0 0-3 3" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(60.09 10.5)" fill="#f1ddca" data-original="#e8b801" class="" opacity="1"></path>
                <path d="M0 0h-364.955a3 3 0 0 1-3-3v-31.5a3 3 0 0 1 3-3h479.91a3 3 0 0 1 3 3V-3a3 3 0 0 1-3 3H35" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(381 45)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="M0 0c0-32.677-26.489-59.165-59.165-59.165S-118.33-32.677-118.33 0c0 32.676 26.489 59.165 59.165 59.165S0 32.676 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(373.071 445.335)" fill="#ffffff" data-original="#4fc123" class="" opacity="1"></path>
                <path d="M0 0c0 26.778 17.795 49.39 42.201 56.684a59.163 59.163 0 0 1-16.965 2.481C-7.439 59.165-33.929 32.676-33.929 0c0-32.677 26.49-59.165 59.165-59.165 5.899 0 11.589.874 16.965 2.48C17.795-49.39 0-26.778 0 0" style="fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(288.67 445.335)" fill="#f1ddca" data-original="#47a920" class="" opacity="1"></path>
                <path d="M0 0c0-32.677-26.489-59.165-59.165-59.165S-118.33-32.677-118.33 0c0 32.676 26.489 59.165 59.165 59.165S0 32.676 0 0Z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(373.071 445.335)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
                <path d="m0 0 22.982-22.982 30.5 30.499" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1" transform="translate(287.165 451.587)" fill="none" stroke="#ad6420" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity="" data-original="#000000" class="" opacity="1"></path>
              </g>
            </g>
          </svg>
        </a>
        <a href="<?= $path . "/creturns.php" ?>" class="widget-bx" style="animation-delay:0.16s" target="_blank">
          <div class="widget-txt">
            <div class="widget-head">Customer Returns</div>
            <span class="info">Total Customer Returns count</span>
            <div class="widget-value"><span class="w-value" data-value="0">0</span> <span class="unit">Returns</span></div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 511" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
            <g>
              <path fill="#f1ddca" d="M103.191 338.984 302.594 448.48 502 338.984V119.996L302.594 10.5 103.19 119.996zm0 0" data-original="#ffc15a" class="" opacity="1"></path>
              <path fill="#ffffff" d="M502 120.063v218.921L302.594 448.48l-.117-.066V229.492l199.406-109.496zm0 0" data-original="#ffcb7c" class="" opacity="1"></path>
              <path fill="#ffffff" d="M502 119.996V120L302.594 229.496 103.19 120v-.004L302.594 10.5zm0 0" data-original="#ffe6c0" class="" opacity="1"></path>
              <path fill="#ffffff" d="m182.418 76.531 199.406 109.496 42.73-23.863L225.149 52.672zm0 0" data-original="#ffffff" class=""></path>
              <path fill="#ffffff" d="M381.824 186.027v68.387l42.73-23.516v-68.734zm0 0" data-original="#ffffff" class=""></path>
              <path fill="#ffffff" d="M256.137 379.418c0 67.965-55.094 123.059-123.055 123.059-67.965 0-123.059-55.094-123.059-123.059 0-67.961 55.094-123.055 123.059-123.055 67.961 0 123.055 55.094 123.055 123.055zm0 0" data-original="#91def5" class="" opacity="1"></path>
              <path d="M506.813 111.23 307.405 1.734a10.005 10.005 0 0 0-9.625 0l-75.16 41.27a10.029 10.029 0 0 0-4.293 2.36L98.378 111.23a9.994 9.994 0 0 0-5.187 8.766v132.43c-20.234 6.328-38.777 17.488-54.195 32.91C-1.19 325.52-11.438 386.809 13.5 437.844c2.422 4.96 8.41 7.02 13.371 4.594 4.965-2.426 7.02-8.415 4.598-13.375-21.188-43.364-12.48-95.438 21.668-129.586 21.355-21.356 49.746-33.118 79.945-33.118s58.59 11.762 79.945 33.118c21.352 21.351 33.114 49.742 33.114 79.941s-11.762 58.59-33.118 79.945c-34.148 34.149-86.222 42.856-129.585 21.668-4.961-2.426-10.95-.367-13.372 4.594-2.425 4.965-.37 10.953 4.594 13.375a132.667 132.667 0 0 0 58.336 13.5c34.543-.004 68.625-13.45 94.172-38.996 11.715-11.715 20.973-25.23 27.523-39.922l43.09 23.66c1.5.824 3.156 1.235 4.813 1.235s3.316-.41 4.812-1.235L506.812 347.75a10.003 10.003 0 0 0 5.188-8.766v-69.496c0-5.523-4.477-10-10-10s-10 4.477-10 10v63.578l-179.375 98.497V235.39l59.2-32.508v51.531a9.996 9.996 0 0 0 10 10c1.655 0 3.316-.41 4.82-1.238l42.73-23.52a9.992 9.992 0 0 0 5.176-8.758v-62.46L492 136.895v52.597c0 5.524 4.477 10 10 10s10-4.476 10-10v-69.496a9.998 9.998 0 0 0-5.188-8.766zm-204.22-89.324 178.63 98.09-56.348 30.942-178.629-98.09zm0 196.176-178.628-98.086 58.414-32.078 178.633 98.086zm79.192-43.484L203.156 76.512l22.313-12.254 178.633 98.086zM227.168 285.336c-25.133-25.133-58.547-38.973-94.086-38.973-6.723 0-13.363.496-19.89 1.469V136.895l179.437 98.53v196.173l-31.145-17.102c3.067-11.289 4.653-23.062 4.653-35.078 0-35.54-13.84-68.953-38.969-94.082zm187.387-60.348-22.73 12.512v-45.598l22.73-12.48zm0 0" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
              <path d="M502 219.441a10.08 10.08 0 0 0-7.07 2.93 10.073 10.073 0 0 0-2.93 7.07 10.07 10.07 0 0 0 2.93 7.067c1.86 1.863 4.441 2.93 7.07 2.93s5.21-1.067 7.07-2.93a10.07 10.07 0 0 0 2.93-7.067c0-2.632-1.07-5.21-2.93-7.07a10.08 10.08 0 0 0-7.07-2.93zM99.457 389.418a9.973 9.973 0 0 0 7.07-2.926c3.907-3.906 3.907-10.238 0-14.144l-6.925-6.93h59.101c14.336 0 26 11.664 26 26s-11.664 26-26 26h-35.02c-5.523 0-10 4.477-10 10 0 5.52 4.477 9.996 10 9.996h35.02c25.363 0 46-20.633 46-45.996s-20.637-45.996-46-45.996H99.602l6.925-6.93c3.907-3.906 3.907-10.238 0-14.144-3.902-3.903-10.234-3.903-14.14 0l-24 24c-3.903 3.906-3.903 10.238 0 14.144l24 23.996a9.968 9.968 0 0 0 7.07 2.93zM46.074 476.45a9.953 9.953 0 0 1-7.64-3.56l-.02-.023c-3.555-4.226-3.008-10.531 1.219-14.086 4.226-3.558 10.535-3.011 14.09 1.215 3.55 4.23 3.015 10.547-1.211 14.102a9.979 9.979 0 0 1-6.438 2.351zm0 0" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
            </g>
          </svg>
        </a>
        <a href="<?= $path . "/sreturns.php" ?>" class="widget-bx" style="animation-delay:0.16s" target="_blank">
          <div class="widget-txt">
            <div class="widget-head">Supplier Returns</div>
            <span class="info">Total Supplier Returns count</span>
            <div class="widget-value"><span class="w-value" data-value="0">0</span> <span class="unit">Returns</span></div>
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
            <g>
              <path fill="#ffffff" d="M256 120.38c32.02 0 58.106-26.086 58.106-58.078 0-32.02-26.086-58.106-58.106-58.106-31.992 0-58.078 26.086-58.078 58.106 0 31.992 26.086 58.078 58.078 58.078z" data-original="#f6dccd" class="" opacity="1"></path>
              <path fill="#ffffff" d="M209.962 137.923h92.076c36.32 0 66.019 29.727 66.019 66.019v50.797c0 11.953-9.775 21.729-21.729 21.729H165.701c-11.953 0-21.729-9.775-21.729-21.729v-50.797c0-36.292 29.698-66.019 65.99-66.019z" data-original="#00d3b3" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M182.328 207.21c0-2.867 2.35-5.217 5.217-5.217s5.189 2.35 5.189 5.217v69.258h-10.406zm147.344 69.257h-10.377V207.21c0-2.867 2.322-5.217 5.189-5.217s5.189 2.35 5.189 5.217v69.258h-.001z" data-original="#00a585" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M209.962 137.923h92.076c36.32 0 66.019 29.727 66.019 66.019v50.797c0 8.456-4.931 15.853-12.04 19.436 2.494-3.555 3.956-7.855 3.956-12.47v-50.797c0-36.32-29.698-66.019-65.99-66.019h-92.076c-14.505 0-27.921 4.73-38.842 12.728 11.982-12.126 28.608-19.694 46.897-19.694z" data-original="#00a585" class="" opacity="1"></path>
              <path fill="#f1ddca" d="m265.833 166.447 16.483 71.895L256 266.894l-26.287-28.552 16.454-71.895z" data-original="#505050" class="" opacity="1"></path>
              <path fill="#f1ddca" d="m265.833 167.421 5.675-29.498H240.52l5.647 29.498z" data-original="#3c3c3c" class="" opacity="1"></path>
              <path fill="#ad6420" d="M240.52 137.923h30.988l-1.347 6.966h-28.294z" data-original="#232323" class="" opacity="1"></path>
              <path fill="#f1cbbc" d="M250.066 4.511c29.297 2.953 52.144 27.692 52.144 57.791 0 30.071-22.847 54.81-52.144 57.791 1.95.2 3.927.286 5.934.286 32.106 0 58.106-26 58.106-58.078 0-32.106-26-58.106-58.106-58.106-2.006 0-3.984.114-5.934.316z" data-original="#f1cbbc" class=""></path>
              <path fill="#ffffff" d="M194.539 384.884h122.922v122.922H194.539z" data-original="#ffc06c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M274.261 437.515v-52.631h-36.522v52.631L256 423.583z" data-original="#ff4c4c" class="" opacity="1"></path>
              <path fill="#ffffff" d="M23 384.884h122.922v122.922H23z" data-original="#ffc06c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M102.722 437.515v-52.631H66.2v52.631l18.261-13.932z" data-original="#ff4c4c" class="" opacity="1"></path>
              <path fill="#ffffff" d="M366.078 384.884H489v122.922H366.078z" data-original="#ffc06c" class="" opacity="1"></path>
              <path fill="#f1ddca" d="M445.828 437.515v-52.631h-36.549v52.631l18.26-13.932z" data-original="#ff4c4c" class="" opacity="1"></path>
              <g fill="#eda558">
                <path d="M129.266 385.2h16.655v122.606h-16.655zM300.834 385.2h16.627v122.606h-16.627zM472.373 385.2H489v122.606h-16.627z" fill="#f1ddca" data-original="#eda558" class="" opacity="1"></path>
              </g>
              <path d="M255.985 128.872c35.538 0 64.45-28.912 64.45-64.451C320.435 28.899 291.523 0 255.985 0c-35.522 0-64.421 28.899-64.421 64.421 0 35.539 28.899 64.451 64.421 64.451zm0-114.896c27.831 0 50.474 22.629 50.474 50.446 0 27.832-22.643 50.475-50.474 50.475-27.816 0-50.446-22.643-50.446-50.475.001-27.817 22.63-50.446 50.446-50.446zm117.802 240.749v-50.233c0-39.837-32.409-72.246-72.246-72.246h-91.083c-39.837 0-72.246 32.409-72.246 72.246v50.233c0 15.701 12.774 28.476 28.477 28.476h178.623c15.701-.001 28.475-12.775 28.475-28.476zM262.864 146.221l-2.918 15.194h-7.892l-2.919-15.194zm-67.587 123.004V211.38c0-3.86-3.128-6.988-6.988-6.988s-6.988 3.128-6.988 6.988v57.845h-14.613c-7.996 0-14.501-6.504-14.501-14.5v-50.233c0-32.13 26.14-58.271 58.271-58.271h24.445l4.134 21.517-15.858 69.211a6.984 6.984 0 0 0 1.668 6.291l23.899 25.984h-53.469zm42.346-32.739 13.999-61.095h8.757l13.998 61.092-18.388 19.97zm122.189 18.239c0 7.996-6.505 14.5-14.501 14.5h-14.613V211.38c0-3.86-3.128-6.988-6.988-6.988s-6.988 3.128-6.988 6.988v57.845h-53.495l23.924-25.981a6.986 6.986 0 0 0 1.67-6.294l-15.858-69.211 4.132-21.517h24.446c32.13 0 58.271 26.14 58.271 58.271zm-43.048 121.742H195.207a6.987 6.987 0 0 0-6.988 6.988v121.557a6.987 6.987 0 0 0 6.988 6.988h121.557a6.987 6.987 0 0 0 6.988-6.988V383.455a6.987 6.987 0 0 0-6.988-6.988zm-71.849 13.976h22.169v30.924l-6.864-5.229a6.992 6.992 0 0 0-8.473.003l-6.832 5.212zm64.861 107.581H202.195V390.443h28.745v45.031a6.988 6.988 0 0 0 11.226 5.556l13.822-10.547 13.849 10.55a6.987 6.987 0 0 0 11.223-5.559v-45.031h28.717v107.581zM147.127 376.467H25.57a6.987 6.987 0 0 0-6.988 6.988v121.557A6.987 6.987 0 0 0 25.57 512h121.557a6.987 6.987 0 0 0 6.988-6.988V383.455a6.987 6.987 0 0 0-6.988-6.988zm-71.848 13.976h22.14v30.91l-6.832-5.212a6.993 6.993 0 0 0-8.477 0l-6.832 5.212v-30.91zm64.861 107.581H32.558V390.443h28.745v45.031a6.988 6.988 0 0 0 11.226 5.556l13.819-10.544 13.819 10.544a6.993 6.993 0 0 0 7.338.707 6.988 6.988 0 0 0 3.889-6.263v-45.031h28.745v107.581zm346.29-121.557H364.843a6.987 6.987 0 0 0-6.988 6.988v121.557a6.987 6.987 0 0 0 6.988 6.988H486.43a6.987 6.987 0 0 0 6.988-6.988V383.455a6.987 6.987 0 0 0-6.988-6.988zm-71.877 13.976h22.168v30.91l-6.832-5.212a6.992 6.992 0 0 0-8.473-.003l-6.863 5.228zm64.889 107.581H371.831V390.443h28.746v45.031a6.99 6.99 0 0 0 11.223 5.559l13.848-10.55 13.822 10.547a6.988 6.988 0 0 0 11.226-5.556v-45.031h28.746zM248.998 365v-49.522l-15.145 15.144a6.984 6.984 0 0 1-9.882 0 6.986 6.986 0 0 1 0-9.882l27.073-27.073a6.987 6.987 0 0 1 9.88-.003l27.1 27.073a6.988 6.988 0 0 1-4.939 11.932 6.968 6.968 0 0 1-4.939-2.044l-15.174-15.159V365a6.987 6.987 0 1 1-13.974 0zm105.563-21.615a6.987 6.987 0 0 1-6.905-8.117l6.18-37.789c.622-3.809 4.219-6.396 8.023-5.768l37.817 6.18a6.986 6.986 0 1 1-2.254 13.792l-20.568-3.361 39.426 51.315a6.99 6.99 0 0 1-5.536 11.245c-2.097 0-4.17-.94-5.546-2.731l-40.201-52.323-3.549 21.696a6.988 6.988 0 0 1-6.887 5.861zm-190.22-8.122a6.987 6.987 0 0 1-6.904 8.122 6.988 6.988 0 0 1-6.886-5.856l-3.563-21.684-40.218 52.308a6.974 6.974 0 0 1-5.544 2.729 6.987 6.987 0 0 1-5.534-11.247l39.455-51.316-20.57 3.364c-3.805.627-7.4-1.958-8.024-5.768a6.987 6.987 0 0 1 5.768-8.024l37.789-6.18a6.983 6.983 0 0 1 8.023 5.763z" fill="#ad6420" data-original="#000000" class="" opacity="1"></path>
            </g>
          </svg>
        </a>
      </div>
    </div>
    <!-- <div class="quick-section">
      <h4 class="quick">shortcuts</h4>
      <div class="quick-btns">
        <button class="quick">
          <i class="fa-solid fa-plus"></i>
          Add Customer
        </button>
        <button class="quick supp_btn">
          <i class="fa-solid fa-plus"></i>
          Add Supplier
        </button>
        <button class="quick manu_btn">
          <i class="fa-solid fa-plus"></i>
          Add Manufacturer
        </button>
        <button class="quick">
          <i class="fa-solid fa-plus"></i>
          Add Employee
        </button>

      </div>
    </div>
    <h4 class="quick">Widgets</h4>
    <div class="home-dis">

      <div class="home-section">
        <div class="home-box emp-home-box">
          <div class="head-section">
            <span class="head">Last 10 Customers</span>
            <a href="<?= $path . "/customers.php" ?>" target="_blank">View all</a>
          </div>
          <ul class="emp-sum heading">
            <li>
              <a href="">
                <div>Customer</div>
                <div>Phone</div>
                <div>City</div>
                <div>Email</div>
                <div>Created Date</div>
              </a>
            </li>
          </ul>

          <div class="body-section emo">
            <ul class="emp-sum">
              <?= last_10_customers() ?>
            </ul>
          </div>
        </div>
        <div class="home-box">
          <div class="head-section">
            <span class="head">Monthly Orders</span>
            <span class="head"><?= $y ?></span>
          </div>
          <div class="body-section">
            <div class="canvas-container">
              <div class="y_title">Count</div>
              <div class="x_title">Month</div>
              <canvas id="myChart2"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="home-section">
        <div class="home-box">
          <div class="head-section">
            <span class="head">Daily Customers</span>
            <span class="head"><?= date('M', mktime(0, 0, 0, $m, 1)) . " " . $y ?></span>
          </div>
          <div class="body-section">
            <div class="canvas-container">
              <div class="y_title">Count</div>
              <div class="x_title">Days</div>
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
        <div class="home-box trans-box">
          <div class="head-section">
            <span class="head">Live Users</span>
            <span class="head count_online">0 Online</span>
          </div>
          <div class="body-section emo users-list">
            <ul class="emp-sum" id="online_list">

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="black_screen"></div>
    <div class="add_new" id="add_supplier_modal">
      <div class="custome-head">
        <h3>New Supplier</h3>
        <button class="close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form class="" id="new_supplier" action="" method="POST">
        <div class="custom-form">
          <div class="sectra">
            <span class="sm-head">Contact info</span>
            <span class="ask">
              <label for="ask">Display as a Company ?</label>
              <input type="checkbox" name="type" value="1" id="ask">
            </span>
            <span class="ask">
              <label for="ask">Active ?</label>
              <input type="checkbox" name="status" value="1" checked>
            </span>
            <div class="form-section">
              <div class="inputs gd2">
                <label for="fname">First Name</label>
                <input type="text" value="" class="" name="fname" id="fname" required>
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="mname">Middle Name</label>
                <input type="text" value="" class="" name="mname" id="mname">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="lname">Last Name</label>
                <input type="text" value="" class="" name="lname" id="lname">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="company">Company</label>
                <input type="text" value="" class="" name="cname" id="company">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="phone">Phone Number</label>
                <input type="number" value="" class="" name="phone" id="phone" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="mobile">Mobile</label>
                <input type="number" value="" class="" name="mobile" id="mobile" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="fax">Fax</label>
                <input type="number" value="" class="" name="fax" id="fax" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="email">Email Address</label>
                <input type="text" value="" class="" name="email" id="email">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="website">Website</label>
                <input type="text" value="" class="" name="website" id="website">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="other">Other</label>
                <input type="text" value="" class="" name="other" id="other">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="note">Notes</label>
                <textarea name="notes" id="note" cols="30" rows="10"></textarea>
                <span class="error-field"></span>
              </div>
            </div>
          </div>
          <div class="sectra">
            <span class="sm-head">Address</span>
            <div class="form-section">
              <div class="inputs gd6">
                <label for="street">Street</label>
                <textarea name="street" id="street" cols="30" rows="10"></textarea>
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="city">City/Town</label>
                <input type="text" id="city" value="" class="" name="city">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="state">State</label>
                <input type="text" id="state" value="" class="" name="state">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="postal">Postal Code</label>
                <input type="number" value="" class="" name="postal" id="postal" min="0">
                <span class=" error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="country">Country</label>
                <?php $mycountry = ip_info($_SERVER['REMOTE_ADDR'], "Country"); ?>
                <select name="country" id="country" class='<?php if ($errors['country'] !== "") {
                                                              echo " error_field";
                                                            } ?>' required>
                  <?php
                  $countries = countries();
                  foreach ($countries as $key => $country) {
                    echo "<option value='$country'";
                    if (isset($_POST['country']) && $_POST['country'] == $country) {
                      echo "selected";
                    } elseif ($country == $mycountry) {
                      echo "selected";
                    }
                    echo ">$country</option>";
                  }
                  ?>
                </select>
                <span class="error-field"></span>
              </div>
            </div>
            <span class="sm-head">Payment and Billing</span>
            <div class="form-section">
              <div class="inputs gd6">
                <label for="acc_num">Account no.</label>
                <input type="text" id="acc_num" value="" class="" name="acc_num" placeholder="Appears in the memo of all payments">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="taxid">Tax Reg ID.</label>
                <input type="text" id="taxid" value="" class="" name="taxid">
                <span class="error-field"></span>
              </div>
            </div>
          </div>
        </div>
        <hr class="hr_form">
        <div class="loadings"><i class=""></i></div>
        <input type="hidden" name="add" value="Save">
        <input type="submit" class="add" value="Save">
      </form>
    </div>
    <div class="add_new" id="add_manu_modal">
      <div class="custome-head">
        <h3>New Manufacturer</h3>
        <button class="close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form class="" id="new_manu" action="" method="POST">
        <div class="custom-form">
          <div class="sectra">
            <span class="sm-head">Contact info</span>
            <span class="ask">
              <label for="ask">Display as a Company ?</label>
              <input type="checkbox" name="type" value="1" id="ask">
            </span>
            <span class="ask">
              <label for="ask">Active ?</label>
              <input type="checkbox" name="status" value="1" checked>
            </span>
            <div class="form-section">
              <div class="inputs gd2">
                <label for="fname">First Name</label>
                <input type="text" value="" class="" name="fname" id="fname" required>
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="mname">Middle Name</label>
                <input type="text" value="" class="" name="mname" id="mname">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="lname">Last Name</label>
                <input type="text" value="" class="" name="lname" id="lname">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="company">Company</label>
                <input type="text" value="" class="" name="cname" id="company">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="phone">Phone Number</label>
                <input type="number" value="" class="" name="phone" id="phone" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="mobile">Mobile</label>
                <input type="number" value="" class="" name="mobile" id="mobile" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="fax">Fax</label>
                <input type="number" value="" class="" name="fax" id="fax" min="0" max="1999999999">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="email">Email Address</label>
                <input type="text" value="" class="" name="email" id="email">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="website">Website</label>
                <input type="text" value="" class="" name="website" id="website">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd2">
                <label for="other">Other</label>
                <input type="text" value="" class="" name="other" id="other">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="note">Notes</label>
                <textarea name="notes" id="note" cols="30" rows="10"></textarea>
                <span class="error-field"></span>
              </div>
            </div>
          </div>
          <div class="sectra">
            <span class="sm-head">Address</span>
            <div class="form-section">
              <div class="inputs gd6">
                <label for="street">Street</label>
                <textarea name="street" id="street" cols="30" rows="10"></textarea>
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="city">City/Town</label>
                <input type="text" id="city" value="" class="" name="city">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="state">State</label>
                <input type="text" id="state" value="" class="" name="state">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="postal">Postal Code</label>
                <input type="number" value="" class="" name="postal" id="postal" min="0">
                <span class=" error-field"></span>
              </div>
              <div class="inputs gd3">
                <label for="country">Country</label>
                <?php $mycountry = ip_info($_SERVER['REMOTE_ADDR'], "Country"); ?>
                <select name="country" id="country" class='<?php if ($errors['country'] !== "") {
                                                              echo " error_field";
                                                            } ?>' required>
                  <?php
                  $countries = countries();
                  foreach ($countries as $key => $country) {
                    echo "<option value='$country'";
                    if (isset($_POST['country']) && $_POST['country'] == $country) {
                      echo "selected";
                    } elseif ($country == $mycountry) {
                      echo "selected";
                    }
                    echo ">$country</option>";
                  }
                  ?>
                </select>
                <span class="error-field"></span>
              </div>
            </div>
            <span class="sm-head">Payment and Billing</span>
            <div class="form-section">
              <div class="inputs gd6">
                <label for="acc_num">Account no.</label>
                <input type="text" id="acc_num" value="" class="" name="acc_num" placeholder="Appears in the memo of all payments">
                <span class="error-field"></span>
              </div>
              <div class="inputs gd6">
                <label for="taxid">Tax Reg ID.</label>
                <input type="text" id="taxid" value="" class="" name="taxid">
                <span class="error-field"></span>
              </div>
            </div>
          </div>
        </div>
        <hr class="hr_form">
        <div class="loadings"><i class=""></i></div>
        <input type="hidden" name="add" value="Save">
        <input type="submit" class="add" value="Save">
      </form>
    </div>
    <div class="mga"></div> -->
  </div>
  <script>
    $(document).ready(function() {

      // Widget Value Counter Up Funcion 
      let valueDisplays = document.querySelectorAll(".w-value");
      let totalDuration = 3000; // Total duration for all elements
      let duration = Math.floor(totalDuration / valueDisplays.length); // Duration for each element
      let startTimestamp = null;

      function step(timestamp) {
        if (!startTimestamp) startTimestamp = timestamp;
        let progress = timestamp - startTimestamp;

        valueDisplays.forEach((valueDisplay) => {
          let startValue = 0;
          let endValue = parseInt(valueDisplay.getAttribute("data-value"));
          let currentValue = Math.floor((progress / duration) * (endValue + 1)); // Calculate the current value based on the progress and duration

          if (currentValue > endValue) {
            currentValue = endValue;
          }

          valueDisplay.textContent = currentValue;
        });

        if (progress < totalDuration) {
          window.requestAnimationFrame(step);
        }
      }

      window.requestAnimationFrame(step);




      function onlineUsers() {
        $.ajax({
          url: 'json/active_user.php',
          type: 'POST',
          dataType: 'json',
          success: function(data2) {
            $("#online_list li").remove();
            let i = 0;
            $.each(data2, function(index, value) {
              var objectString = '';
              $.each(value, function(key, val) {
                objectString += key + ': ' + val + ', ';
              });
              i += 0.2;
              $(".count_online").html(value.count + " Online");
              $('#online_list').append('<li style="animation-delay:' + i + 's"><a href="<?= $path ?>/employeedetails.php?uid=' + value.id + '" target="_blank"><div><div class="img-prof"><img src="../images/ur-img/' + value.img + '" alt=""></div><div class="name">' + value.name + '<span>' + value.role + '</span></div></div><div> <span class="circle_gn"></span> Online</div></a></li>');
            });
          },
          error: function(xhr, status, error) {
            // Handle any errors that occur during the AJAX request
            console.log(xhr.responseText);
          }
        });
      }
      onlineUsers();
      setInterval(onlineUsers, 20000);







      function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
      }
      const result = daysInMonth(<?= $m ?>, <?= $y ?>);
      const labels = [];
      for (let i = 1; i <= result; i++) {
        labels.push(i);
      }

      const chartData = {
        labels: labels,
        datasets: [{
          fill: {
            target: 'origin',
            above: 'rgb(249 235 222 / 32%)',
          },
          tension: 0.2,
          type: "bar",
          label: "Customers",
          data: <?= chart_customers() ?>,
          backgroundColor: 'rgb(249 235 222 / 32%)',
          borderColor: '#ad6420',
          pointBorderWidth: 3,
          hoverBackgroundColor: '#ad6420',
          hoverBorderColor: '#ad6420',
          borderWidth: 1,
          borderRadius: 10,
        }]
      };

      const config = {
        type: 'bar',
        data: chartData,
        options: {
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                borderColor: 'transparent',
                color: (context) => {
                  const zeroline = context.tick.value;
                  const barcolor = zeroline === 0 ? '#ababab' : '#dcdcdc'
                  return barcolor;
                },

              },
              ticks: {
                color: "#ad6420"
              }
            },
            x: {
              grid: {
                color: 'transparent',
                borderColor: 'transparent',
              },
              ticks: {
                color: "#ad6420",

              }
            }

          },
          plugins: {
            legend: {
              display: true,
              position: "top",
              align: "end",
              labels: {
                color: '#ad6420'
              }
            },
            tooltip: {
              bodyColor: "#fff",
              titleColor: "#fff",
              backgroundColor: "#ad6420",
              displayColors: false,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  label += " : " + context.parsed.y;
                  return label;
                },
                title: function(context) {
                  return "Day " + context[0].label;
                },
              },
              mode: 'index',
              intersect: false,
            }
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          responsive: true,
          maintainAspectRatio: false,


        },

      };
      var myChart = new Chart(
        document.getElementById('myChart'),
        config
      );









































      const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
      ];


      const chartData2 = {
        labels: months,
        datasets: [{
          fill: {
            target: 'origin',
            above: 'rgb(249 235 222 / 32%)',
          },
          type: "line",
          label: "Purchase Orders",
          data: <?= chart_purchase_orders() ?>,
          backgroundColor: 'rgb(249 235 222 / 32%)',
          borderColor: 'rgb(249 235 222 / 100%)',
          pointBorderWidth: 6,
          hoverBackgroundColor: 'rgb(249 235 222 / 32%)',
          hoverBorderColor: 'rgb(249 235 222 / 32%)',
          borderWidth: 1,
          borderRadius: 10,
        }, {
          fill: {
            target: 'origin',
            above: 'rgb(185 102 24 / 32%)',
          },
          type: "line",
          label: "Manufacturing Orders",
          data: <?= chart_manufacturing_orders() ?>,
          backgroundColor: 'rgb(185 102 24 / 32%)',
          borderColor: 'rgb(185 102 24 / 100%)',
          pointBorderWidth: 6,
          hoverBackgroundColor: 'rgb(185 102 24 / 32%)',
          hoverBorderColor: 'rgb(185 102 24 / 32%)',
          borderWidth: 1,
          borderRadius: 10,
        }]
      };

      const config2 = {
        type: 'line',
        data: chartData2,
        options: {

          scales: {
            y: {
              beginAtZero: true,
              grid: {
                borderColor: 'transparent',
                color: (context) => {
                  const zeroline = context.tick.value;
                  const barcolor = zeroline === 0 ? '#ababab' : '#dcdcdc'
                  return barcolor;
                },

              },
              ticks: {
                color: "#ad6420"
              }
            },
            x: {
              grid: {
                color: 'transparent',
                borderColor: 'transparent',
              },
              ticks: {
                color: "#ad6420",

              }
            }

          },
          plugins: {
            legend: {
              display: true,
              position: "top",
              align: "end",
              labels: {
                color: '#ad6420'
              }
            },
            tooltip: {
              bodyColor: "#fff",
              titleColor: "#fff",
              backgroundColor: "#ad6420",
              displayColors: false,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  label += " : " + context.parsed.y;
                  return label;
                },
                title: function(context) {
                  return context[0].label;
                },
              },
              mode: 'index',
              intersect: false,
            }
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          responsive: true,
          maintainAspectRatio: false,



        }
      };
      var myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
      );

      $("button.supp_btn").click(function() {
        var exportHeight = $("#add_supplier_modal").prop("scrollHeight") + 70;
        $("#add_supplier_modal").css({
          height: exportHeight + "px",
          padding: "20px 25px",
          border: "1px solid #cfcfcf",
        });
        $(".black_screen").fadeIn(200);
      });

      $('#new_supplier').submit(function(event) {
        event.preventDefault(); // prevent default form submission
        $.ajax({
          type: 'POST',
          url: 'functions/core/add-supplier.php',
          data: $(this).serialize(),
          success: function(data) {
            $(".black_screen").fadeOut(200);
            $(".add_new").css({
              "height": '0px',
              "padding": "0px",
              "border": "0px solid #cfcfcf"
            });
            $(".mga").html(data);
            setTimeout(function() {
              location.reload();
            }, 1000);
          },
        });
        $(this)[0].reset();
      });




      $("button.manu_btn").click(function() {
        var exportHeight = $("#add_manu_modal").prop("scrollHeight") + 70;
        $("#add_manu_modal").css({
          height: exportHeight + "px",
          padding: "20px 25px",
          border: "1px solid #cfcfcf",
        });
        $(".black_screen").fadeIn(200);
      });

      $('#new_manu').submit(function(event) {
        event.preventDefault(); // prevent default form submission
        $.ajax({
          type: 'POST',
          url: 'functions/core/add-manufacturer.php',
          data: $(this).serialize(),
          success: function(data) {
            $(".black_screen").fadeOut(200);
            $(".add_new").css({
              "height": '0px',
              "padding": "0px",
              "border": "0px solid #cfcfcf"
            });
            $(".mga").html(data);
            setTimeout(function() {
              location.reload();
            }, 1000);
          },
        });
        $(this)[0].reset();
      });
    });
  </script>

<?php
} else {

  header("location:" . $path . "/../login.php");
  exit();
}
include "includes/footer.inc";
?>