                  </main>
            </div>
        </div>

        <div class="modal fade" id="modalSettingUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <img src="/app_asistencia/src/images/usersetting.png" alt="asistencia" width="50px" class="mx-4">
                        <h3 class="modal-title text-uppercase fw-bold" id="staticBackdropLabel">  
                            Información del perfil
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <form id="formUpdateUser">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-danger rounded-pill w-50 mx-1" data-bs-dismiss="modal" name="btnCancelar"><i class="fa-regular fa-circle-xmark mx-1"></i>Cancelar</button>
                                <button type="submit" class="btn btn-primary rounded-pill w-50 mx-1" name="btnActualizar"><i class="fa-solid fa-square-pen mx-1"></i>Actualizar Datos</button>
                            </div>
                            <div class="row p-3 my-1">
                                <div class="col-lg-6 col-md-12 my-2">
                                    
                                    <div>
                                        <div class="mb-3 form-check form-switch">
                                            <input type="checkbox" class="form-check-input" id="validarcambiofoto">
                                            <label class="form-check-label" for="validarcambiofoto">Habilitar cambio de foto</label>
                                        </div>
                                        <div class=" my-3 d-flex d-flex justify-content-center" id="imgusersetting">
                                            <?php 
                                                if($fotouser === null){
                                            ?>
                                                <img src="/app_asistencia/src/images/userexample2.jpg" alt="Usuario" width="200px" class="border border-4">
                                            <?php
                                            }else{
                                                ?>
                                                <img src="data:image/png;base64,<?php echo base64_encode($fotouser) ?>" alt="Foto" width="200px" class="border border-4" >                                         
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    
                                        <div class="p-1">
                                            <label for="fotofile" class="form-label px-1">Elegir nueva foto (12mb max)</label>
                                            <input  name="_fotito" class="form-control form-control-sm rounded-pill" id="fotofile" type="file" accept=".png" disabled>
                                        </div>
                                        <div class="d-flex">
                                        <button type="button"  id="fotomod" class="btn btn-outline-primary rounded-pill my-3 mx-1 w-50" disabled><i class="fa-regular fa-pen-to-square"></i> Actualizar foto</button>
                                            <button type="button"  id="fotodel" class="btn btn-outline-danger rounded-pill my-3 mx-1 w-50" disabled><i class="fa-solid fa-trash-can"></i> Eliminar foto</button>
                                        </div>
                                            
                                        
                                    </div>
                                    <div class="mb-3">
                                        <label for="aulasetting" class="form-label"><i class="fa-brands fa-ethereum "></i> Aula Asignada:</label>
                                        <select class="form-select rounded-pill" name="_aula" id="aulasetting" <?php echo $tipouser != 'A' ? 'disabled': '' ?> >
                                            <?php 
                                                $sqluser3 = $conn->prepare("SELECT id, nombre FROM aula");
                                                $sqluser3->execute();
                                                $sqluser3->bind_result($aula_id, $aula_name);
                                                while($sqluser3->fetch()){
                                                    ?>
                                                        <option value="<?php echo $aula_id ?>" <?php echo $idaulauser == $aula_id ? 'selected' : '' ?>> <?php echo $aula_name ?></option>
                                                    <?php
                                                }
                                                $sqluser3->close();
                    
                                            ?>
                                        </select>
                                    </div>

                                        
                                    <div class="mb-3">
                                        <label for="tipousersetting" class="form-label"><i class="fa-solid fa-users-viewfinder"></i> Tipo de usuario:</label>
                                        <select class="form-select rounded-pill" name="_tipo" id="tipousersetting" <?php echo $tipouser != 'A' ? 'disabled': '' ?> >
                                            <option value="A" <?php echo $tipouser == 'A' ? 'selected' : '' ?>> Administrador</option>
                                            <option value="D" <?php echo $tipouser == 'D' ? 'selected' : '' ?>> Docente</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12  my-2">
                                    <div class="mb-3">
                                        <label for="dnisetting" class="form-label"><i class="fa-solid fa-id-card"></i> Numero DNI (Codigo): </label>
                                        <input type="number" name="_dni" class="form-control fw-bold rounded-pill" id="dnisetting" required value="<?php echo $dniuser ?>" <?php echo $tipouser != 'A' ? 'disabled': '' ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namesetting" class="form-label"><i class="fa-regular fa-file-lines"></i> Nombres:</label>
                                        <input type="text" name="_nombre" class="form-control rounded-pill" id="namesetting"  required value="<?php echo $nombreuser ?>" <?php echo $tipouser != 'A' ? 'disabled': '' ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apesetting" class="form-label"><i class="fa-regular fa-file-lines"></i> Apellidos:</label>
                                        <input type="text" name="_apellido" class="form-control rounded-pill" id="apesetting"  required value="<?php echo $apellidouser ?>" <?php echo $tipouser != 'A' ? 'disabled': '' ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="passsetting" class="form-label"><i class="fa-solid fa-key"></i> Contraseña:</label>
                                        <input type="password" name="_pass" class="form-control rounded-pill" id="passsetting"  required value="<?php echo $passuser ?>" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="dirsetting" class="form-label"><i class="fa-solid fa-map-location-dot"></i> Dirección:</label>
                                        <input type="text" name="_direccion" class="form-control rounded-pill" id="dirsetting"  required value="<?php echo $direccionuser ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nacsetting" class="form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de nacimiento:</label>
                                        <input type="date"  name="_nac" class="form-control rounded-pill" id="nacsetting"  required value="<?php echo $fechanacuser ?>" min="1950-01-01" max="<?php echo date('Y-m-d') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefonosetting" class="form-label"><i class="fa-solid fa-phone"></i> Telefono:</label>
                                        <input type="number" name="_telefono" class="form-control rounded-pill" id="telefonosetting"  required value="<?php echo $telefonouser ?>" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="correosetting" class="form-label"><i class="fa-regular fa-envelope"></i> Correo Electronico:</label>
                                        <input type="email" name="_correo" class="form-control rounded-pill" id="correosetting"  required value="<?php echo $correouser ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="generosetting" class="form-label"><i class="fa-solid fa-user"></i> Genero:</label>
                                        <select class="form-select rounded-pill" name="_genero" id="generosetting" >
                                            <option value="M" <?php echo $generouser == 'M' ? 'selected' : '' ?>> Hombre</option>
                                            <option value="F" <?php echo $generouser == 'F' ? 'selected' : '' ?>> Mujer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="/app_asistencia/src/js/admin.js"></script>
        <script>
            document.dniuserglobal = <?php echo $dniuser ?> ;
        </script>
        <script src="/app_asistencia/src/js/<?php echo $tipouser === 'A' ? 'updateUserAdmin.js' : 'updateUser.js' ?>"></script>
        <script src="/app_asistencia/src/js/updatefoto.js"></script>
        <script src="/app_asistencia/src/js/asistencia.js"></script>
    </body>
</html>

<?php $conn->close(); ?>
