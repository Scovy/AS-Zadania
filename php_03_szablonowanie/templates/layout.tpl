<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>{block name='title'}Aplikacja{/block}</title>
    {block name='head'}
        <style>
            body { background: #fff; }
        </style>
        <link rel="stylesheet" href="{$app_url}/assets/styles.css" />
    {/block}
</head>
<body>
    <header>
        <div class="container">
            {block name='header'}
                <div class="brand">Kalkulator</div>
                <nav>
                    <a href="{$app_url}/index.php">Strona główna</a>
                    <a href="{$app_url}/app/calc_view.php">Kalkulator</a>
                    {if $user != 'gość'}
                        <a href="{$app_url}/security/logout.php">Wyloguj</a>
                    {else}
                        <a href="{$app_url}/security/login_view.php">Zaloguj</a>
                    {/if}
                </nav>
            {/block}
        </div>
    </header>
    <main>
        <div class="container">
        {block name='content'}
            <p>Treść domyślna</p>
        {/block}
        </div>
    </main>
    <footer>
        <div class="container">
        {block name='footer'}
            <p>Michał Haładus &copy; 2025</p>
        {/block}
        </div>
    </footer>
</body>
</html>
