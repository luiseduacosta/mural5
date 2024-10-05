<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

// $this->disableAutoLayout();

if (!Configure::read('debug')):
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'Mural de estágios da ESS/UFRJ';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>

    <main class="main">
        <div class="container">
            <div class='row justify-content-center'>
                <!--
                    <div class='col-auto'>
                    //-->
                <?php
                $categoria = isset($this->getRequest()->getAttribute('identity')['categoria_id']) ? $this->getRequest()->getAttribute('identity')['categoria_id'] : null;
                if (isset($categoria) && (!empty($categoria))) {
                    switch ($categoria) {
                        case 1: // Administrador
                            echo $this->element('submenu_navegacao');
                            break;
                        case 2: // Estudante
                            if (!empty($this->getRequest()->getSession()->read('estagiario_id'))):
                                echo $this->element('submenu_estagiario');
                            else:
                                echo $this->element('submenu_estudante');
                            endif;
                            break;
                        case 3: // Docente
                            echo $this->element('submenu_docente');
                            break;
                        case 4: // Supervisora
                            echo $this->element('submenu_supervisor');
                            break;
                        default:
                            echo $this->element('submenu_navegacao');
                            // echo $this->element('menu_mural'); 
                            break;
                    }
                } else {
                    // echo $this->element('menu_mural');
                    echo $this->element('submenu_navegacao');
                }
                ?>

            </div>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>