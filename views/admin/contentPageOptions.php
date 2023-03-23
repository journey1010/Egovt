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
    
    public function RegistrarUsuarios()
    {
        $html= <<<Html
        <div class="card card-primary mt-3">
            <div class="card-header">
            <h3 class="card-title">Registrar usuario</h3>
            </div>
            <form id="registrarUsuario">
                <div class="card-body">
                    <div class="form-group">
                        <label for="buscarDNI">DNI *</label>
                        <input type="number" class="form-control" id="dni" placeholder="Ingresar DNI..." required>
                    </div>
                    <button type="button" class="btn btn-secondary" id="searchDNI" >Buscar</button>
                    <div class="form-group">
                        <label for="labelUsuario">Usuario *</label>
                        <input type="text" class="form-control" id="nombre_usuario" placeholder="Ingrese nombre de usuario ...">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="labelUsuario">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre">
                            </div>
                            <div class="col-md-4">
                                <label for="apellidoPaterno">Apellido paterno *</label>
                                <input type="text" class="form-control" id="apellido_paterno" placeholder="Ingrese su apellido paterno">
                            </div>
                            <div class="col-md-4">
                                <label for="apellidoMaterno">Apellido materno *</label>
                                <input aria-label="apellido materno" type="text" class="form-control" id="apellido_materno" placeholder="Ingrese su apellido materno">
                            </div>
                            <div class="col-md-4">
                                <label for="contraseña">Contraseña *</label>
                                <input type="password" class="form-control" id="contrasena" placeholder="Ingrese su contraseña" autocomplete="on">
                            </div>
                            <div class="col-md-4">
                                <label for="numberTelefono">Número de teléfono</label>
                                <input type="text" class="form-control" id="numero_telefono" placeholder="Ingrese su teléfono">
                            </div>
                            <div class="col-md-4">
                                <label>Tipo de usuario *</label>
                                <div class="form-group">
                                    <select id="tipoUsuario"aria-label="tiposUsuarios"class="form-control select2 select2-danger"  style="width: 100%;">
                                        <option selected="selected" value="admin">Super Administrador</option>
                                        <option value="subadmin">Administrador</option>
                                        <option value="visitor">Visitas</option>
                                        <option value="noticias">Noticias</option>
                                        <option value="obras">Obras</option>
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

    public function Oficinas()
    {
        $conexion = new MySQLConnection();

        function select( MySQLConnection $conexion): string
        {   
            $sql = "SELECT DISTINCT jerarquia FROM oficinas";
            $smt = $conexion->query($sql, '', '', false);
            $resultado = $smt->fetchAll();
            $options  = '';
            foreach ($resultado as $row) {
                $jerarquia = $row['jerarquia'];
                $options .= "<option value='$jerarquia'>$jerarquia</options>";
            }
            return $options;
        } 

        $select = select($conexion);

    
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
                            <label for="tipoOrgano">Jerarquía</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%; height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true" required>
                                $select
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nombreOfi">Nombre</label>
                            <input aria-label="Nombre" type="text" class="form-control" id="nombreOfi" placeholder="Nombre de oficina" required>
                        </div>
                        <div class="col-md-4">
                            <label for="sigla">Sigla</label>
                            <input aria-label="sigla" type="text" class="form-control" id="sigla" placehoder="Ingrese sigla ..." required>
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
                            <th class="text-center">id</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">jerarquia</th>
                            <th style="text-center">sigla</th>
                            <th style="width: 80px" class="text-center">Editar</th>
                        </thead>
                        <tbody>
                            <tr>
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
    
    public function ActualizarUsuarios()
    {

    }

    public function RegistrarVisitas()
    {
        $hora = new DateTime('', new DateTimeZone('UTC'));
        $hora->setTimezone(new DateTimeZone('America/Bogota'));
        $dateTimeNow = $hora->format('Y-m-d H:i:s');

        $conexion = new MySQLConnection();
        $sql = "SELECT id ,CONCAT(nombre, ' ', sigla) as nombreCompleto FROM oficinas";
        $smt = $conexion->query($sql, '', '', false);
        $resultado = $smt->fetchAll();
        $options = '';
        foreach ($resultado as $row) {
            $id = $row['id'];
            $nombreCompleto = $row['nombreCompleto'];
            $options .= "<option value=\"$id\">$nombreCompleto</option>";
        }
        $conexion->close();

        $html = <<<Html
        <div class="card card-primary mt-3">
            <div class="card-header">
                <h3 class="card-title">Registrar visitas</h3>
            </div>
            <form id="registrarVisitas">
                    <div class="card-body">
                        <div class="form-group">
                        <label for="buscarDNI">DNI *</label>
                        <input type="number" class="form-control" id="dniVisita" placeholder="Ingresar DNI..." required>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="BuscarDNIVisita">Buscar</button>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="labelNombreCompleto">Nombre completo *</label>
                            <input type="text" class="form-control" id="apellidos_nombres" placeholder="Ingrese su nombre completo">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Oficina *</label>
                                <select class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%; height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                    $options
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="persona_a_visitar">¿A quién visita?</label>
                            <input type="text" class="form-control" id="persona_a_visitar">
                        </div>
                        <div class="col-md-3">
                            <label for="HoraIngreso">Hora de ingreso</label>
                            <input type="text" class="form-control" id="hora_de_ingreso" value="$dateTimeNow" disabled>
                        </div>
                        <div class="col-md-5">
                            <label for="quien_autoriza">¿Quién autoriza?</label>
                            <input type="text" class="form-control" id="quien_autoriza" placeholder="Nombre de la persona que autoriza">
                        </div>
                        <div class="col-md-7">
                            <label for="motivo">Motivo de la visita</label>
                            <input type="text" class="form-control h-100" id="motivo" placeholder="Descripción del motivo de visita">
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        Html;
        return $html;
    }

    public function ActualizarVisitas()
    {
        $conexion = new MySQLConnection();
        $sql = "SELECT id, dni, apellidos_nombres, hora_de_salida, motivo  FROM visitas WHERE hora_de_salida IS NULL ";
        $smt = $conexion->query($sql, '', '', false );
        $resultado = $smt->fetchAll();
        $tablaRow = '';
        foreach ($resultado as $row) {
            $id = $row['id'];
            $dni = $row['dni'];
            $apellidoNombre = $row['apellidos_nombres'];
            $horaSalida = $row['hora_de_salida'];
            $motivo = $row['motivo'];
            $tablaRow .= "<tr>";
            $tablaRow .= "<td class=\"text-center\">$id</td>";
            $tablaRow .= "<td class=\"text-center\">$dni</td>";  
            $tablaRow .= "<td class=\"text-center\">$apellidoNombre</td>";
            $tablaRow .= "<td class=\"text-center\">$horaSalida</td>";
            $tablaRow .= "<td class=\"text-center\"  contenteditable=\"false\">$motivo</td>";
            $tablaRow .= '
                <td class="text-center align-middle">
                    <i class="fa fa-edit mr-2 edit-icon" style="color:#9c74dd !important"></i>
                    <i class="fa fa-times mr-2 cancel-icon" style="color:#d90a0a !important; display:none;"></i>
                    <i class="fa fa-check save-icon" style="color:#acc90e !important; display:none;"></i>
                </td>
            ';
            $tablaRow .= "</tr>";
        }
        $conexion->close();
        $html = <<<Html
        <div class="card card-primary mt-3" style="width: 100% !important;">
            <div class="card-header">
                <h3 class="card-title">Actualizar visitas</h3>
            </div>
            <div class="card-body table-responsive p-1" style="width:100% !important">
                <table class="table table-bordered table-hover text-nowrap table-md">
                    <thead class="bg-info">
                        <tr>
                            <th class="text-center">id</th>
                            <th class="text-center">DNI</th>
                            <th class="text-center">Nombre completo</th>
                            <th style="text-center">Hora de salida</th>
                            <th class="text-center">Motivo u Observación</th>
                            <th style="width: 80px" class="text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        $tablaRow
                    </tbody>
                </table>  
            </div>
        </div>
        Html;
        return $html;
    }

    public function RegistrarObras()
    {

    }

    public function ActualizarObras()
    {

    }

    public function Contacto()
    {
        $html = <<<Html
        <div>hola</div>
        Html;
        return $html;
    }    
    
}