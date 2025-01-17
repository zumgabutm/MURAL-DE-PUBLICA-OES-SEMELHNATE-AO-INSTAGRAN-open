<?php
include 'db.php';

// Adicionando foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $caminho = '';

    if (!empty($_FILES['arquivo']['name'])) {
        $caminho = basename($_FILES['arquivo']['name']);
        $target_dir = "fotos/";
        $target_file = $target_dir . $caminho;

        if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $target_file)) {
            echo "Erro ao fazer upload do arquivo.";
            exit;
        }
    } else if (!empty($_POST['link'])) {
        $caminho = $_POST['link'];
    }

    if ($titulo && $descricao && $caminho) {
        $sql = "INSERT INTO fotos (titulo, descricao, caminho) VALUES ('$titulo', '$descricao', '$caminho')";

        if ($conn->query($sql) === TRUE) {
            echo "Foto adicionada com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Editando foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $caminho = $_POST['caminho_atual'];

    if (!empty($_FILES['arquivo']['name'])) {
        $caminho = basename($_FILES['arquivo']['name']);
        $target_dir = "fotos/";
        $target_file = $target_dir . $caminho;

        if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $target_file)) {
            echo "Erro ao fazer upload do arquivo.";
            exit;
        }
    } else if (!empty($_POST['link'])) {
        $caminho = $_POST['link'];
    }

    $sql = "UPDATE fotos SET titulo='$titulo', descricao='$descricao', caminho='$caminho' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Foto editada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Removendo foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM fotos WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Foto removida com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$sql = "SELECT * FROM fotos ORDER BY data_postagem DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração do Mural</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Administração do Mural</h1>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="add" value="1">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <label for="link">Link da Imagem:</label>
        <input type="text" id="link" name="link">

        <label for="arquivo">Ou Upload da Imagem:</label>
        <input type="file" id="arquivo" name="arquivo">

        <button type="submit">Adicionar Foto</button>
    </form>

    <h2>Fotos Publicadas</h2>
    <div class="gallery">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="photo">';
                echo '<img src="fotos/' . $row["caminho"] . '" alt="' . $row["titulo"] . '">';
                echo '<h2>' . $row["titulo"] . '</h2>';
                echo '<p>' . $row["descricao"] . '</p>';
                echo '<p class="date">Postado em: ' . $row["data_postagem"] . '</p>';
                echo '<form action="admin.php" method="post">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<input type="hidden" name="caminho_atual" value="' . $row["caminho"] . '">';
                echo '<label for="titulo">Título:</label>';
                echo '<input type="text" name="titulo" value="' . $row["titulo"] . '" required>';
                echo '<label for="descricao">Descrição:</label>';
                echo '<textarea name="descricao" required>' . $row["descricao"] . '</textarea>';
                echo '<label for="link">Link da Imagem:</label>';
                echo '<input type="text" name="link" value="' . $row["caminho"] . '">';
                echo '<label for="arquivo">Ou Upload da Imagem:</label>';
                echo '<input type="file" name="arquivo">';
                echo '<button type="submit" name="edit">Editar</button>';
                echo '<button type="submit" name="delete">Remover</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhuma foto publicada.</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
