<?php

require_once _ROOT_CONTROLLER .  'viewsRender.php';
require_once _ROOT_MODEL . 'conexion.php';
require_once _ROOT_PATH . '/vendor/autoload.php';

class MainpageController extends ViewRenderer { 
    private $ruta;
    private $conexion;

    public function __construct()
    {
        $this->ruta = _ROOT_ASSETS . 'images/';
        $this->conexion = new MySQLConnection();
    }

    public function show()
    {  
        $this->setCacheDir(_ROOT_CACHE . 'pagina_principal');
        $this->setCacheTime(1); 
        list($titulo, $entrada, $mensaje, $frase, $img, $enlaceVideo) = $this->sectionGobernador();
        $data = [
            'banners' => $this->sectionBanner(),
            'titulo' => $titulo,
            'entrada' => $entrada,
            'mensaje' => $mensaje,
            'frase' => $frase,
            'img' => $this->ruta . $img,
            'enlaceVideo' => $enlaceVideo,
            'pattern' => $this->ruta . 'bgPattern1.png',
            'gobernadorBackground' => $this->ruta . 'gobernadorBackground.webp',
            'año' => date('Y'),
            'ImgInfoLoreto' => $this->ruta . 'bg01.png', 
            'directorio' => $this->sectionDirectorio(),
        ];
        list($modal, $script) = $this->sectionModal();
        if (empty($modal)){
            $data['modal'] = '';
            $data['script'] = '';
        } else {
            $data['modal'] = $modal;
            $data['script'] = $script;
        }

        $dataFooter = [
            'logoWhite' => $this->ruta . 'logoWhite.png',
            'año' => date('Y')
        ];
        $this->render('header', '', false);
        $this->render( 'main', $data, false);
        $this->render('footer', $dataFooter, false);
    }

    private function sectionGobernador(): array
    {
        $sql = "SELECT titulo, entrada, mensaje, frase, img, enlace_video FROM gobernador_paginaprincipal LIMIT 1";
        $stmt = $this->conexion->query($sql, '', '', false);
        $row = $stmt->fetch();
        return array($row['titulo'], $row['entrada'], $row['mensaje'], $row['frase'], $row['img'], $row['enlace_video']);
    }

    private function sectionDirectorio()
    {
        $sql = "SELECT nombre, cargo, imagen, telefono, correo, facebook, twitter, linkedin  FROM directorio_paginaprincipal LIMIT 4";
        $stmt = $this->conexion->query($sql, '', '', false);
        $resultado = $stmt->fetchAll();
        $directorio = '';
        foreach ($resultado as $row) {
            $img = $this->ruta . 'directorio/' . $row['imagen'];
            $directorio .=<<<Html
            <div name="directorio" class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <article class="mccColumn bg-white shadow mb-6 mx-auto mx-sm-0">
                    <div class="imgHolder position-relative">
                        <img src="$img" class="img-thumbnail d-block w-100" alt="{$row['nombre']}" style="width: 282.5px; height: 282.5px;">
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
        return $directorio;
    }

    private function sectionBanner()
    {
        $sql = "SELECT banner, titulo_banner, descripcion_banner FROM banners_paginaprincipal LIMIT 5";
        $stmt = $this->conexion->query($sql, '', '', false);
        $respuesta = $stmt->fetchAll();
        $banner = '';
        foreach($respuesta as $row){
            $img = $this->ruta . 'banners/' . $row['banner'];
            $banner .=<<<Html
            <div>
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
                    <span class="ibBgImage bgCover position-absolute" style="background-image: url($img);"></span>
                </article>
            </div>
            Html;
        }
        return $banner;
    }

    private function sectionModal()
    {
        $sql = "SELECT img, descripcion FROM modal_paginaprincipal";
        $stmt = $this->conexion->query($sql, '', '', false);
        $respuesta = $stmt->fetchAll();
        if(count($respuesta)>= 1){
            $ol = '';
            $carruselItem =  '';
            $contador  = 0;
            foreach($respuesta as $row){
                $img = $this->ruta . 'modal/' . $row['img'];
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
                        <img class='img-size' src='$img' alt='banner' />
                        <div class="carousel-caption">
                            <p>{$row['descripcion']}</p>
                        </div>
                    </div>
                    Html;
                } else {
                    $carruselItem .=<<<Html
                    <div class='carousel-item'>
                        <img class='img-size' src='$img' alt='banner' />
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
            <script>
                $(document).ready(function() {
                    $('#largeModal').modal('show');
                });
            </script>
            html;
        } else {
            $modal = '';
            $script = '';
        }
        return [$modal,$script];
    }
}