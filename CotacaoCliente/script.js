function marcar(produto_id, fornecedor_id, cliente_id, pedido_id) {
    $.ajax({
        type: 'post',
        url: 'marcar_desmarcar_item.php',
        data: {
            produto_id,
            fornecedor_id,
            cliente_id,
            pedido_id
        },
        success: data => {
            let date = $('#'+produto_id+'_'+fornecedor_id+ ' i')
            if(date.length==1){
                $('#'+produto_id+'_'+fornecedor_id+ ' i').remove();
            }else{
                $('#'+produto_id+'_'+fornecedor_id).append('<i class="far fa-check-square"></i>')
            }
        },
        error: erro => {
            console.log(erro)
        }
    })

}
function fechar_abrir_pedido(cliente_id,pedido_id){
    $.ajax({
        type: 'post',
        url: 'fechar_abrir_pedido.php',
        data: {
            cliente_id,
            pedido_id
        },
        success: data => {
            window.location.reload()
        },
        error: erro => {
           console.log(erro)
        }
    })
}