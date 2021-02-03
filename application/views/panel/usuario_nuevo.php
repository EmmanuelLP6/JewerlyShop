<div class="row clearfix">
    <?php echo $navegacion;?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Nuevo Usuario
                </h2>
            </div>
            <div class="body">
                <center>
					<img src="<?php echo base_url('uploads/icons/user.jpg'); ?>" width="15%" id="preview" class="img-circle">
				</center><hr>
                <?php echo form_open_multipart('',['id'=>'nuevo-usuario']); ?>
                    <div class="panel-body">
                        <div class="row clearfix">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Nombre(s) (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line" id="nombre_has_error">
                                            <input type="text" class="form-control date" placeholder="Nombre(s)" name="nombre_usuario">
                                        </div>
                                    </div>
                                    <label id="nombre_error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Apellido Paterno (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line" id="ap_has_error">
                                            <input type="text" class="form-control date" placeholder="Apellido Paterno" name="ap_usuario">
                                        </div>
                                    </div>
                                    <label id="ap_error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Apellido Materno (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line" id="am_has_error">
                                            <input type="text" class="form-control date" placeholder="Apellido Materno" name="am_usuario">
                                        </div>
                                    </div>
                                    <label id="am_error" class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <b>Rol (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment_ind</i>
                                        </span>
                                        <?php
                                            foreach ($roles as $id_rol => $rol) {
                                                echo '
                                                    <input id="rol-'.$id_rol.'" type="checkbox" class="form-control date" name="rol[]" value="'.$id_rol.'">
                                                    <label for="rol-'.$id_rol.'">'.$rol.'</label><br>
                                                ';
                                            }//End foreach
                                        ?>
                                    </div>
                                    <label id="rol_error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-float">
                                    <b>Genero (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">accessibility</i>
                                        </span>
                                        <?php echo form_dropdown(['id'=>'genero_has_error', 'name'=>'genero_usuario', 'class'=>'form-control', 'data-width'=>'100%'], [''=>'Seleccionar género']+$this->constantes->GENEROS) ?>

                                    </div>
                                    <label id="genero_error" class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Correo electrónico (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">contact_mail</i>
                                        </span>
                                        <div class="form-line" id="usuario_has_error">
                                            <input type="email" class="form-control date" placeholder="usuario@ejemplo.com" name="usuario">
                                        </div>
                                    </div>
                                    <label id="usuario_error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Contraseña (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        <div class="form-line" id="password_has_error">
                                            <input type="password" class="form-control date" placeholder="**********" name="password">
                                        </div>
                                    </div>
                                    <label id="password_error" class="error"></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <b>Repetir Contraseña (<font color="red">*</font>)</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        <div class="form-line" id="password2_has_error">
                                            <input type="password" class="form-control date" placeholder="**********" name="password2">
                                        </div>
                                    </div>
                                    <label id="password2_error" class="error"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-float">
                                    <b>Foto perfil</b> (<font>Opcional</font>)
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">party_mode</i>
                                        </span>
                                        <div class="form-line">
                                            <input onchange="validate_image(this, 'preview', 'btn-guardar', '../uploads/icons/user.jpg', 700, 700);"  type="file" class="form-control-file" name="imagen"  accept=".png, .jpeg, .jpeg">
                                        </div>
                                        <span class="helper d-block fs12 text-muted pt-2">Tamaño recomendable <strong class="text-danger">700x700</strong>, peso máximo <strong class="text-danger">1MB</strong> y formatos ( .png, .jpeg, .jpg )</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
    					<a type="button" href="javascript:history.back()" class="btn btn-danger" type="submit"><i class="material-icons">close</i> <span>Cancelar</span></a>
    					<button class="btn btn-primary" type="submit" id="btn-guardar"><i class="material-icons">check</i> <span>Guardar</span></button>
    				</div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(){

    };
</script>
