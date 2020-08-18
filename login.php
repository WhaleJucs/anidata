<?php
session_start();
unset($_SESSION['acesso']);

include 'sql.php';

$query = $db->prepare("SELECT * FROM usuarios;");
$query->execute();
$acess = $query->fetchALL(PDO::FETCH_ASSOC);

if ($_POST) 
{
    foreach ($acess as $acesso) 
    {
        if ($_POST['emailLogin'] == $acesso['EMAIL']) 
        {
            if (password_verify($_POST['passwordLogin'], $acesso['SENHA'])) 
            {
                $_SESSION['acesso'] = $acesso['NOME'];
                header('Location: http://localhost/anidata/indexProduto.php');
            }
        }
    }

    $erro = 'Usuario ou senha incorretos';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anidata</title>
</head>

<body class="text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="user" class="font-weight-bold">Nome de usuário</label>
                        <input id="user" name="emailLogin" type="text" class="input" required>
                    </div>
                    <div class="group">
                        <label for="pass" class="font-weight-bold">Senha</label>
                        <input id="pass" name="passwordLogin" type="password" class="input" data-type="password" required>
                        <?php if (isset($erro)) : ?>
                            <div class="alert alert-info" role="alert">
                                <p><?= $erro ?></p>
                            </div> <?php endif; ?>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Login">
                    </div>
                    <div class="hr"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>