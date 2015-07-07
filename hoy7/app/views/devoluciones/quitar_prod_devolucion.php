<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
 	if (!isset($retorno)) {
      	$retorno ="devolucion";
    }
 $rest = substr($nombrecompleto, -1); 
    
 $hidden = array('id'=>$id); ?>
<?php echo form_open('validar_quitar_devolucion', array('class' => 'form-horizontal','id'=>'form_devolucion','name'=>$retorno, 'method' => 'POST', 'role' => 'form', 'autocomplete' => 'off' ) ,   $hidden ); ?>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3 class="text-left">Quitar producto</h3>
	</div>
	<div class="modal-body">
		<p>¿Estás seguro de que deseas quitar el producto <b><?php echo  $nombrecompleto ; ?></b>?</p>
		<p>Recuerde, este proceso es completamente irreversible.</p>
		<div class="alert" id="messagesModal"></div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-danger" id="deleteUserSubmit">Aceptar</button>
		<button class="btn btn-default" data-dismiss="modal">Cancelar</button>
	</div>
<?php echo form_close(); ?>