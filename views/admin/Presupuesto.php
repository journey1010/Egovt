<?php

require_once(_ROOT_MODEL . 'conexion.php');

class Presupuesto 
{
    public static function viewRegistrarSaldoBalance()
    {
        $ruta = _ROOT_ASSETS_ADMIN .  'js/saldoBalance.js?v=1.1';
        $html = '
            <div class="container card mt-4 px-4 mb-4">
                <form id="saldoBalanceForm" enctype="multipart/form-data">
                    <div class="card-body row">
                        <div class=" col-12 mt-3 mb-">
                            <h3 class="text-monospace">Presupuesto <i class="fas fa-angle-right"></i> Registrar Saldo de Balance</h3>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control title-saldoBalance"maxlength="355" required>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label" for="saldoBlanceFile">Archivo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="saldoBalanceFile" onchange="
                                if (this.files.length > 0) {
                                    document.querySelector(`.custom-file-label`).innerHTML = this.files.length + ` archivos seleccionados`;    
                                } else {
                                    document.querySelector(`.custom-file-label`).innerHTML =  `Seleccione un archivo`
                                } " multiple>
                                <label class="custom-file-label" for="saldoBalanceFile" data-browse="Elegir archivo">Elegir archivo</label>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 form-group">
                            <label class="form-label">Fecha de Saldo de Balance</label>
                            <input type="date" class="form-control date-saldo-balance" aria-label="Fecha de saldo de balance">        
                        </div>
                        <div class="col-md-2 col-sm-6 form-group">
                            <label class="form-label">Boton</label>
                            <button type="submit" class="btn btn-dark form-control btn-saldo-balance">Guardar</button>
                        </div>
                    </div>
                </form>
                <div class="progress mt-2 mb-3">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; border-radius: 10px;">
                        0%
                    </div>
                </div>
            </div>
            <script>
                if (!window.saldoBalanceCargado) {
                    const script = document.createElement("script");
                    script.src = "'.$ruta.'";
                    script.type = "module";
                    document.body.appendChild(script);
                    window.saldoBalanceCargado = true;
                }    
            </script>
        ';
        return $html;
    }

    public static function viewEditarSaldoBalance()
    {
        
    }
}