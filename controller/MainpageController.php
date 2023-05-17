<?php

require_once (_ROOT_CONTROLLER .  'viewsRender.php');
require_once (_ROOT_MODEL . 'conexion.php');
require 'vendor/autoload.php';

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
        list($banner0, $banner1, $banner2, $banner3, $banner4) = $this->sectionBanner();
        $data = [
            'banner0' => $this->ruta . 'banners/' . $banner0,
            'banner1' => $this->ruta . 'banners/' . $banner1,
            'banner2' => $this->ruta . 'banners/' . $banner2,
            'banner3' => $this->ruta . 'banners/' . $banner3,
            'banner4' => $this->ruta . 'banners/' . $banner4,
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

        $dataFooter = [
            'logoWhite' => $this->ruta . 'logoWhite.png',
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
        $sql = "SELECT banner FROM banners_paginaprincipal LIMIT 5";
        $stmt = $this->conexion->query($sql, '', '', false);
        $respuesta = $stmt->fetchAll();
        $banner = [];
        foreach($respuesta as $row){
            $banner[] = $row['banner'];
        }
        return $banner;
    }
}