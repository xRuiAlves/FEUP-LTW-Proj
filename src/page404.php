<?php include('./templates/header.php') ?>

<style>
    .error-section {
        text-align: center;
    }

    .error-section p {
        margin: 0;
        font-size: 2.2em;
        color: var(--color-grey-dark);
    }

    .error-code {
        color: var(--main-color-dark);
        font-size: 12em;
        margin-top: 0.5em;
        font-weight: bold;
    }
</style>

<section class="error-section">
    <header class="error-code">
        404
    </header>
    <p>
        Page not found
    </p>
</section>

<?php include('./templates/footer.php') ?>