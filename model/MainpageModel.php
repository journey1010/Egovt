<?php

require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_PATH . '/vendor/autoload.php';

use React\Promise\Promise;
use React\Async;

class MainpageModel {
    public static function builder()
    {   
        $conexion = new MySQLConnection();
        
        $Banner = self::sectionBanner($conexion);
        $Gobernador = self::sectionGobernador($conexion);
        $Directorio = self::sectionDirectorio($conexion);
        $Convocatoria = self::sectionConvocatoria($conexion);
        $Modal = self::sectionModal($conexion);
        
        $promises = React\Promise\all([$Banner, $Gobernador, $Directorio, $Convocatoria, $Modal]);

        try {
            $results = React\Async\await($promises);
            return [$results[0], $results[1], $results[2], $results[3], $results[4]];
        } catch (Throwable $error) {
            $errorMessage = date("Y-m-d H:i:s") . " : " . $error .  ', info: fallo en las promesas de la pagina principal'."\n";
            error_log($errorMessage, 3, _ROOT_PATH . '/log/error.log' );
            return ['', '', '', '', ''];
        }
    }
    

    private static function sectionGobernador(MySQLConnection $conexion)
    {
        return new Promise(function($resolve, $reject) use ($conexion) {
            $sql = "SELECT titulo, entrada, mensaje, frase, img, enlace_video FROM gobernador_paginaprincipal LIMIT 1";
            $stmt = $conexion->query($sql, '', '', false);
            if($stmt){
                $row = $stmt->fetch();
                $resolve(array($row['titulo'], $row['entrada'], $row['mensaje'], $row['frase'], $row['img'], $row['enlace_video']));
            } else {
                $reject('Error al ejecutar consulta sql: '. $sql);
            }
        });
    }

    private static function sectionDirectorio(MySQLConnection $conexion)
    {
        return new Promise(function($resolve, $reject) use ($conexion){
            $sql = "SELECT nombre, cargo, imagen, telefono, correo, facebook, twitter, linkedin  FROM directorio_paginaprincipal LIMIT 4";
            $stmt = $conexion->query($sql, '', '', false);
            if($stmt){
                $resultado = $stmt->fetchAll();
                $directorio = '';
                foreach ($resultado as $row) {
                    $img =_ROOT_ASSETS . 'images/directorio/' . $row['imagen'];
                    $directorio .=<<<Html
                    <div name="directorio" class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <article class="mccColumn bg-white shadow mb-6 mx-auto mx-sm-0">
                            <div class="imgHolder position-relative">
                                <img loading="lazy" src="$img" class="img-thumbnail d-block w-100" alt="{$row['nombre']}" style="width: 282.5px; height: 282.5px;">
                                <div class="mcssHolder">
                                    <ul class="mcssList list-unstyled rounded-pill bg-white overflow-hidden p-0 m-0 d-flex">
                                        <li>
                                            <a href="{$row['twitter']}"alt="Twitter" class="mcssLink" title="Twitter"><i class="fab fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="{$row['facebook']}" alt="facebook" class="mcssLink" title="Facebook"><i class="fab fa-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="{$row['linkedin']}" alt="linkedin" class="mcssLink" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mcCaptionWrap px-5 pt-5 pb-4 position-relative">
                                <h3 class="fwMedium h3Small mb-1">{$row['nombre']}</h3>
                                <h4 class="fwSemiBold fontBase text-secondary">{$row['cargo']}</h4>
                                <hr class="mccSeprator mx-0 mt-4 mb-3">
                                <ul class="list-unstyled mccInfoList">
                                    <li>
                                        <a href="{$row['correo']}">
                                            <i class="fas fa-envelope icn"><span class="sr-only">icon</span></i>
                                            {$row['correo']}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="tel:{$row['telefono']}">
                                            <i class="fas fa-phone-alt icn"><span class="sr-only">icon</span></i>
                                            {$row['telefono']}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    Html;
                }
                $resolve($directorio);
            } else {
                $error  = new Error('Error al ejecutar consulta: '. $sql);
                $reject($error);
            }
        });
    }

    private static function sectionBanner(MySQLConnection $conexion)
    {
        return new Promise( function ($resolve, $reject) use ($conexion) {
            $sql = "SELECT banner, titulo_banner, descripcion_banner FROM banners_paginaprincipal LIMIT 5";
            $stmt = $conexion->query($sql, '', '', false);
            if($stmt){
                $respuesta = $stmt->fetchAll();
                $banner = '';
                foreach($respuesta as $row){
                    $img = _ROOT_ASSETS . 'images/banners/' . $row['banner'];
                    $banner .=<<<Html
                        <article class="d-flex w-100 position-relative ibColumn text-white overflow-hidden">
                            <div class="alignHolder d-flex align-items-center w-100">
                                <div class="align w-100 pt-20 pb-20 pt-md-40 pb-md-30 px-md-17">
                                    <div class="container position-relative">
                                        <div class="row">
                                            <div class="col-12 col-md-9 col-xl-7 fzMedium">
                                                <h1 class="text-white mb-4 h1large">{$row['titulo_banner']}</h1>
                                                <p>{$row['descripcion_banner']}</p>
                                                <a href="https://www.gob.pe/regionloreto" class="btn btnTheme font-weight-bold btnMinSm text-capitalize position-relative border-0 p-0 mt-6" data-hover="Descubre más">
                                                    <span class="d-block btnText">Descubre más</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="ibBgImage bgCover position-absolute lozad" style="background-image: url($img);"></span>
                        </article>
                    Html;
                }
                $resolve($banner);
            } else {
                $reject('Error al ejecutar consulta :' .$sql);
            }
        });
    }

    private static function sectionModal(MySQLConnection $conexion)
    {
        return new Promise(function($resolve, $reject) use ($conexion){
            $sql = "SELECT img, descripcion FROM modal_paginaprincipal";
            $stmt = $conexion->query($sql, '', '', false);
            if($stmt){
                $respuesta = $stmt->fetchAll();
                if(count($respuesta)>= 1){
                    $ol = '';
                    $carruselItem =  '';
                    $contador  = 0;
                    foreach($respuesta as $row){
                        $img =_ROOT_ASSETS . 'images/modal/' . $row['img'];
                        if($contador == 0){
                            $ol .=<<<Html
                            <li data-target='#carouselExampleIndicators' data-slide-to='$contador' class='active'></li>
                            Html;
                        } else {
                            $ol .=<<<Html
                            <li data-target='#carouselExampleIndicators' data-slide-to='$contador'></li>
                            Html;
                        }
        
                        if($contador == 0){
                            $carruselItem .=<<<Html
                            <div class='carousel-item active'>
                                <img class='img-size'  src='$img' alt='banner' />
                                <div class="carousel-caption">
                                    <p>{$row['descripcion']}</p>
                                </div>
                            </div>
                            Html;
                        } else {
                            $carruselItem .=<<<Html
                            <div class='carousel-item'>
                                <img class='img-size lozad' src='$img' alt='banner' />
                                <div class="carousel-caption">
                                    <p>{$row['descripcion']}</p>
                                </div>
                            </div>
                            Html;
                        }
                        $contador++;
                    }
                    $modal = <<<html
                    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body d-flex justify-content-center p-0">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            $ol
                                        </ol>
                                        <div class="carousel-inner">
                                             $carruselItem
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color:#06163A">
                                    <a class="stretched-link text-white" href="javascript:void(0)" data-dismiss="modal"><i class="fas fa-window-close fa-lg" style="color: #d41142;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    html;
                    $script = <<<html
                    <script defer>
                            $('#largeModal').modal('show');
                    </script>
                    html;
                } else {
                    $modal = '';
                    $script = '';
                }
                $ModalScript =  [$modal,$script];
                $resolve($ModalScript);
            } else {
                $reject('Error al ejecutar consulta sql: '. $sql);
            }
        });
    }

    private static function sectionConvocatoria(MySQLConnection $conexion)
    {
        return new Promise(function($resolve, $reject) use ($conexion){
            $sql = "SELECT conv.titulo AS titulo, conv.descripcion AS descripcion, conv.estado AS estado, 
            conv.fecha_limite AS fecha_limite , conv.dependencia AS nombre FROM convocatorias AS conv 
            ORDER BY conv.estado ASC, conv.fecha_registro DESC
            LIMIT 3";

            $stmt = $conexion->query($sql, '', '', false);
            if($stmt){
                $resultado = $stmt->fetchAll();
                $convocatoria = '';
                foreach($resultado as $row){
                    $fechaFormat = DateTime::createFromFormat('Y-m-d', $row['fecha_limite']);
                    $formato = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $fecha = $formato->format($fechaFormat);
                    $maxLength = 80; 
                    $nombre = $row['nombre']; 
                    if (strlen($nombre) > $maxLength) {
                        $nombre = substr($nombre, 0, $maxLength) . ' ...'; 
                    }
                    $convocatoria .= <<<Html
                    <div class="col-12 col-md-6 col-xl-4 d-flex">
                        <article class="npbColumn shadow bg-white mb-6">
                            <div class="imgHolder position-relative">
                                <time datetime="2011-01-12" class="npbTimeTag font-weight-bold fontAlter position-absolute text-white px-2 py-1">$fecha</time>
                            </div>
                            <div class="npbDescriptionWrap px-5 pt-8 pb-5">
                                <h3 class="fwSemiBold mb-6">
                                    <a href="/transparencia/convocatorias-de-trabajo">{$row['titulo']}</a>
                                </h3>
                                <ul class="list-unstyled ueScheduleList mb-0">
                                    <li>
                                    <i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                                    Fecha Límite de Postulación: $fecha
                                    </li>
                                    <li>
                                    <i class="icomoon-location icn position-absolute"><span class="sr-only">icon</span></i>
                                       <strong> Entidad : $nombre </strong>
                                    </li>
                                </ul>                   
                            </div>
                        </article>
                    </div>
                    Html;
                }
                $resolve($convocatoria);
            } else {
                $reject('Error al ejecutar consulta sql: '. $sql);
            }
        });
    }
}