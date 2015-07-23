<? 
    include('conexao.php'); 
    $id               = $_GET['id'];
    $acao             = $_GET['acao'];
    if($acao == "editar"){
        $sql          = mysql_query("SELECT * FROM conteudo WHERE id = '$id'");
        $resultado    = mysql_fetch_array($sql);
        $titulo       = $resultado['titulo'];
        $texto        = $resultado['texto'];
        $selecsessao  = $resultado['id_sessao'];
    }
    if($_POST['novo']){
        $titulo = $_POST['titulo'];
        $texto  = $_POST['texto'];
        $sessao = $_POST['sessao'];
        $sql    = mysql_query("INSERT INTO conteudo (titulo, texto, id_sessao) VALUES ('$titulo', '$texto', '$sessao')");
        header('Location: conteudo.php');
        exit();
    }
    if($acao == "excluir"){
        $sql = mysql_query("DELETE FROM sessao where id = '$id'");
        header('Location: sessao.php');
        exit();
    }
    if($_POST['atualizar']){
        $nome = $_POST['nome'];
        $sql  = mysql_query("UPDATE sessao SET nome = '$nome' WHERE id = '$id'");
        header('Location: sessao.php');
        exit();
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
                <h1 class="page-header">Conteúdo</h1>
            </div>
        </div>
        <a href="conteudo.php?acao=novo"><input type="buttom" class="btn btn-success pull-right" value="Novo"></a><br><br>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Conteúdo
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Sessão</th>
                                            <th>Titulo</th>
                                            <th>Texto</th>
                                            <th>Data</th>
                                            <th width="10px">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $sql = mysql_query("SELECT * FROM conteudo");
                                        if($sql > 0){
                                            while($resultado = mysql_fetch_array($sql)){
                                                $idsesao   = $resultado['id_sessao'];
                                                $seleciona = mysql_query("SELECT * FROM sessao where id = '$idsesao'");
                                                $sessao    = mysql_fetch_array($seleciona);
                                                echo'
                                                    <tr>
                                                        <td>'.$resultado['id'].'</td>
                                                        <td>'.$sessao['nome'].'</td>
                                                        <td>'.$resultado['titulo'].'</td>
                                                        <td>'.$resultado['texto'].'</td>
                                                        <td>'.$resultado['data_gerado'].'</td>
                                                        <td><center><a href="conteudo.php?acao=editar&id='.$resultado['id'].'"><i class="fa fa-pencil fa-wd"></i></a> <a href="conteudo.php?acao=excluir&id='.$resultado['id'].'"><i class="fa fa-remove fa-wd"></i></a></center></td>
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
                <form method="POST" action="" name="formu">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Editar</h1>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label>Sessão</label>
                        <select class="form-control" name="sessao">
                            <?
                                $selec = mysql_query("SELECT * FROM sessao");
                                while($recebe = mysql_fetch_array($selec)){
                                    echo'<option '.(($selecsessao == $recebe['id'])?'selected="selected"':'').' value="'.$recebe['id'].'">'.$recebe['nome'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Título</label>
                        <input type="text" class="form-control" name="titulo" value="<?=$titulo;?>">
                    </div>
                    <div class="col-lg-4">
                        <label>Texto</label>
                        <textarea name="texto" class="form-control"><?=$texto?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-success" value="Atualizar" name="atualizar">
                    </div>
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
                <form method="POST" action="" name="form">
                <div class="row">
                    <div class="col-lg-4">
                        <label>Sessão</label>
                        <select class="form-control" name="sessao">
                            <?
                                $selec = mysql_query("SELECT * FROM sessao");
                                while($recebe = mysql_fetch_array($selec)){
                                    echo'<option value="'.$recebe['id'].'">'.$recebe['nome'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label>Título</label>
                        <input type="text" class="form-control" name="titulo" value="<?=$nome;?>">
                    </div>
                    <div class="col-lg-4">
                        <label>Texto</label>
                        <textarea name="texto" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-success" value="Adicionar" name="novo">
                    </div>
                </div>
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
