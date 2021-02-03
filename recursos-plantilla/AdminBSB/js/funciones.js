/*
    Funcion global para general constantes
    globales o necesarias para cada página
*/
const prueba = (parametro) => {
    console.log('Jala');
};//End const prueba

/*
    Muestra el mensaje dentro de la vista dependiendo
    si ocurrio algo en la parte logica
*/
const alerta = (mensaje = '', tipo = 1 ) => {
    $.notify(
        "<strong>"+ tipo_mensaje(tipo) +"</strong> <br>"+ mensaje,
        {
            type: tipo_alerta(tipo),
            allow_dismiss: true,
            timer: 1000,
            placement: {
                from: "top",
                align: "center"
            },//End placement
            animate: {
                enter: "animated fadeInDown",
                exit: "animated fadeOutUp"
            }//End animate
        }//End
    );//End notify
};//End const alerta

const tipo_alerta = (num) => {
    tipo = '';
    switch (num) {
        case 1:
            tipo = 'success';
            break;
        case 2:
            tipo = 'danger';
            break;
        case 3:
            tipo = 'warning';
            break;
        default:
            tipo = '';
            break;
    }//End switch
    return tipo;
};//End const tipo_alerta

const tipo_mensaje = (num) => {
    titulo = '';
    switch (num) {
        case 1:
            titulo = '¡Correcto!';
            break;
        case 2:
            titulo = '¡Error!';
            break;
        case 3:
            titulo = '¡Atención!';
            break;
        default:
            titulo = '';
            break;
    }//End switch
    return titulo;
};//End const tipo_mensaje

/*
    V   A   L   I   D   A   R   I   M   A   G   E   N
    Esta funcion recibe como parametro el objeto del imput file o archivo,
    el segundo parametro es el id del botón para fuardar,
    el tercer parametro el url relativo de la imagen base.
    el cuarto y quinto parametro es el alto y ancho de la imagen que se va a subir en el servidor.
 */
const validate_image = (obj, preview, btn, img_base, ancho, alto) => {
    console.log(img_base);
    let uploadFile = obj.files[0];
    let button = document.getElementById(btn);
    if(!(/\.(jpg|png|jpeg)$/i).test(uploadFile.name)) {
        swal("¡Aviso!", "Formato de la imagen no permitido", "error", {buttons: {confirm: {text: "Aceptar", className: "btn btn-danger"}}});
        button.disabled = true;
    }//end of ifz
    else{
        let img = new Image();
        img.onload = function() {
        if((this.width.toFixed(0) > ancho || this.height.toFixed(0) > alto) || ((uploadFile.size/1024/1024) > 1)) {
            swal({
                title: "¡Aviso!",
                text: 'El peso de la imagen debe ser menor a 1MB o la imagén excede el tamaño recomendado que es de '+ancho+"x"+alto,
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Aceptar",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    button.disabled = true;
                    document.getElementById(preview).setAttribute('src', img_base);
                }//end of if
            });
        }//end of if
        else {
            if (obj.files && obj.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+preview).attr('src', e.target.result);
                    $('#'+preview).hide();
                    $('#'+preview).fadeIn(650);
                }
                reader.readAsDataURL(obj.files[0]);
            }
            button.disabled = false;
        }//end of else
    };//end of funcrion
        img.src = URL.createObjectURL(uploadFile);
    }//end of else
};//end validate_image

/**
* Esta función es parte de cambiar estatus y el retorno es un string revolviendo el tipo de estatus
* que al que se esta cambiando. Como parametro recibe un string con valor "1" o "0".
*/
const tipo_estatus = (estatus) => {
    if(estatus === "1") {
        return 'deshabilitar';
    }//end if
    else {
        return 'habilitar';
    }//end else
};//end tipo_estatus

/*
* Función global para cambiar el estatus de algún registro.
* Esta función funciona para cambiar un estatus de algún registro
* que maneje dos estatus solamente y se hace por consulta ajax.
* Esta función recibe dor argumentos, el primero es un arreglo que
* contiene 6 indices y el segundo es un objeto DataTable
* [0] -> URL
* [1] -> ID
* [2] -> ESTATUS
* [3] -> COMPLEMENTO DE PREGUNTA EJEMP. ¿Estás seguro de habilitar "este registro/este campo/este usuario"?
* Lo que va entre comillas es el complemento de la pregunta.
* [4] -> TEXTO EJEMP. Al habilitar/deshabilitar "se mostrara en las listas/tendrá permiso para acceder al sistema"
* El texto sería lo que va entre las comillas
* [5] -> Objeto dataTable. El objeto datatable funciona para actualizar el contenido de la misma dataTable
*/
const cambiar_estatus = (array, dataTable=null) => {
    swal({
        title: "¿Estás seguro de " + tipo_estatus(array[2]) + " " + array[3] + "?",
        text: "Al "+tipo_estatus(array[2])+" "+array[3]+" "+(array[2] === "1" ? 'no ' :'')+array[4],
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                value: null,
                visible: true,
                className: "btn btn-danger",
                closeModal: true
            },
            confirm: {
                text: "Sí, " + tipo_estatus(array[2]),
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: array[0],
                method: 'POST',
                data: { id: array[1],
                        estatus: (Number(-1 * array[2]))
                      },
                success: function (data) {
                    if (data === '1') {
                        alerta('Estatus actualizado correctamente', 1);
                    }//end of if
                    else if (data === '2') {
                        alerta('Ocurrió un error al actualizar el estatus', 2);
                    }//end of else
                    dataTable.ajax.reload();
                }
            });
        }//end of if
    });
};//end cambiar_estatus

const eliminar = (ruta = "", id=0, titulo='', mensaje='', dataTable) => {
    swal({
        title: titulo,
        text: mensaje,
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                value: null,
                visible: true,
                className: "btn btn-danger",
                closeModal: true
            },
            confirm: {
                text: "Sí, eliminar",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: ruta,
                method: 'POST',
                data: { id: id },
                success: function (data) {
                    if (data === '1') {
                        alerta('Registro eliminado correctamente', 1)
                    }//end of if
                    else if (data === '2') {
                        alerta('Ocurrió un error al eliminar el registro', 2);
                    }//end of else
                    dataTable.ajax.reload();
                }
            });
        }//end of if
    });
}; //end eliminar

/*
    Recargar la página con un intervalo de tiempo
*/
const refrescar = (time) => {
  setInterval(location.reload(true),time);
};//End const refrescar