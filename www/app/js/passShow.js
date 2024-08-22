$(document).ready(function () {
  $(".toggle-password").click(function () {
    var passwordField = $("#user_password");
    var passwordFieldType = passwordField.attr("type");
    if (passwordFieldType === "password") {
      passwordField.attr("type", "text");
      $(this).removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
    } else {
      passwordField.attr("type", "password");
      $(this).removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
    }
  });
});
