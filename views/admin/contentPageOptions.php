<?php

require_once(_ROOT_MODEL . 'conexion.php');

class contentPageOptions
{
    private $rutaAssets;

    public function __construct()
    {
        $this->rutaAssets = _ROOT_ASSETS_ADMIN;
    }

    public function Dashboard()
    {
        $html = <<<Html
        <div>Hola soy un dashboard</div>
        Html;
        return $html;
    }

    public function RegistrarUsuarios()
    {
        $ruta = $this->rutaAssets . 'js/usuarios.js';
        $html = <<<Html
        <div class="card card-primary mt-3 mx-auto">
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
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function ActualizarUsuarios()
    {
        $ruta = $this->rutaAssets . 'js/usuarios.js';
        $html = <<<Html
        <script  type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function Oficinas()
    {
        $ruta = $this->rutaAssets .  'js/oficinas.js';
        $conexion = new MySQLConnection();

        function select(MySQLConnection $conexion): string
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

        function table(MySQLConnection $conexion)
        {
            $sql = "SELECT * FROM oficinas";
            $stmt =  $conexion->query($sql, '', '', false);
            $resultados = $stmt->fetchAll();

            $rows = '';
            foreach ($resultados  as $elementos) {
                $id = $elementos['id'];
                $nombre = $elementos['nombre'];
                $sigla = $elementos['sigla'];
                $jerarquia = $elementos['jerarquia'];
                $rows .= "<tr>";
                $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\"  contenteditable=\"false\">$id</td>";
                $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$nombre</td>";
                $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$sigla</td>";
                $rows .= "<td class=\"text-center\"style=\"max-width: 300px;\" style=\"max-width: 300px;\" contenteditable=\"false\">$jerarquia</td>";
                $rows .= '
                    <td class="text-center align-middle">
                        <i class="fa fa-edit mr-2 edit-icon" style="color:#9c74dd !important"></i>
                        <i class="fa fa-times mr-2 cancel-icon" style="color:#d90a0a !important; display:none;"></i>
                        <i class="fa fa-check save-icon" style="color:#acc90e !important; display:none;"></i>
                    </td>
                ';
                $rows .= "</tr>";
            }

            return $rows;
        }

        $select = select($conexion);
        $table = table($conexion);

        $html = <<<Html
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
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
                            <select id="tipoOrgano" class="form-control select2 select2-hidden-accessible" data-placeholder="Select a State" style="width: 100%; height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true" required>
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
                    <div class="card-body table-responsive p-0 mt-2">
                    <table class="table table-hover table-sm" id="actualizarOficinas">
                        <thead class="bg-warning">
                            <th class="text-center">id</th>
                            <th class="text-center" contenteditable="false">Nombre</th>
                            <th class="text-center">jerarquia</th>
                            <th style="text-center" contenteditable="false">sigla</th>
                            <th style="width: 80px" class="text-center">Editar</th>
                        </thead>
                        <tbody>
                            $table
                        </tbody>
                    </table>
                    </div>  
                </div>
            </div>
        </section>
        <script type="module" src="$ruta"></script>
        <script>
            $(document).ready(function (){
                $.getScript('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', function (){
                   $('#actualizarOficinas').DataTable({
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                        }
                    });
                });
            })
        </script>
        Html;

        $conexion->close();
        return $html;
    }

    public function RegistrarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js';

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
        <div class="card card-primary mt-3 mx-auto">
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
                                <select class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona una oficina" style="width: 100%; 
                                    height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
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
                            <textarea type="text" class="form-control text-content" id="motivo" placeholder="Descripción del motivo de visita"  style="min-height: 100px;
                            max-width: 100%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <script type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function ActualizarVisitas()
    {
        $ruta = $this->rutaAssets  . 'js/visitas.js';
        $conexion = new MySQLConnection();
        $sql = "SELECT id, dni, apellidos_nombres, hora_de_salida, motivo  FROM visitas WHERE hora_de_salida IS NULL ";
        $smt = $conexion->query($sql, '', '', false);
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
            $tablaRow .= "<td class=\"text-center\" style=\"max-width: 300px;\" contenteditable=\"false\">$motivo</td>";
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
            <div class="card-body table-responsive p-2" style="width:100% !important">
                <table class="table table-hover table-md">
                    <thead class="table-bordered" >
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
        <script type ="module" src="$ruta"></script>
        Html;
        return $html;
    }

    public function RegistrarObras()
    {
        $ruta = $this->rutaAssets . 'js/obras.js';
        $conexion = new MySQLConnection();

        $html = <<<Html
        <div class="card card-warning mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Registrar proyecto de inversión pública</h3>
            </div>
            <form id="registrarObras" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="titulo">Título*</label>
                            <input type="text" class="form-control" id="tituloObra" placeholder="Ingrese el título ...">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo de obra">Tipo *</label>
                            <select class="form-control select2 select2-hidden-accessible" data-placeholder="Selecciona un tipo de proyecto de inversión" style="width: 100%; 
                                height: calc(2.25rem + 2px);" tabindex="-1" aria-hidden="true">
                                <option value="Adicionales de obra">Adicionales de obra</option>
                                <option value="Liquidacíon de obras">Liquidacíon de obras</option>
                                <option value="Supervisión de contrataciones">Supervisión de contrataciones</option>
                                <option value="Historico">Historico</option>
                                <option value="Información Adicional">Información Adicional</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="archivoObra">Seleccione un archivo *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivoObra" onchange="document.querySelector('.custom-file-label').innerHTML = this.files[0].name">
                                <label class="custom-file-label" for="archivoObra" data-browse="Elegir archivo">Elegir archivo</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                            <label for="HoraIngreso">Fecha *</label>
                            <input type="date" class="form-control" id="fechaObra" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion">Descripción *</label>
                            <textarea type="text" class="form-control text-content" id="descripcionObra" placeholder="Por favor ingrese una descripción..." style="min-height: 100px; max-width: 100%"></textarea>
                            <div id="contadorPalabras" style="color: red;"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-3">
                    <div class="progress">
                        <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                            0%
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
                </div>
        </form>
        </div>
        <script type ="module" src="$ruta" defer></script>
        Html;

        $conexion->close();
        return $html;
    }

    public function ActualizarObras()
    {
        $ruta = $this->rutaAssets . 'js/obras.js';
        
        $html = <<<Html
        <div class="card card-warning mt-3 mx-auto w-100">
            <div class="card-header">
                <h3 class="card-title">Editar registros</h3>
            </div>
            <div class="container-fluid">
                <h4 class="text-center display-10">Buscando en proyectos de inversión pública</h4>
                <form action="actualizarObras">
                    <div class="row">
                        <div class="col-lg">
                            <div class="row bg-light">
                                <div class="col-12">
                                    <h4><font size="3">Filtros</font></h4>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo:</label>
                                        <select class="select2" style="width: 100%;" id="tipoObraActualizar">
                                            <option value="" selected>Seleccionar un tipo</option>
                                            <option value="Adicionales de obra">Adicionales de obra</option>
                                            <option value="Liquidacíon de obras">Liquidacíon de obras</option>
                                            <option value="Supervisión de contrataciones">Supervisión de contrataciones</option>
                                            <option value="Historico">Historico</option>
                                            <option value="Información Adicional">Información Adicional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Fecha :</label>
                                        <input type="date" class="form-control" id="fechaObraActualizar" value="">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Ordenar:</label>
                                        <select class="select2" style="width: 100%;" id="orderBy">
                                            <option value="" selected>Seleccionar</option>
                                            <option value="DESC">DESC</option>
                                            <option value="ASC">ASC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label class="text-light">a</label>
                                    <div class="form-group align-self-end d-flex">
                                        <button type="button" class="form-control btn btn-primary mr-2" id="aplicarFiltro">Aplicar filtros</button>
                                        <button type="button" class="form-control btn btn-secondary" id="limpiarFiltro">Limpiar filtros</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="input-group input-group-lg">
                                    <input type="search" class="form-control form-control-lg" placeholder="Filtrar por palabra clave" id="palabraClave" value="">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-lg btn-default" id="buscarPalabra">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="spinner" class="mt-1" style="display:none;">
                                    <i class="fa fa-spinner fa-spin"></i> Cargando...
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto" id="respuestaBusqueda">     
            </div>
            <div class="card-body table-responsive p-2 mt-3 mx-auto" id="editarRegistro">    
            </div>
        </div>
        <script  type ="module" src="$ruta"></script>
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
