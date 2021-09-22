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
if (isset($_POST['telefone'])){
    //nao devemso busca direto usa addslashes

    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $pessoa->cadastraPessoa($nome,$telefone,$email);
    //deixa o preenchimeno obrigatorio
    // se nao tiver vazio nome e telefone e email

//    if (empty($nome) && empty($telefone) && empty($email))
//    {
//        $pessoa->cadastraPessoa($nome,$telefone, $email);
//    }
}
?>
<section id="esquerda">

    <form method="post">
        <h2>Cadastra pessoa</h2>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>

        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <input type="submit" value="Cadastra">

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
                echo "<td><a href=''>Editar </a> <a href=''>Excluir</a> </td>";
                echo "</tr>";
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