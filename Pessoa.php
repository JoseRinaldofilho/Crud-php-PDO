<?php


class Pessoa{
    private $pdo;
    // 6 funcoes
    // no contrutor incia a conexao
    public function __construct($dbname,$host,$user,$senha){
        try {
            // 4 informação para o baco
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);

        }catch (PDOException $e){
            echo "Error como banco de dados ".$e->getMessage();// mensagem + variavel
            exit();
        }catch (Exception $e){
            echo "Erro generico: ".$e->getMessage();
            exit();
        }

    }
    // FUNCAO PARA BUSCA OS DADOSE COLOCA NO CANTO DIREITO DA TELA
    public function buscarDados()    {
       $res = [];
       $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
       $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
       return $res;
    }

    //FUNCAO CADASTRA PESSOA
    public function cadastraPessoa($nome, $telefone, $email){
        // primeiro verifica se ela ja foi cadastrada

        $cmd = $this->pdo->prepare("SELECT id from pessoa where email = :e");
        $cmd->bindValue(":e",$email);//bind valor subistitue o valor e coloca variavel
        $cmd->execute();
        if ($cmd->rowCount() > 0){// se for maior que 0 o emial ja exite no banco de dados
            return false;

        }else{// nao achou o email pode cadastra :)
            $cmd = $this->pdo->prepare("INSERT INTO `pessoa` (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd->bindValue(":n",$nome);//bind valor subistitue o valor e coloca variavel
            $cmd->bindValue(":t",$telefone);//bind valor subistitue o valor e coloca variavel
            $cmd->bindValue(":e",$email);//bind valor subistitue o valor e coloca variavel
            $cmd->execute();
            echo "Pessoa cadastrada com Sucesso !!".$nome;
            return true;
        }
    }
    // excluir pessoa
    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM `pessoa` WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
    }


}