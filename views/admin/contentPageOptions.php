<?php

require_once (_ROOT_MODEL . 'conexion.php'); 

class contentPageOptions{
    public function Dashboard()
    {
        $html = <<<Html
        <div>Hola soy un dashboard</div>
        Html;
        return $html;
    }

    public function Oficinas()
    {
        $filasTabla = function(){
            $conexion = new MySQLConnection();
            $sqlSentence = "select * from oficinas";
            $resultado = $conexion->query($sqlSentence, '', '', false);
            $arrayResultado = $resultado->fetchAll();
        };

        $html= <<<Html
        <section class="container-fluid mt-3">
            <div class="card card-danger">
                <div class="card-header">
                <h3 class="card-title">Registrar oficina</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
                </div>
                <div class="card-body">
                    <form id="registrarOficina">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipoOrgano">Tipo de órgano</label>
                            <select aria-label="tipoOrganos"class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                                <option value="organo">Órgano de alta dirección</option>
                                <option value="organo">Órgano consultivo</option>
                                <option value="organo">Órgano de control</option>
                                <option value="organo">Órgano de defensa judicial</option>
                                <option value="organo">Órgano de asesoramiento</option>
                                <option value="organo">Órgano de apoyo</option>
                                <option value="organo">Órgano de linea</option>
                                <option value="organo">Órgano y unidades orgánicas desconcentradas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="subTipo">SubTipo de órgano</label>
                            <input aria-label="Sub Tipo órgano" type="text" class="form-control" id="subtipo" placeholder="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="subTipo">subSubTipo</label>
                            <input aria-label="sub Sub Tipo órgano" type="text" class="form-control" id="subtipo" placehoder="">
                        </div>
                        <div class="col-md-4 mt-2">
                            <button aria-label="botón guardar" type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
        <section class="container-fluid mt-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Administrar oficinas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                        <i class="fas fa-sync-alt"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-header">
                        <h3 class="card-title text-center">Registro de oficinas</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-sm">
                        <thead class="bg-warning">
                            <tr>
                            <th style="width: 10px">#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Subtipo</th>
                            <th>Sub Subtipo</th>
                            <th style="width: 80px">Editar</th>
                            <th style="width: 80px">Eliminar<th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>  
                </div>
            </div>
        </section>
        Html;
        return $html;
    }

    public function RegistrarUsuarios()
    {
        $html= <<<Html
        <div class="card card-primary mt-3 col-lg">
            <div class="card-header">
            <h3 class="card-title">Registrar usuario</h3>
            </div>
            <div class = "card-body">
                <div class="form-group">
                    <label for="buscarDNI">DNI</label>
                    <input type="number" class="form-control" id="dni" placeholder="Ingresar DNI..." required>
                </div>
                <button type="submit" class="btn btn-secondary" id="BuscarDNI">Buscar</button>
            </div>
            <form id="registrarUsuario">
                <div class="card-body">
                    <div class="form-group">
                        <label for="labelUsuario">Usuario</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombre de usuario ...">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="labelUsuario">Nombre</label>
                                <input type="text" class="form-control" id="nombre_usuario" placeholder="Ingrese su nombre">
                            </div>
                            <div class="col-md-4">
                                <label for="apellidoPaterno">Apellido paterno</label>
                                <input type="text" class="form-control" id="apellido_paterno" placeholder="Ingrese su apellido paterno">
                            </div>
                            <div class="col-md-4">
                                <label for="apellidoMaterno">Apellido materno</label>
                                <input aria-label="apellido materno" type="text" class="form-control" id="apellido_materno" placeholder="Ingrese su apellido materno">
                            </div>
                            <div class="col-md-4">
                                <label for="contraseña">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="col-md-4">
                                <label for="numberTelefono">Número de teléfono</label>
                                <input type="text" class="form-control" id="numero_telefono" placeholder="Ingrese su teléfono">
                            </div>
                            <div class="col-md-4">
                                <label>Tipo de usuario</label>
                                <div class="form-group">
                                    <select aria-label="tiposUsuarios"class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option selected="selected" value="admin">Super Administrador</option>
                                    <option value="subadmin">Administrador</option>
                                    <option value="visitor">Visitas</option>
                                    <option value="noticias">Noticias</option>
                                    </select>
                                </div>
                            </div>
                        </div>                    
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        Html;
        return $html;
    } 

    public function RegistrarVisitas()
    {
        $dateTimeNow = date('Y-m-s H:i:s');
        $html = <<<Html
        <div class="card card-primary mt-3 col-lg">
            <div class="card-header">
            <h3 class="card-title">Registrar visitas</h3>
            </div>
            <div class = "card-body">
                <div class="form-group">
                    <label for="buscarDNI">DNI</label>
                    <input type="number" class="form-control" id="dni" placeholder="Ingresar DNI..." required>
                </div>
                <button type="submit" class="btn btn-secondary" id="BuscarDNI">Buscar</button>
            </div>
            <form id="registrarUsuario">
                <div class="card-body">
                    <div class="row row-cols-3">
                        <div class="col">
                            <label for="labelNombreCompleto">Nombre completo</label>
                            <input type="text" class="form-control" id="apellidos_nombres" placeholder="Ingrese su nombre completo">
                        </div>
                        <div class="col">
                            <label for="apellidoPaterno">Apellido paterno</label>
                            <input type="text" class="form-control" id="apellido_paterno" placeholder="Ingrese su apellido paterno">
                        </div>
                        <div class="col">
                            <label>Tipo de usuario</label>
                            <div class="form-group">
                                <select aria-label="tiposUsuarios"class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option selected="selected" value="admin">Super Administrador</option>
                                <option value="subadmin">Administrador</option>
                                <option value="visitor">Visitas</option>
                                <option value="noticias">Noticias</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label for="persona_a_visitar">¿A quién visita?</label>
                            <input type="text" class="form-control" id="persona_a_visitar">
                        </div>
                        <div class="col">
                            <label for="HoraIngreso">Hora de ingreso</label>
                            <input type="text" class="form-control" id="hora_de_ingreso" value="$dateTimeNow" disabled>
                        </div>
                        <div class="col">
                            <label for="quien_autoriza">¿Quién autoriza?</label>
                            <input type="text" class="form-control" id="quien_autoriza" placeholder="Nombre de la persona que autoriza">
                        </div>
                        <div class="col">
                            <label for="motivo">Motivo de la visita</label>
                            <input type="text" class="form-control" id="motivo" placeholder="Descripción del motivo de visita">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        Html;
        return $html;
    }

    public function ActualizarVisitas()
    {
        $html = <<<Html
        
        Html;
        return $html;
    }

    public function Contacto()
    {
        $html = <<<Html
        <div>hola</div>
        Html;
        return $html;
    }
}