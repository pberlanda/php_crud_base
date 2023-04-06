<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

// GET
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    var_dump($id);

    try {
        if ($id != null) {
            if ($objUser->delete($id)) {
                $objUser->redirect('index.php?deleted');
                }
            } else {
                var_dump($id);
            }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

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

                    <?php

                        // gestione delle query variable usate al termine delle operazioni di insert, update e delete
                        
                        // voglio avvertire l'utente quando modifica un utente

                        if (isset($_GET['updated'])) {
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                            <strong>Utente! </strong>modificato
                            <button type="button" class="close" data-dismiss="alert" aria-label="Chiudi">
                            <span aria-hidden="true">&times; </span>
                            </button>
                            </div>';
                        }

                        // voglio avvertire l'utente quando crea un utente

                        if (isset($_GET['inserted'])) {
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                            <strong>Utente! </strong>creato
                            <button type="button" class="close" data-dismiss="alert" aria-label="Chiudi">
                            <span aria-hidden="true">&times; </span>
                            </button>
                            </div>';
                        }

                        // voglio avvertire l'utente quando elimina un utente

                        if (isset($_GET['deleted'])) {
                            echo '<div class="alert alert-info alert-dismissable fade show" role="alert">
                            <strong>Utente! </strong>eliminato
                            <button type="button" class="close" data-dismiss="alert" aria-label="Chiudi">
                            <span aria-hidden="true">&times; </span>
                            </button>
                            </div>';
                        }
                    ?>

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
                            $query = "SELECT * FROM crud_users";
                            $stmt = $objUser->runQuery($query);
                            $stmt->execute();
                            ?> 
                            <tbody>
                                <?php if ($stmt->rowCount() > 0) {

                                    // se ci sono utenti nel db popola la tabella
                                    // PDO = PHP Data Object
                                    // FETCH_ASSOC array indicizzato da nomi colonne

                                    while ($rowUser = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                <!-- aggiungo la riga e per ogni colonna carico i dati di ogni record. Per ora id, nome utente e email -->

                                <tr>

                                    <td><?php print($rowUser['id']); ?></td>
                                
                                    <td>

                                        <!-- aggiungo un link al form.php per la modifica dell'utente. Recupero l'id dell'utente per passarlo a form.php -->

                                        <a href="form.php?edit_id=<?php print($rowUser['id']); ?>"> 
                                        <?php print($rowUser['name']); ?>
                                        </a>
                                    </td>

                                    <td><?php print($rowUser['email']); ?></td>

                                    <td>

                                        <!-- aggiungo un link per aggiungere funzione Elimina. Uso Bootstrap per visualizzare un'icona di un bidone -->

                                        <a class="confirmation" href="index.php?delete_id=<?php print($rowUser['id']); ?>"> 
                                        <span data-feather="trash"></span>
                                        </a>
                                    </td>
                                </tr>

                                <!-- PHP si chiude qui perchè mi serviva accedere agli oggetti PHP fino alla fine del caricamento dei dati letti dal db nella tabella
                                Adesso che il caricamento è finito, posso chiudere PHP aperto a riga 46
                                la prima graffa chiude if riga 46
                                la seconda graffa chiude il while riga 52) -->

                                <?php } }?>

                            </tbody>

                        </table>
                    </div>
                   <!-- aggiungo btn oer creazione utente in fondo alla lista --> 
                    <div>
                        <a class="nav-link" href="form.php">
                            <span data-feather="plus-circle"></span>
                            Aggiungi utente
                        </a>
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
                return confirm('Stai per eliminare un utente, sicuro di voler proseguire?');
            });
        </script>
    </body>
</html>
