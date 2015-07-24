<? 
    include('conexao.php'); 
    include('Upload.php'); 
    $id               = $_GET['id'];
    $acao             = $_GET['acao'];
    if($acao == "editar"){
        $sql          = mysql_query("SELECT * FROM midia WHERE id = '$id'");
        $resultado    = mysql_fetch_array($sql);
        $idsessao     = $resultado['id_sessao'];
        $idconteudo   = $resultado['id_conteudo'];
        $img          = $resultado['img'];
        $tipo         = $resultado['tipo'];
    }
    if($_POST['novo']){
        $arquivo      = SobeImagem($_FILES['img']['name'], $_FILES['img']['tmp_name'], "imagens/");
        $id_sessao    = $_POST['idsessao'];
        $id_conteudo  = $_POST['idconteudo'];
        $tipo         = $_POST['tipo'];
        $data_gerado  = date("Y-m-d");   

        $sql          = mysql_query("INSERT INTO midia (id_sessao, id_conteudo, img, tipo, data_gerado) VALUES ('$id_sessao', '$id_conteudo', '$arquivo', '$tipo', '$data_gerado')");
        header('Location: midia.php');
        exit();
    }
    if($acao == "excluir"){
        $sel    = mysql_query("SELECT * FROM midia WHERE id = '$id'");
        $result = mysql_fetch_array($sel);
        $remove = RemoveImagem("imagens/".$result['img']);
        if($remove){
            $sql = mysql_query("DELETE FROM midia WHERE id = '$id'");
            header('Location: midia.php');
            exit();
        }else{
            echo "viado";
        } 
    }
    if($_POST['atualizar']){
        if($_FILES['img'] == ""){
            $id_sessao    = $_POST['idsessao'];
            $id_conteudo  = $_POST['idconteudo'];
            $sql  = mysql_query("UPDATE midia SET id_sessao = '$idsessao', id_conteudo = '$id_conteudo', tipo = '$tipo' WHERE id = '$id'");
            header('Location: midia.php');
            exit();
        }
        if($_FILES['img'] != ""){
            $id_sessao    = $_POST['idsessao'];
            $id_conteudo  = $_POST['idconteudo'];
            $sel    = mysql_query("SELECT * FROM midia WHERE id = '$id'");
            $result = mysql_fetch_array($sel);
            $remove = RemoveImagem("imagens/".$result['img']);
            $arquivo      = SobeImagem($_FILES['img']['name'], $_FILES['img']['tmp_name'], "imagens/");
            $sql  = mysql_query("UPDATE midia SET id_sessao = '$idsessao', id_conteudo = '$id_conteudo', img = '$arquivo', tipo = '$tipo' WHERE id = '$id'");
            header('Location: midia.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Painel</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <? include('topo.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Midia</h1>
            </div>
        </div>
        <a href="midia.php?acao=novo"><input type="buttom" class="btn btn-success pull-right" value="Novo"></a><br><br>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Midia
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Sessão</th>
                                            <th>Tipo</th>
                                            <th>Data</th>
                                            <th width="10px">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $sql = mysql_query("SELECT * FROM midia");
                                        if($sql > 0){
                                            while($resultado = mysql_fetch_array($sql)){
                                                $idsesao   = $resultado['id_sessao'];
                                                $seleciona = mysql_query("SELECT * FROM sessao where id = '$idsesao'");
                                                $sessao    = mysql_fetch_array($seleciona);
                                                echo'
                                                    <tr>
                                                        <td>'.$resultado['id'].'</td>
                                                        <td>'.$sessao['nome'].'</td>
                                                        <td>'.$resultado['tipo'].'</td>
                                                        <td>'.$resultado['data_gerado'].'</td>
                                                        <td><center><a href="midia.php?acao=editar&id='.$resultado['id'].'"><i class="fa fa-pencil fa-wd"></i></a> <a href="midia.php?acao=excluir&id='.$resultado['id'].'"><i class="fa fa-remove fa-wd"></i></a></center></td>
                                                    </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <? if($acao == "editar"){ ?>
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="" name="formu" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Editar</h1>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label>Sessão</label>
                        <select class="form-control" name="idsessao">
                            <?
                                $selec = mysql_query("SELECT * FROM sessao");
                                while($recebe = mysql_fetch_array($selec)){
                                    echo'<option '.(($idsessao == $recebe['id'])?'selected="selected"':'').' value="'.$recebe['id'].'">'.$recebe['nome'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Conteudo</label>
                        <select class="form-control" name="idconteudo">
                            <?
                                $selecao = mysql_query("SELECT * FROM conteudo");
                                while($receber = mysql_fetch_array($selecao)){
                                    echo'<option '.(($idconteudo == $receber['id'])?'selected="selected"':'').' value="'.$receber['id'].'">'.$receber['titulo'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Tipo</label>
                        <input type="text" class="form-control" name="tipo" value="<?=$tipo;?>">
                    </div>
                    <div class="col-lg-3">
                        <label>Imagem</label><br>
                        <img src="imagens/<?=$img?>" width="235px">
                        <input type="file" name="img" class="form-control">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-success" value="Atualizar" name="atualizar">
                    </div><br><br>
                </div>
            </form>
            </div>
        </div>
        <? } ?> 
        <? if($acao == "novo"){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Adicionar</h1>
                        <hr>
                    </div>
                </div>
                <form method="POST" action="" name="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Sessão</label>
                        <select class="form-control" name="idsessao">
                            <?
                                $selec = mysql_query("SELECT * FROM sessao");
                                while($recebe = mysql_fetch_array($selec)){
                                    echo'<option value="'.$recebe['id'].'">'.$recebe['nome'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Conteudo</label>
                        <select class="form-control" name="idconteudo">
                            <?
                                $selec = mysql_query("SELECT * FROM conteudo");
                                while($recebe = mysql_fetch_array($selec)){
                                    echo'<option value="'.$recebe['id'].'">'.$recebe['titulo'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Tipo</label>
                        <select class="form-control" name="tipo">
                            <option value="foto">Foto</option>
                            <option value="video">Vídeo</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Imagem</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-success" value="Adicionar" name="novo">
                    </div>
                </div><br><br>
                </form>
            </div>
        </div>
        <? } ?> 
    </div>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="bower_components/raphael/raphael-min.js"></script>
    <script src="bower_components/morrisjs/morris.min.js"></script>
    <script src="js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
