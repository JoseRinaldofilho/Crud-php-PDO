<?php
require_once 'Pessoa.php';
$pessoa = new Pessoa("crudpdo","localhost","root","");
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="estilo.css">
    <title>crud pessoa </title>
</head>
<body>
<?php
if (isset($_POST['telefone'])){ // ckicou no botao cadastra ou no botao atualizar
    //nao devemso busca direto usa addslashes
      //--------------- editar -----------------
    if (isset($_GET['id_up']) && !empty($_GET['id_up']))
    {
        $id_update= addslashes($_GET['id_up']);
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);

        if (!empty($nome) && !empty($telefone) && !empty($email))
        {
            $pessoa->atualizarDados($id_update,$nome,$telefone, $email);
            header("location: index.php");
        }
    }


    ///------------------------cadastra-------------------------------
    else
    {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);

        //  $pessoa->cadastraPessoa($nome,$telefone,$email);

        //deixa o preenchimeno obrigatorio
        // se nao tiver vazio nome e telefone e email

        if (!empty($nome) && !empty($telefone) && !empty($email))
        {
            $pessoa->cadastraPessoa($nome,$telefone, $email);

        }

    }



}
?>
<?php
    if (isset($_GET['id_up'])){//se a pessoa clicou no botao editar

        $id_up = addslashes($_GET['id_up']);
        $res = $pessoa->buscaDadosPessoa($id_up);

    }

?>


<section id="esquerda">

    <form method="post">
        <h2>Cadastra pessoa</h2>
        <label for="nome">Nome</label>
        <input type="text" value="<?php if (isset($res)){
            echo $res['nome']; } ?>"
       name="nome" id="nome" required>

        <label for="telefone">Telefone</label>
        <input type="text"
               value="<?php if (isset($res)){
                   echo $res['telefone']; } ?>"
               name="telefone" id="telefone" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required
               value="<?php if (isset($res)){echo $res['email']; } ?>"
        >
        <input style="background-color: aqua"  type="submit"
               value="<?php if (isset($res)){ echo "Atualizar";}else{
                   echo "Cadastrar";
               } ?>">


    </form>

</section>
<section id="direita">

    <table>
        <tr id="titulo"><!--linha -->
            <td>NOME</td>
            <td>TELEFONE</td>
            <td colspan="2">EMAIL</td>
        </tr>

    <?php
        $dados = $pessoa->buscarDados();
        if (count($dados) > 0){// se tiver pessoa cadastrada

            for ($i=0, $iMax = count($dados); $i < $iMax; $i++){
                echo "<tr>";

                foreach ($dados[$i] as $k => $v) {
                    if ($k != "id"){

                        echo "<td>$v</td>";

                    }//fim if
                    
               }//fim do forech
                ?>
                <td>
                    <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                     <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>

                </td>

                <?php
            }//fim do for
            // se esta vazio
        }else{
            echo "Ainda não a Pessoas cadastrada";
        }
        //fim do ife
    ?>

<!--        <tr>-->
<!--            <td>maria</td>-->
<!--            <td>125451</td>-->
<!--            <td>mm@mm</td>-->

<!--        </tr>-->

    </table>
</section>
<?php

?>
</body>
</html>
<?php
    if (isset($_GET['id'])){

        $idPessa = addslashes($_GET['id']);
        $pessoa->excluirPessoa($idPessa);
        header("location: index.php");

    }
?>