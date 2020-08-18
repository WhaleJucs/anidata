<?php
session_start();
if (!$_SESSION['acess']) 
{
    header('Location: http://localhost/anidata/login.php');
}

include 'sql.php';
include 'header.php';

$validImage = ['image/jpeg', 'image.png', 'image.jpg'];
$save;
$msg;

if ($_POST) 
{
    if ($_FILES) 
    {
        if ($_FILES['photo']['error'] == 0) 
        {
            if (array_search($_FILES['photo']['type'], $validImage) == false) 
            {
                $msg = 'Invalid source! <br>';
            }
        } 
        else 
        {
            $query = $db->prepare("INSERT INTO anidata
                (
                    name,
                    description,
                    price,
                    photo
                )
                VALUES
                (
                    :name,
                    :description,
                    :price,
                    :photo
                );");

            $save = $query->execute(
                [
                    ':name' => $_POST['nameProduct'],
                    ':description' => $_POST['description'],
                    ':price' => $_POST['price'],
                    ':photo' => $_FILES['photo']['name']
                ]
            );
            echo "anime successfully uploaded";
            move_uploaded_file($_FILES['photo'][tmp_name], '../anidata/images' . $idImageInsert . '.jpg');
        }
    } else 
    {
        $msg = 'Error <br>';
    }
}

if (isset($save)) 
{
    header('Location: http://localhost/anidata/indexProduto.php');
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
    <div class="container"><br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h5><label class="font-weight-bold" for="nameProduct">Anime</label></h5>
                        <input class="form-control" type="text" name="nameProduct"  required>
                    </div>

                    <div class="form-group">
                        <h5><label class="font-weight-bold" for="description">Sinopse</label></h5>
                        <input class="form-control" type="text" name="description" >
                    </div>

                    <div class="form-group">
                        <h5><label class="font-weight-bold" for="price">Nota</label></h5>
                        <input class="form-control" type="number" name="price" min="0" step=".01" required>
                    </div>

                    <h5><label class="font-weight-bold" for="photo">Foto</label></h5>
                    <input class="form-control-file" type="file" accept="image/jpeg, image/png, image/jpg" name="photo" required>
                    <button class="btn btn-outline-success btn-lg float-right mb-2" type="submit" name="photo">Adicionar Anime</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>