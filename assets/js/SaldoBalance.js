$('.datepicker').datepicker({
    language: 'es'
});

let button = document.getElementById('searchSaldoBalance');
button.addEventListener('click', () => {
    let startDate = $('.date-start').val();

    $.ajax({
        url: '/transparencia/saldos-balance/buscador-saldo-balance',
        method: 'POST',
        data: {startDate: startDate}, 
        dataType: 'json',
        beforeSend: function(){
            $('#searchSaldoBalance').html(`<i class="icomoon-search"> Buscando</span></i>`);
            $('#spinner').show();
        },
        success: function(resp){   
            if (resp.status === 'success') {
                $('.saldo-balance').html('<div class="datos"></div>');
                if (resp.data != '') {
                    makeElement(resp.data);
                }else {
                    $('.saldo-balance').html('<div class="text-uppercase text-center">Sin registros :(</div>');
                }
            } else {
                $('.saldo-balance').html('');
            }
            $('#searchSaldoBalance').html(`<i class="icomoon-search"><span class="sr-only">Buscar</span></i>`);
            $('.paginador-saldo-balance').remove();
            $('#spinner').hide();
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('#searchSaldoBalance').html(`<i class="icomoon-search"><span class="sr-only">Buscar</span></i>`);
            $('#spinner').hide();
            $('.paginador-saldo-balance').remove();
        }
    });
}); 

function makeElement(dataTable) {
    const html = [];

    dataTable.forEach((data) => {
        const fechaFormat = new Date(data.docs_date);
        const fechaFormatLoad = new Date(data.load_date);
        const formato = new Intl.DateTimeFormat('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
        const fecha = formato.format(fechaFormat).split(' ');
        const partialPath = fechaFormatLoad.toLocaleDateString('en-US', {
            year: 'numeric',
            month: '2-digit',
        }) + '/';
        const files = JSON.parse(data.files);
        const id = data.id;

        const div = `
            <article class="ueEveColumn__list position-relative px-4 py-3 px-lg-8 py-lg-6">
                <div class="d-lg-flex align-items-md-center">
                    <span class="flex-shrink-0 mr-4 mr-lg-6 d-block mb-2 mb-lg-0">Corresponde al : </span>
                    <time class="uecTime text-lDark fontAlter text-uppercase flex-shrink-0 mr-4 mr-lg-6 d-block mb-2 mb-lg-0">
                        <span class="textLarge">${fecha[0]}</span> ${fecha[2]}
                        <span class="d-block textDay fwMedium pt-1">${fecha[4]}</span>
                    </time>
                    <div class="d-md-flex align-items-md-center flex-grow-1">
                        <div class="imgHolder rounded-circle overflow-hidden flex-shrink-0 mr-4 mr-lg-10 mb-1 mb-md-0">
                            <img src="https://regionloreto.gob.pe/assets/images/saldosdebalance.webp" class="img-fluid rounded-circle lozad" alt="icono saldo balance" width="200" height="200">
                        </div>
                        <div class="descrWrap flex-grow-1">
                            <strong class="tagTitle d-block text-secondary fwSemiBold mb-2">Saldo de Balance</strong>
                            <h3 class="fwMedium">
                                <p>${data.title}</p>
                            </h3>
                            <ul class="list-unstyled ueScheduleList mb-0">
                                <li>
                                    <i class="icomoon-clock icn position-absolute"><span class="sr-only">icon</span></i>
                                    Subido : ${data.load_date}
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0);" class="btn btnCustomLightOutline bdrWidthAlter btn-sm text-capitalize position-relative border-0 p-0 flex-shrink-0 ml-md-4" data-hover="Más detalles" data-toggle="collapse" data-target="#data-${id}">
                            <span class="d-block btnText">Ver documentos</span>
                        </a>
                    </div>
                </div>
                <div id="data-${id}" class="collapse">
                    <div class="descrWrap mt-3">
                        <p class="d-block fileSize text-dark card-text mb-1"> <i class="fal fa-file-pdf"></i> Archivos:</p>
                        <div class="row row-cols-3 p-3">
                            ${files.map((file) => `
                                <a href="https://regionloreto.gob.pe/files/transparencia/presupuesto/saldo-balance/${partialPath}${file.file}" class="">${file.namefile}</a>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </article>
        `;

        html.push(div);
    });

    generarPaginador(html);
}
  
function generarPaginador(data) {
    $('.saldo-container').pagination({
        dataSource: data,
        pageSize: 10,
        ulClassName: 'pagination justify-content-center pt-2',
        callback: function(data, pagination) {
            $('.saldo-balance').html(data);
            $('.paginationjs li').addClass('page-item');
            $('.paginationjs a').addClass('page-link');
        },

    });
}