<?php
include 'db.php';

$sql = "SELECT * FROM fotos ORDER BY data_postagem DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mural de Publicações</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilo adicional para a logomarca */
        .logo {
            text-align: center;
            margin: 20px 0;
        }

        .logo img {
            max-width: 200px; /* Ajuste conforme necessário */
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://i.ibb.co/XWssqGr/9d199cac-6751-4eca-9676-187f7409e4d5.jpg" alt="Logomarca">
    </div>

    <h1>Mural de Publicações</h1>

    <div class="gallery">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="photo">';
                echo '<img src="fotos/' . $row["caminho"] . '" alt="' . $row["titulo"] . '">';
                echo '<h2>' . $row["titulo"] . '</h2>';
                echo '<p>' . $row["descricao"] . '</p>';
                echo '<p class="date">Postado em: ' . $row["data_postagem"] . '</p>';
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
