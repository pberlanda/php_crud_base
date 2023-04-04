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
                        <!-- <input class="form-control" type="text" name="id" id="id" value="<?php print($rowUser['id']); ?>" readonly> -->
                        <input class="form-control" type="text" name="id" id="id" value="<?php echo $id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input  class="form-control" type="text" name="name" id="name" placeholder="First Name and Last Name" value="<?php echo $name; ?>" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input  class="form-control" type="text" name="email" id="email" placeholder="guidolape@youmail.com" value="<?php echo $email; ?>" required maxlength="100">
                    </div>
                    <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Salva">
                  </form>
                </main>
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
    </body>
</html>
