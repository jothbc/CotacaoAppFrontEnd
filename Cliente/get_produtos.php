<?php
    
    require_once "../../../app_cotacao/Conexao/JDBC.php";
    require_once "../../../app_cotacao/Produto/Produto.model.php";
    require_once "../../../app_cotacao/Produto/Produto.Service.php";

    if(isset($_GET['dado'])){

        // $exp = explode(' ',trim($_GET['dado']));

        // print_r($exp);
        // $list_prioritaria=[];
        // $lista=[];

        // $conexao = new Conexao();
        // $produto = new Produto();
        // $service = new ProdutoService($produto, $conexao);
        // foreach($exp as $index=>$str){

        //     $produto->__set('descricao', $str);
           
        //     $lista[$index] = $service->read('descricao');
        // }
        // echo '<pre>';
        // print_r($lista);
        // echo '/pre>';


        $produto = new Produto();
        $produto->__set('descricao', $_GET['dado']);

        $service = new ProdutoService($produto, new Conexao());
        $lista = $service->read('descricao');
        echo json_encode($lista);
    }
?>
