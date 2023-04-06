<?php
// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/user.php';

$objUser = new User();

// GET
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt = $objUser->runQuery("SELECT * FROM crud_users WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = null;
    $rowUser = null;
}

// se passo al form e agli input $rowUser['id'] $rowUser['email']) $rowUser['name']) da errore.
// PHP dice che non può accedere ai valori perchè sono null
// Quindi aggiungo questi tre controlli e agli input passo delle variabili inizializzate o valorizzate qui

if (isset($rowUser['id'])) {
    $id = $rowUser['id'];   
} else {
    $id = '';
}

if (isset($rowUser['email'])) {
    $email = $rowUser['email'];   
} else {
    $email = '';
}

if (isset($rowUser['name'])) {
    $name = $rowUser['name'];   
} else {
    $name = '';
}

// POST

// se l'utente preme salva inserisce un nuovo utente o modifica uno esistente
// testa la presenza di id utente per sapere se sto creando un nuovo utente o sto modificando un utente esistente

if (isset($_POST['btn_save'])){
    $name  = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);

    try {
        if($id != null){
            if ($objUser->update($id, $name, $email)) {
                $objUser->redirect('index.php?updated');
            } 
        } else {
            if ($objUser->insert($name, $email)) {
                $objUser->redirect('index.php?inserted');
            } else {
                $objUser->redirect('index.php?error');
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// se l'utente ha premuto Annulla torna a index.php
// questa azione è stata sostituita dal form-group con due btn, uno per Salva e uno per annulla

if (isset($_POST['btn_cancel'])) {
    $objUser->redirect('index.php');
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
                    <h1 margin-top: 10px>Aggiungi / Modifica utenti</h1>
                    <p>valori richiesti *</p>
                    <form  method="post">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php echo $id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input  class="form-control" type="text" name="name" id="name" placeholder="Nome e cognome" value="<?php echo $name; ?>" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input  class="form-control" type="text" name="email" id="email" placeholder="emailaccount@youmail.com" value="<?php echo $email; ?>" required maxlength="100">
                    </div>
                    <!-- 
                        ho aggiunto un btn per annulla che in POST richiama redirect via PHP

                    <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Salva">
                    <input class="btn btn-primary mb-2" type="submit" name="btn_cancel" value="Annulla">

                    -->

                    <!-- i btn sopra sono stati sostituiti da questo form group, con btnSave e
                        un link con aspetto di btn per annulllare
                    -->

                    <div class="form-group">
                        <label class="col-md-4 control-label" for "submit"></label>
                        <div class="col-md-8">
                            <button id="submit" name ="btn_save" class="btn btn-primary" value="1">Salva</button>
                            <a href="index.php" id="cancel" name="cancel" class="btn btn-default">Annulla</a>
                        </div>
                    </div>
                  </form>
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
    </body>
</html>
