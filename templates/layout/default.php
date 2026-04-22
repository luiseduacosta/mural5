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

$cakeDescription = $configuracao['descricao'] . ' - ' . $configuracao['instituicao'];

// Set categoria for all templates
$identity = $this->getRequest()->getAttribute('identity');
$categoria = $identity['categoria'] ?? null;
$this->set('categoria', $categoria);
?>

<!DOCTYPE html>
<!-- templates/layout/default.php -->
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        
        <?= $this->Html->css(['normalize.min']) ?>
        <?= $this->Html->css(['fonts']) ?>
        <?= $this->Html->css(['milligram.min']) ?>
        <?= $this->Html->css(['cake']) ?>
        <?= $this->Html->css(['mural']) ?>
        <?= $this->Html->css(['nav']) ?>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <?= $this->Html->script(['https://code.jquery.com/jquery-3.7.0.min.js']) ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>

        <?= $this->fetch('script') ?>
    </head>
    <body>

        <?= $this->element('menu_superior'); ?>

        <div id="content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->element('footer'); ?>
    </body>
</html>
