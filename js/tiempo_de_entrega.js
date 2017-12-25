$(document).ready(function () {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/buscar_tiempo_de_entrega.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}



function eliminar(id)
{
    var q = $("#q").val();
    if (confirm("Realmente deseas eliminar el Tipo de Tiempo de Entrega")) {
        $.ajax({
            type: "GET",
            url: "./ajax/buscar_tiempo_de_entrega.php",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                load(1);
            }
        });
    }
}



$("#guardar_tiempo").submit(function (event) {
    $('#guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_tiempo_de_entrega.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

$("#editar_tiempo").submit(function (event) {
    $('#actualizar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_tiempo_de_entrega.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax2").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax2").html(datos);
            $('#actualizar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

function obtener_datos(id) {
    var descripcion_tiempo = $("#descripcion_tiempo" + id).val();

    $("#mod_descripcion").val(descripcion_tiempo);
    $("#mod_id").val(id);

}




