<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//FR">
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/styles.css" />
  <link rel="icon" href="https://www.aht.li/3715850/SM_icon.ico" />
  <title>Email Template</title>


  <style type="text/css" media="screen">
    * {
      margin: 0px;
      padding: 0px;
      font-family: Montserrat, sans-serif;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    html body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: (white);
    }

    .site-content {
      flex: 1;
    }

    .container {
      width: 100%;
      margin: 0px;
      padding: 0;
      padding-top: 0px;
      padding-right: 0px;
      padding-bottom: 0px;
      padding-left: 0px;
    }

    div.tunnel-header {
      overflow: hidden;
      overflow-x: hidden;
      overflow-y: hidden;
      height: 320px;
      background-image: url("https://www.aht.li/3715849/shootmania_banniere.png");
      background-position: center;
      background-repeat: no-repeat;
      display: table;
      width: 100%;
    }

    div.tunnel-header #logo img {
      /* si on veut ajouter un logo */
      float: left;
      width: 120px;
      height: 35px;
    }

    .secure .main {
      padding-top: 80px;
    }

    body .main {
      padding-top: 125px;
    }

    .identification {
      width: 100%;
      max-width: 700px;
      margin: 0 auto;
      min-height: 500px;
    }

    .main {
      padding-left: 20px;
      padding-right: 20px;
      width: 100%;
      padding-top: 140px;
    }

    .empty-cart,
    .identification .change-password-form .form-group.genders,
    .identification .identification-form .form-group.genders,
    .identification .title-1,
    .identification .title-2,
    .identification .title-3 {

      text-align: center;

    }

    .title-1,
    .title-2,
    .title-3,
    h1,
    h2,
    h3 {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .title-1,
    h1 {
      font-size: 26px;
      color: #969696;
      text-transform: uppercase;
      line-height: 26px;
    }

    .title-3,
    h3 {
      font-size: 22px;
    }

    .title-2,
    .title-3,
    h2,
    h3 {
      color: #505050;
      text-transform: uppercase;
      font-weight: 400;
    }

    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    header,
    menu,
    nav,
    section {
      display: block;
    }

    .breadcrumb>ul>li strong,
    .title-1,
    h1,
    strong {
      font-weight: 600;
    }

    .identification .change-password-form,
    .identification .identification-form {
      max-width: 500px;
      margin-bottom: 30px;
      padding: 25px 0;
      margin-left: auto;
      margin-right: auto;
      text-align: center;
    }

    .sbloc,
    .shipping-point-choice .shipping-point-list ul {
      margin: 0 0 22px;
      margin-right: 0px;
      margin-bottom: 22px;
      margin-left: 0px;
      display: block;
      width: auto;
      padding: 15px 20px;
      max-width: none;
    }

    .sbloc,
    .shipping-point-choice .shipping-point-list ul {
      position: relative;
      display: table;
      width: 100%;
      max-width: 1210px;
      margin: 0 auto 22px;
      padding: 22px;
      background: #FFF;
    }

    .sbloc .title-1,
    .sbloc .title-2,
    .sbloc .title-3,
    .shipping-point-choice .shipping-point-list ul .title-1,
    .shipping-point-choice .shipping-point-list ul .title-2,
    .shipping-point-choice .shipping-point-list ul .title-3 {
      margin-top: 9px;
    }

    .identification .change-password-form input,
    .identification .identification-form input {
      display: inline-block;
    }

    .identification .identification-form .text-center.error .helper {
      display: block;
      text-align: center;
    }

    .identification .identification-form .text-center.error {
      padding: 0 15px;
    }

    .identification .change-password-form .form-group,
    .identification .change-password-form input[type="text"],
    .identification .identification-form .form-group,
    .identification .identification-form input[type="text"] {
      width: 100%;
      max-width: 300px;
    }

    .identification .change-password-form input,
    .identification .identification-form input {
      display: inline-block;
    }

    .form-group {
      margin: 0 auto 10px;

    }

    .form-group span.helper:empty {
      display: none;
    }

    .form-group span.helper {
      display: block;
      margin-bottom: 10px;
      text-align: left;
    }

    .form-group.mini .select-styled,
    .form-group.mini input:not([type="checkbox"]):not([type="radio"]) {
      height: 40px;
    }

    .form-group.mini textarea {
      background-color: white;
      width: auto;
      height: 100px;
    }


    .identification .change-password-form input,
    .identification .identification-form input {
      display: inline-block;
    }

    .identification .forgot-password {
      display: block;
      margin: 15px 0;
      text-align: center;
    }

    .identification .change-password-form .button.link,
    .identification .change-password-form .button.link-open-modal,
    .identification .change-password-form a.button,
    .identification .change-password-form button[type="submit"],
    .identification .identification-form .button.link,
    .identification .identification-form .button.link-open-modal,
    .identification .identification-form a.button,
    .identification .identification-form button[type="submit"] {
      margin: 0 auto;
      display: inline-block;
    }

    .identification .identification-sep {
      width: 100%;
      height: 1px;
      margin: 25px 0;
      background-color: #E1E1E1;
    }

    .form-group.mini .select-styled,
    .form-group.mini .select2,
    .form-group.mini input,
    .form-group.mini select,
    .form-group.mini.datepicker .input-group {
      margin-bottom: 0;
    }

    .form-group .select-styled,
    .form-group .select2,
    .form-group input,
    .form-group select {
      margin: 0 auto 10px;
      margin-bottom: 10px;
    }

    .config-list li,
    .identification .identification-form .text-center {
      font-weight: 400;
    }

    .error .helper {
      color: #E61414;
      text-align: left;
      display: inline-block;
      margin-bottom: 10px;
      font-size: 14px;
    }

    input,
    button,
    select,
    textarea {
      font-family: inherit;
      font-size: inherit;
      line-height: inherit;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
      color: inherit;
      font: inherit;
      font-size: inherit;
      line-height: inherit;
      font-family: inherit;
      margin: 0;
    }

    input[type="date"],
    input[type="date"],
    input[type="email"],
    input[type="number"],
    input[type="password"],
    input[type="phone"],
    input[type="tel"],
    input[type="text"],
    textarea {
      line-height: 25px;
      border: 1px solid #E1E1E1;
      padding: 0 15px;
      font-size: 13px;
      margin: 0 10px 10px 0;
      width: 100%;
      color: #282828;
      position: relative;
      transition: all .3s;
      border-radius: 0;
      -webkit-appearance: none;
      height: 50px;
    }

    input,
    button,
    select,
    textarea {
      font-family: inherit;
      font-size: inherit;
      line-height: inherit;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
      color: inherit;
      font: inherit;
      font-size: inherit;
      line-height: inherit;
      font-family: inherit;
      margin: 0;
      margin-top: 0px;
      margin-right: 0px;
      margin-bottom: 0px;
      margin-left: 0px;
    }

    .button,
    .link,
    .link-open-modal {
      cursor: pointer;
      /*position: relative;*/
    }

    .button:visited {
      color: #FFF;
    }

    .button {
      display: inline-block;
      text-decoration: none;
      text-decoration-line: none;
      text-decoration-style: solid;
      text-decoration-color: currentcolor;
      /*text-decoration-thickness: auto;*/
      font-size: 16px;
      text-transform: uppercase;
      background: #470653;
      background-color: rgb(65, 4, 80);
      background-position-x: 0%;
      background-position-y: 0%;
      background-repeat: repeat;
      background-attachment: scroll;
      background-image: none;
      background-size: auto;
      background-origin: padding-box;
      -webkit-background-clip: border-box;
      background-clip: border-box;
      border-radius: 40px;
      border-top-left-radius: 40px;
      border-top-right-radius: 40px;
      border-bottom-right-radius: 40px;
      border-bottom-left-radius: 40px;
      color: #FFF;
      padding: 10px 17px 9px;
      padding-top: 10px;
      padding-right: 17px;
      padding-bottom: 9px;
      padding-left: 17px;
      margin: 0 10px 10px 0;
      margin-top: 0px;
      margin-right: 10px;
      margin-bottom: 10px;
      margin-left: 0px;
      transition: all .2s;
      transition-property: all;
      transition-duration: 0.2s;
      transition-timing-function: ease;
      transition-delay: 0s;
      text-align: center;
      font-weight: 600;
      -webkit-appearance: none;
      border: 0;
      border-top-color: currentcolor;
      border-top-style: none;
      border-top-width: 0px;
      border-right-color: currentcolor;
      border-right-style: none;
      border-right-width: 0px;
      border-bottom-color: currentcolor;
      border-bottom-style: none;
      border-bottom-width: 0px;
      border-left-color: currentcolor;
      border-left-style: none;
      border-left-width: 0px;
      border-image-outset: 0;
      border-image-repeat: stretch;
      border-image-slice: 100%;
      border-image-source: none;
      border-image-width: 1;
    }

    button,
    html input[type="button"],
    input[type="reset"],
    input[type="submit"] {
      -webkit-appearance: button;
      cursor: pointer;
    }

    button,
    select {
      text-transform: none;
    }

    button,
    input,
    optgroup,
    select,
    textarea {
      color: inherit;
      font: inherit;
      font-weight: inherit;
      font-size: inherit;
      line-height: inherit;
      font-family: inherit;
      margin: 0;
    }

    button {
      overflow: visible;
      overflow-x: visible;
      overflow-y: visible;
    }

    .button:visited {
      color: #FFF;
    }

    .config-list li,
    .identification .identification-form .text-center {
      font-weight: 400;
    }

    .text-center {
      text-align: center !important;
    }

    .empty-cart,
    .identification .change-password-form .form-group.genders,
    .identification .identification-form .form-group.genders,
    .identification .title-1,
    .identification .title-2,
    .identification .title-3 {
      text-align: center;
    }

    footer {
      width: 100%;
      bottom: 0%;
      font-size: 15px;
    }

    .down-page {
      left: 0;
      width: 100%;
      height: 40px;
      background: #470653;
    }

    .text-footer {
      padding-top: 10px;
      padding-left: 10px;
      color: white;
    }
  </style>
</head>

<body>
  <header>
    <div class="container">
      <div class="tunnel-header">
        <a id="logo" href="index.php">

        </a>
      </div>
    </div>
  </header>

  <main class="site-content">
    <div id="page">
      <div class="main identification">
        <h2 class="title-1">Connect</h2>
        <div class="identification-form sblock">
        </div>
      </div>
  </main>
  <footer class="site-footer">
    <div class="down-page">
      <div class="text-footer">
        Made By HawKen
      </div>
    </div>
</body>

</html>