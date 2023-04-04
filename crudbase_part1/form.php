<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// GET


// POST

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php'; ?>
    </head>
    <body>
        <!-- Header banner -->
        <?php require_once 'includes/header.php'; ?>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar menu -->
                <?php require_once 'includes/sidebar.php'; ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <h1 margin-top: 10px>Aggiungi / Modifica utenti</h1>
                    <p>valori richiesti *</p>
                    <form method="post">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input class="form-control" type="text" name="id" id="id" id value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input class="form-control" type="text" name="name" id="name" id value="" placeholder="nome e cognome" required maxlength="100">
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input class="form-control" type="text" name="email" id="email" id value="" placeholder="guidolape@email.com" maxlength="100">
                        </div>
                    </form>

                    <input class="btn btn-primary mb-2" type="button" name="btn_save" value="Salva">
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
    </body>
</html>
