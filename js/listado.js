$(document).ready(function () {
  $("#provincia").val(1);
  $("#localidad").val();
  recargarLista();

  $("#provincia").change(function () {
    recargarLista();
  });
});

function recargarLista() {
  $.ajax({
    type: "POST",
    url: "datos.php",
    data: "provincia=" + $("#provincia").val(),
    success: function (r) {
      $("#localidad").html(r);
    },
  });
}
