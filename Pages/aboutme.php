<?php
/**
 * Шаблон Pages/aboutme.php
 *
 * Очікувані змінні з контролера:
 * @var string $name
 * @var string $bio
 * @var array  $skills
 * @var bool   $isAuthenticated
 *
 * Шаблон відповідає за безпечний вивід (html-екранівка).
 */
if (!isset($name)) $name = '';
if (!isset($bio)) $bio = '';
if (!isset($skills) || !is_array($skills)) $skills = [];
if (!isset($isAuthenticated)) $isAuthenticated = false;

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <title>Про мене — <?= e($name) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; max-width:900px; margin:30px auto; padding:0 18px; color:#222; }
        header { border-bottom:1px solid #ddd; margin-bottom:18px; padding-bottom:12px; }
        h1 { margin:0 0 6px; }
        .meta { color:#666; margin-bottom:18px; }
        ul.skills { list-style: none; padding:0; display:flex; gap:8px; flex-wrap:wrap; }
        ul.skills li { background:#f0f0f0; padding:6px 10px; border-radius:6px; }
        .actions { margin-top:20px; }
        a.button { background:#007bff; color:#fff; padding:8px 12px; text-decoration:none; border-radius:6px; }
    </style>
</head>
<body>
    <header>
        <h1>Про мене — <?= e($name) ?></h1>
        <div class="meta">
            <?= $isAuthenticated ? 'Ви увійшли як <strong>' . e($_SESSION['login'] ?? $_COOKIE['login'] ?? '') . '</strong>' : 'Гість' ?>
        </div>
    </header>

    <section>
        <h2>Коротко</h2>
        <p><?= nl2br(e($bio)) ?></p>
    </section>

    <section>
        <h2>Навички</h2>
        <?php if (count($skills) === 0): ?>
            <p>Навичок не вказано.</p>
        <?php else: ?>
            <ul class="skills">
                <?php foreach ($skills as $skill): ?>
                    <li><?= e($skill) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <div class="actions">
        <a class="button" href="<?= htmlspecialchars($GLOBALS['basePath'] ?? '/', ENT_QUOTES) ?>">На головну</a>
        <?php if ($isAuthenticated): ?>
            <a class="button" href="<?= htmlspecialchars(($GLOBALS['basePath'] ?? '') . '/logout', ENT_QUOTES) ?>" style="background:#6c757d; margin-left:8px;">Вийти</a>
        <?php else: ?>
            <a class="button" href="<?= htmlspecialchars(($GLOBALS['basePath'] ?? '') . '/login', ENT_QUOTES) ?>" style="background:#28a745; margin-left:8px;">Увійти</a>
        <?php endif; ?>
    </div>
</body>
</html>
