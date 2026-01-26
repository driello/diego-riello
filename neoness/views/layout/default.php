<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    <title>NEONESS</title>
</head>

<body class="bg-light text-dark">

    <header class="container-fluid py-4 bg-primary text-white">
        <h1 class="text-center display-4 fw-bold text-uppercase m-0">
            NEONESS
        </h1>
    </header>


    <main class="container my-5">
        <div class="p-4 rounded-4 shadow bg-white text-dark">
            <?= $content ?>
        </div>
    </main>

    <footer class="container-fluid bg-primary text-white py-3 mt-5">
        <h2 class="text-center fw-semibold m-0 text-uppercase">NEONESS</h2>
    </footer>

</body>

</html>
