<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php $this->Form->setTemplates(["formStart" => "<div class='form-horizontal'><form{{attrs}}></div>"]); ?>
<?php $this->Form->setTemplates(["inputContainer" => "<div class='form-group row' form-type='{{type}}'>{{content}}</div>"]); ?>
<?php $this->Form->setTemplates(["label" => "<label class='col-3 control-label'>{{text}}</label>"]); ?>
<?php $this->Form->setTemplates(["input" => "<div class='col-5'><input class='form-control' type='{{type}}' name='{{name}}' {{attrs}}/></div>"]); ?>
<?php $this->Form->setTemplates(["textarea" => "<div class='col-8'><textarea class='form-control' name = '{{name}}' {{attrs}}>{{value}}</textarea></div>"]); ?>
<?php $this->Form->setTemplates(["select" => "<div class='col-8'><select class='form-control' name='{{name}}' {{attrs}}>{{content}}</select></div>"]); ?>
<?php $this->Form->setTemplates(["submitContainer" => "<div class='form-group row'><div class='col-12'>{{content}}</div></div>"]); ?>
<?php $this->Form->setTemplates(["inputSubmit" => "<input class = 'mt-lg-0 btn btn-success position-static' type = '{{type}}' {{attrs}}>"]); ?>
<?php $this->Form->setTemplates(["dateWidget" => "{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}"]); ?>
<?php $this->Form->setTemplates(["button" => "<div class='d-flex justify-content-center'><button type ='submit' class= 'btn btn-primary mt-2' {{attrs}}>{{text}}</button></div>"]); ?>

<?php $this->Paginator->setTemplates(['nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['prevDisabled' => '<li class="page-item disabledá"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['counterRange' => '{{start}} - {{end}} of {{count}}']); ?>
<?php $this->Paginator->setTemplates(['counterPages' => '{{page}} of {{pages}}']); ?>
<?php $this->Paginator->setTemplates(['first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['ellipsis' => '<li class="ellipsis">&hellip;</li>']); ?>
<?php $this->Paginator->setTemplates(['sort' => '<a href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortAsc' => '<a class="asc" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortDesc' => '<a class="desc" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortAscLocked' => '<a class="asc locked" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>']); ?>
