<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

// GET

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
                    <h1 style="margin-top: 10px">DataTable</h1>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th></th> <!-- spazio per le azioni sull'utente -->
                                </tr>
                            </thead>
                           <?php
                            $query="SELECT * FROM crud_users";
                            $stmt=$objUser->runQuery($query);
                            $stmt->execute();
                            ?> 
                            <tbody>
                                <?php if ($stmt->rowCount() > 0) {

                                    // se ci sono utenti nel db popola la tabella
                                    while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                <td><?php print($rowUser['id']); ?></td>

                                <!-- aggiungo un link al form per la modifica dell'utente. Recupero l'id dell'utente per passarlo a form.php -->
                                <td>
                                    <a href="form.php?edit_id=<?php print($rowUser['id']); ?>"> 
                                    <?php print($rowUser['name']); ?>
                                    </a>
                                </td>

                                <td><?php print($rowUser['email']); ?></td>

                                <td>
                                    <a href="index.php?delete_id=<?php print($rowUser['id']); ?>"> 
                                    <span data-feather="trash"></span>
                                    </a>
                                </td>

                            </tbody>
                            <?php } }?>
                        </table>
                    </div> 

                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>

        <!-- Custom scripts -->
        <script>
            // JQuery confirmation
            $('.confirmation').on('click', function () {
                return confirm('Are you sure you want do delete this user?');
            });
        </script>
    </body>
</html>
