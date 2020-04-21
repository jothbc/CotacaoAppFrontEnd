$(document).ready(() => {
    $.ajax({
        type: 'get',
        url: 'login_page.html',
        success: data=>{
            $('#div1').html(data)
        },
        error: erro=>{
            console.log(erro)
        }
    })

    $('#opcao_2').on('click', function () {
        let opcoes = $('#opcao_1').text();

        $('#div1').fadeOut('slow', () => {
            $('#div1').toggleClass('top bot', 1000)
            $('#div2').toggleClass('top bot', 1000)

            if (opcoes == 'Cliente') {
                $('#opcao_1, #opcao_3').html('Fornecedor')
                $('#opcao_2').html('Cliente <i class="fas fa-angle-right">')
            } else {
                $('#opcao_1, #opcao_3').html('Cliente')
                $('#opcao_2').html('Fornecedor <i class="fas fa-angle-right">')
            }

            $('#div1').fadeIn('slow')
        })

    })
   
})
function inscreverse(){
    $.ajax({
        type: 'get',
        url: 'inscreverse.html',
        success: data=>{
            $('#div1').html(data)
        },
        error: erro=>{
            console.log(erro)
        }
    })
}

function login_page(){
    $.ajax({
        type: 'get',
        url: 'login_page.html',
        success: data=>{
            $('#div1').html(data)
            let opcoes = $('#opcao_1').text();
            if (opcoes == 'Cliente') {
                $('#opcao_1, #opcao_3').html('Cliente')
                $('#opcao_2').html('Fornecedor <i class="fas fa-angle-right">')
            } else {
                $('#opcao_1, #opcao_3').html('Fornecedor')
                $('#opcao_2').html('Cliente <i class="fas fa-angle-right">')
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
