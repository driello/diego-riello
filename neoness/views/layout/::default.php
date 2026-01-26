<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>NEONESS</title>
</head>

<body class="bg-dark text-light">

    <header class="container-fluid py-4 bg-warning text-dark">
        <h1 class="text-center display-3 fw-bolder text-uppercase">NEONESS</h1>

    </header>

    <main class="container my-5">
        <div class="p-4 rounded-4 shadow-lg bg-danger text-white">
            <?= $content ?>
        </div>
    </main>

    <footer class="container-fluid bg-warning text-dark py-4 mt-5">
        <h2 class="text-center fw-bold m-0 text-uppercase">NEONESS</h2>
    </footer>

</body>

</html>