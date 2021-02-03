if (document.getElementById('nuevo-usuario')) {
    document.getElementById('nuevo-usuario').addEventListener('submit', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        document.getElementById('nombre_error').innerHTML = '';
        document.getElementById('nombre_has_error').classList.remove('error');
        document.getElementById('ap_error').innerHTML = '';
        document.getElementById('ap_has_error').classList.remove('error');
        document.getElementById('am_error').innerHTML = '';
        document.getElementById('am_has_error').classList.remove('error');
        document.getElementById('rol_error').innerHTML = '';
        document.getElementById('genero_has_error').classList.remove('error');
        document.getElementById('genero_error').innerHTML = '';
        document.getElementById('usuario_has_error').classList.remove('error');
        document.getElementById('usuario_error').innerHTML = '';
        document.getElementById('password_has_error').classList.remove('error');
        document.getElementById('password_error').innerHTML = '';
        document.getElementById('password2_has_error').classList.remove('error');
        document.getElementById('password2_error').innerHTML = '';
        $.ajax({
            type: 'POST',
            url: './usuario_nuevo/agregar',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-guardar').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                let data = JSON.parse(respuesta);
                // console.log(data);
                if(data.validation){
                    if (data.nombre_error != '') {
                        document.getElementById('nombre_error').innerHTML = data.nombre_error;
                        document.getElementById('nombre_has_error').classList.add('error');
                    }//End if data.nombre_error
                    if (data.ap_error != '') {
                        document.getElementById('ap_error').innerHTML = data.ap_error;
                        document.getElementById('ap_has_error').classList.add('error');
                    }//End if data.ap_error
                    if (data.am_error != '') {
                        document.getElementById('am_error').innerHTML = data.am_error;
                        document.getElementById('am_has_error').classList.add('error');
                    }//End if data.am_error
                    if (data.rol_error != '') {
                        document.getElementById('rol_error').innerHTML = data.rol_error;
                    }//End if data.am_error
                    if (data.genero_error != '') {
                        document.getElementById('genero_error').innerHTML = data.genero_error;
                        document.getElementById('genero_has_error').classList.add('error');
                    }//End if data.genero_error
                    if (data.usuario_error != '') {
                        document.getElementById('usuario_error').innerHTML = data.usuario_error;
                        document.getElementById('usuario_has_error').classList.add('error');
                    }//End if data.usuario_error
                    if (data.password_error != '') {
                        document.getElementById('password_error').innerHTML = data.password_error;
                        document.getElementById('password_has_error').classList.add('error');
                    }//End if data.password_error
                    if (data.password2_error != '') {
                        document.getElementById('password2_error').innerHTML = data.password2_error;
                        document.getElementById('password2_has_error').classList.add('error');
                    }//End if data.password_error
                }//End data.validation
                else{
                    if (data.insert === true) {
                        location.href = data.url;
                    }//end if !data.insert
                    else if(data.error === true) {
                        alerta('Ocurrió un error al registrar el usuario', 2);
                    }//end else
                }//End else
                document.getElementById('btn-guardar').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });//End addEventListener
}//End if documentById

if (document.getElementById('usuario-detalles')) {
    document.getElementById('usuario-detalles').addEventListener('submit', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        document.getElementById('nombre_error').innerHTML = '';
        document.getElementById('nombre_has_error').classList.remove('error');
        document.getElementById('ap_error').innerHTML = '';
        document.getElementById('ap_has_error').classList.remove('error');
        document.getElementById('am_error').innerHTML = '';
        document.getElementById('am_has_error').classList.remove('error');
        document.getElementById('rol_error').innerHTML = '';
        document.getElementById('genero_has_error').classList.remove('error');
        document.getElementById('genero_error').innerHTML = '';
        document.getElementById('usuario_has_error').classList.remove('error');
        document.getElementById('usuario_error').innerHTML = '';
        document.getElementById('password_has_error').classList.remove('error');
        document.getElementById('password_error').innerHTML = '';
        document.getElementById('password2_has_error').classList.remove('error');
        document.getElementById('password2_error').innerHTML = '';
        $.ajax({
            type: 'POST',
            url: '../usuario_detalles/editar',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-guardar').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                let data = JSON.parse(respuesta);
                // console.log(data);
                if(data.validation){
                    if (data.nombre_error != '') {
                        document.getElementById('nombre_error').innerHTML = data.nombre_error;
                        document.getElementById('nombre_has_error').classList.add('error');
                    }//End if data.nombre_error
                    if (data.ap_error != '') {
                        document.getElementById('ap_error').innerHTML = data.ap_error;
                        document.getElementById('ap_has_error').classList.add('error');
                    }//End if data.ap_error
                    if (data.am_error != '') {
                        document.getElementById('am_error').innerHTML = data.am_error;
                        document.getElementById('am_has_error').classList.add('error');
                    }//End if data.am_error
                    if (data.rol_error != '') {
                        document.getElementById('rol_error').innerHTML = data.rol_error;
                    }//End if data.am_error
                    if (data.genero_error != '') {
                        document.getElementById('genero_error').innerHTML = data.genero_error;
                        document.getElementById('genero_has_error').classList.add('error');
                    }//End if data.genero_error
                    if (data.usuario_error != '') {
                        document.getElementById('usuario_error').innerHTML = data.usuario_error;
                        document.getElementById('usuario_has_error').classList.add('error');
                    }//End if data.usuario_error
                    if (data.password_error != '') {
                        document.getElementById('password_error').innerHTML = data.password_error;
                        document.getElementById('password_has_error').classList.add('error');
                    }//End if data.password_error
                    if (data.password2_error != '') {
                        document.getElementById('password2_error').innerHTML = data.password2_error;
                        document.getElementById('password2_has_error').classList.add('error');
                    }//End if data.password_error
                }//End data.validation
                else{
                    if (data.insert === true) {
                        // location.href = data.url;
                        alerta('La información se ha actualizado', 1);
                    }//end if !data.insert
                    else if(data.error === true) {
                        alerta('Ocurrió un error al registrar el usuario', 2);
                    }//end else
                }//End else
                document.getElementById('btn-guardar').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });//End addEventListener
}//End if documentById nuevo-detalles

if (document.getElementById('perfil-usuario')) {
    document.getElementById('perfil-usuario').addEventListener('submit', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        document.getElementById('nombre_error').innerHTML = '';
        document.getElementById('nombre_has_error').classList.remove('error');
        document.getElementById('ap_error').innerHTML = '';
        document.getElementById('ap_has_error').classList.remove('error');
        document.getElementById('am_error').innerHTML = '';
        document.getElementById('am_has_error').classList.remove('error');
        document.getElementById('genero_has_error').classList.remove('error');
        document.getElementById('genero_error').innerHTML = '';
        document.getElementById('usuario_has_error').classList.remove('error');
        document.getElementById('usuario_error').innerHTML = '';
        // console.log('huevos');
        $.ajax({
            type: 'POST',
            url: './usuario_perfil/editar_perfil',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-guardar').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                let data = JSON.parse(respuesta);
                // console.log(data);
                if(data.validation){
                    if (data.nombre_error != '') {
                        document.getElementById('nombre_error').innerHTML = data.nombre_error;
                        document.getElementById('nombre_has_error').classList.add('error');
                    }//End if data.nombre_error
                    if (data.ap_error != '') {
                        document.getElementById('ap_error').innerHTML = data.ap_error;
                        document.getElementById('ap_has_error').classList.add('error');
                    }//End if data.ap_error
                    if (data.am_error != '') {
                        document.getElementById('am_error').innerHTML = data.am_error;
                        document.getElementById('am_has_error').classList.add('error');
                    }//End if data.am_error
                    if (data.genero_error != '') {
                        document.getElementById('genero_error').innerHTML = data.genero_error;
                        document.getElementById('genero_has_error').classList.add('error');
                    }//End if data.genero_error
                    if (data.usuario_error != '') {
                        document.getElementById('usuario_error').innerHTML = data.usuario_error;
                        document.getElementById('usuario_has_error').classList.add('error');
                    }//End if data.usuario_error
                    // if (data.password_error != '') {
                    //     document.getElementById('password_error').innerHTML = data.password_error;
                    //     document.getElementById('password_has_error').classList.add('error');
                    // }//End if data.password_error
                    // if (data.password2_error != '') {
                    //     document.getElementById('password2_error').innerHTML = data.password2_error;
                    //     document.getElementById('password2_has_error').classList.add('error');
                    // }//End if data.password_error
                }//End data.validation
                else{
                    if (data.update === true) {
                        // location.href = data.url;
                        alerta('La información se ha actualizado', 1);
                        refrescar(4000);
                    }//end if !data.insert
                    else if(data.error === true) {
                        alerta('La información del usuario no se actualizo', 2);
                    }//end else
                }//End else
                document.getElementById('btn-guardar').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });//End addEventListener
}//End if documentById nuevo-detalles

if (document.getElementById('perfil-password')) {
    document.getElementById('perfil-password').addEventListener('submit', function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        document.getElementById('password_has_error').classList.remove('error');
        document.getElementById('password_error').innerHTML = '';
        document.getElementById('password2_has_error').classList.remove('error');
        document.getElementById('password2_error').innerHTML = '';
        $.ajax({
            type: 'POST',
            url: './usuario_perfil/editar_password',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                document.getElementById('btn-guardar-password').setAttribute('disabled','disabled');
            },//End beforeSend
            success: function(respuesta){
                let data = JSON.parse(respuesta);
                // console.log(data);
                if(data.validation){
                    if (data.password_error != '') {
                        document.getElementById('password_error').innerHTML = data.password_error;
                        document.getElementById('password_has_error').classList.add('error');
                    }//End if data.password_error
                    if (data.password2_error != '') {
                        document.getElementById('password2_error').innerHTML = data.password2_error;
                        document.getElementById('password2_has_error').classList.add('error');
                    }//End if data.password_error
                }//End data.validation
                else{
                    if (data.update === true) {
                        // location.href = data.url;
                        alerta('La información se ha actualizado', 1);
                        refrescar(4000);
                    }//end if !data.insert
                    else if(data.error === true) {
                        alerta('La información del usuario no se actualizo', 2);
                    }//end else
                }//End else
                document.getElementById('btn-guardar-password').removeAttribute('disabled','disabled');
            }//End success
        });//End ajax
    });//End addEventListener
}//End if documentById nuevo-detalles