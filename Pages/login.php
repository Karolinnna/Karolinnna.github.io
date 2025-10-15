<!DOCTYPE html>
<html lang="eng">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Loopi – your favorite place for playlists, artists, and trending music.">
<meta name="keywords" content="music, playlists, artists, charts, Loopi, streaming">
<meta name="author" content="Karol">
<meta name="theme-color" content="#121212">
<title>LOOPI <?= htmlspecialchars($title ?? 'Сторінка', ENT_QUOTES, 'UTF-8') ?></title>
<link rel="icon" href="../Photo/logo.png" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../Styles/style.css">
<link rel="stylesheet" type="text/css" href="../Styles/normalize.css">
</head>
<body class="reg_body">

    <header>
        <a href="#"><img src="../Photo/logo.png" alt="Loopi" class="main_logo" width="70px" height="70px" style="top: 0;"></a>
    </header>
    <section>
            <?php
    // Опрацьовуємо нашу форму
    $login = '';
    $password  = '';
    // Перевіряємо, що запит дійсно POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Отримуємо значення змінних
        $login = trim($_POST['login'] ?? '');
        $password  = trim($_POST['password'] ?? '');
    }
?>
    <form method="POST" action="../index.php">
        <label for="login"></label>
        <input 
            type="text" 
            name="login" 
            id="login" 
            placeholder="login" 
            required
            />
        <label for="password"></label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            placeholder="password" 
            required
        />
        <input class="btn btn-outline-light" type="submit" value="Log in">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </section>
</body>
</html>


