<?php
declare(strict_types=1);
?>
<!-- templates/element/paginator.php -->
<?php
$this->Paginator->setTemplates([
    'first' => '<li class="page-item"><a class="page-link" aria-label="Primeira página" href="{{url}}">{{text}}</a></li>',
    'last' => '<li class="page-item"><a class="page-link" aria-label="Última página" href="{{url}}">{{text}}</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" aria-label="Próxima página" href="{{url}}">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link" aria-hidden="true">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" aria-label="Página anterior" href="{{url}}">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link" aria-hidden="true">{{text}}</span></li>',
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active" aria-current="page"><span class="page-link">{{text}}</span></li>',
    'ellipsis' => '<li class="page-item disabled"><span class="page-link">…</span></li>',
]);
?>
<nav aria-label="Paginação">
    <ul class="pagination justify-content-center mb-0">
        <?= $this->Paginator->first('«') ?>
        <?= $this->Paginator->prev('‹') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('›') ?>
        <?= $this->Paginator->last('»') ?>
    </ul>
</nav>
