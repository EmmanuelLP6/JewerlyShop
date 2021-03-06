<div class="row clearfix">
    <?php echo $navegacion;?>
    <div class="col-xs-12 col-sm-3">
        <div class="card profile-card">
            <div class="profile-header">&nbsp;</div>
            <div class="profile-body">
                <div class="image-area">
                    <img src="<?php echo base_url(($this->session->userdata($this->constantes->CLAVE_SESION.'imagen_usuario')  != NULL ? 'uploads/users/'.$this->session->userdata($this->constantes->CLAVE_SESION.'imagen_usuario') : 'uploads/icons/user.jpg'));?>" width="65%" id="preview" class="img-circle">
                    
                </div>
                <div class="content-area">
                    <h3><?php echo $this->session->userdata($this->constantes->CLAVE_SESION.'nombre_usuario'); ?></h3>
                    <p><?php echo $rol_actual['nombre']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="card">
            <div class="body">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Detalles perfil</a></li>
                        <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Cambiar contraseña</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                            <?php echo form_open_multipart('',['id'=>'perfil-usuario']); ?>
                                <div class="panel-body">
                                    <input type="hidden" name="id_usuario" value="<?php echo $perfil->id_usuario ?>">
                                    <input type="hidden" name="imagen-usuario-anterior" value="<?php echo $perfil->imagen_usuario ?>"> 
                                    <div class="row clearfix">
                                        <div class="col-md-4">
                                            <div class="form-group form-float">
                                                <b>Nombre(s) (<font color="red">*</font>)</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line" id="nombre_has_error">
                                                        <input type="text" class="form-control date" placeholder="Nombre(s)" name="nombre_usuario" value="<?php echo $perfil->nombre_usuario; ?>">
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
                                                        <input type="text" class="form-control date" placeholder="Apellido Paterno" name="ap_usuario" value="<?php echo $perfil->ap_usuario; ?>">
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
                                                        <input type="text" class="form-control date" placeholder="Apellido Materno" name="am_usuario" value="<?php echo $perfil->am_usuario; ?>">
                                                    </div>
                                                </div>
                                                <label id="am_error" class="error"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <b>Genero (<font color="red">*</font>)</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">accessibility</i>
                                                    </span>
                                                    <?php echo form_dropdown(['id'=>'genero_has_error', 'name'=>'genero_usuario', 'class'=>'form-control', 'data-width'=>'100%'], [$perfil->genero_usuario=>$this->constantes->GENEROS[$perfil->genero_usuario]]+$this->constantes->GENEROS); ?>
                                                </div>
                                                <label id="genero_error" class="error"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-float">
                                                <b>Correo electrónico (<font color="red">*</font>)</b>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">contact_mail</i>
                                                    </span>
                                                    <div class="form-line" id="usuario_has_error">
                                                        <input type="email" class="form-control date" placeholder="usuario@ejemplo.com" name="usuario" value="<?php echo $perfil->email_usuario; ?>">
                                                    </div>
                                                </div>
                                                <label id="usuario_error" class="error"></label>
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
                                <div class="panel-footer">
                                    <!-- <a type="button" href="javascript:history.back()" class="btn btn-danger" type="submit"><i class="material-icons">close</i> <span>Cancelar</span></a> -->
                                    <button class="btn btn-primary" type="submit" id="btn-guardar"><i class="material-icons">check</i> <span>Guardar</span></button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                            <?php echo form_open_multipart('',['id'=>'perfil-password']); ?>
                                <input type="hidden" name="id_usuario" value="<?php echo $perfil->id_usuario ?>">
                                <div class="panel-body">
                                    <div class="row clearfix">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
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
                                </div>
                                <div class="panel-footer">
                                    <!-- <a type="button" href="javascript:history.back()" class="btn btn-danger" type="submit"><i class="material-icons">close</i> <span>Cancelar</span></a> -->
                                    <button class="btn btn-primary" type="submit" id="btn-guardar-password"><i class="material-icons">check</i> <span>Guardar</span></button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>