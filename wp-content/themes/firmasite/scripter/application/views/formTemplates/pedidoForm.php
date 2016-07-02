<style>
.ui-widget-header 
{
	background:none;
	background-color:#DD4814;
}
</style>
<div id="container">
	<form id="formularioPedido">
	<input type="hidden" name="numeroFilas" id="numeroFilas" value="<?php echo set_value('numeroFilas',$numeroFilas); ?>">
	<table class="table table-responsive table-hover" id="formSeccion1">
		<tr>
			<td >
				Nombre del Cliente:
			</td>
			<td colspan="2">
				<?php
					$nombre= $userData->nombre.' '.$userData->apellido_paterno.' '.$userData->apellido_materno;
					if(empty($nombre))
						$nombre=$userData->nick;
				echo $nombre;?>
			</td>
		</tr>
		<tr>
			<td >
				Fecha:
			</td>
			<td colspan="2">
				 <?php echo date("m-d-Y H:i:s");?>
			</td>
		</tr>
		<tr>
			<td>
				Tipo de Pedido
			</td>
			<td colspan="2">
				<?php
					echo form_dropdown(	"envio",
										array("1"=>"Normal", "2"=>"Urgente"),
										"1",
										" id='envio' class='test' "
										);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Tipo de Negocio
			</td>
			<td colspan="2">
				<?php echo $userData->tipo_cliente;?>
			</td>
		</tr>
	</table>
	<table class="table table-responsive table-hover" id="formSeccion2">
		<tr class="success" >
			<td >
				<b>CODIGO</b>
			</td>
			<td class="no_essencial">
				<b>DESCRIPCION</b>
			</td>
			<td class="col-md-1">
				<b>PRECIO</b>
			</td>
			<td class="col-md-1">
				<b>CANTIDAD</b>
			</td>
			<td>
				<b>SUBTOTAL</b>
			</td>
			<td class="col-md-2" style="text-align:center;">
				<b>ACCIÓN</b>
			</td>
		</tr>
		<?php
				$i=1;
				foreach($productos AS $producto)
				{
				?>
					<tr id="numeroFila<?php echo $i;?>" <?php  if(!empty($producto->promocion)){?> class="promocion_container tooltip_class_accion" title="<?php echo title_promocion($producto->promocion);?>"<?php }?> >
						<td >
							<input class="form-control" id="npc<?php echo $i;?>" name="NPC<?php echo $i;?>" size="10" type="hidden" value="<?php echo $producto->npc;?>" >
							<?php echo $producto->npc;?>
						</td>
						<td class="no_essencial">
							<input class="form-control" id="descripcion<?php echo $i;?>" name="Descripcion<?php echo $i;?>" size="50" type="hidden"  value="<?php echo $producto->descripcion;?>">
							<?php echo $producto->descripcion;?>
						</td>
						<td class="col-md-1">
							$<label class="precio_producto" id="producto_precio_<?php echo $producto->id_inventario;?>" ><?php echo round($producto->precio,2); ?></label>
						</td>
						<td class="col-md-1">
							<div>
								<script>
									var jsonProducto<?php echo ($producto->id_inventario);?>=<?php echo json_encode(($producto));?>;
								</script>
							</div>
							<input class="form-control numeric" id="cantidad<?php echo $i;?>" name="Cantidad<?php echo $i;?>" value="" 
							size="6" type="text" onchange="updateSubtotal(this.value,jsonProducto<?php echo ($producto->id_inventario);?>,'<?php echo $i;?>');">
						</td>
						<td>
							<label class="moneda" >$</label><label class="subtotal" id="subtotal<?php echo $i;?>">0</label>
						</td>
						<td class="success col-md-2" style="text-align:center;">
							<div class="bno-accions acciones">
								<div class="icon- bno-button  tooltip_class_accion " title="Expandir" onclick="expandir('<?php echo $producto->id_inventario;?>');">
										&#xe682
								</div>
								<div class="icon- bno-button  tooltip_class_accion " title="Abrir en ventana emergente" onclick="abrir_dialogo('<?php echo $producto->id_inventario;?>');">
										&#xe75a
								</div>
								<div class="icon- bno-button  tooltip_class_accion " title="Remover producto del pedido" onclick='removerFila(/\<tr.*?id=\"numeroFila<?php echo $i;?>\".*?\>([.|\s|\S]*?)tr\>/);'>
										&#xe701
								</div>
							</div>
						</td>
					</tr>
				<?php				
					$i++;
				}
			
		?>
				<tr id="numeroFila<?php echo $i;?>">
					<td colspan="2">TOTAL:
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="total">0</label>
					</td>
					<td>
					</td>
				</tr>
	</table>
	<table class="table" id="formSeccion4">
		<tr>
			<td>
				Observaciones
			</td>
			<td colspan="2">
				<textarea class="form-control" name="Observaciones" rows="3"></textarea>
			</td>
		</tr>
	</table>
	</form>
	<div>
		<div id="boton_limpiar" class="btn btn-default"  name="boton_limpiar">Borrar</div>
		<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Enviar </div>
	</div>
</div>
<div class="celda_marco">
</div>
<div id="dialog_info">
</div>
<script>
$(document).ready(function()
{	
	dialogo=$('#dialog_info');
	dialogo.dialog(
	{
		resizable: false,
		width: 800,
		modal: true,
		autoOpen: false,
		show: "blind",
		hide: "explode",
		title:"Vista completa",
		buttons: 
		{
			"Cerrar": function() 
			{
				$( this ).dialog( "close" );
			}
		}
	});
	$('.celda_marco').hide('fast');
	var limit=<?php echo $filasDefault;?>;
	var temp=$('#numeroFilas').val();
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
	$( '.tooltip_class_accion' ).tooltip(
	{
			position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
			}
	});
	$(".numeric").numeric(",");
	
	
	<?php 
		if(!empty($productos))
		{
			foreach($productos AS $producto)
			{	
				if(!empty($producto->promocion))
				{
	?>		
				var jsonProducto = <?php echo json_encode($producto);?>;
				calcularPrecio(jsonProducto);
	<?php 		
				}
			}
		}
	?>	
});

function removerFila(idTr)
{
	$("#formSeccion2").html( $("#formSeccion2").html().replace(idTr,''));
	updateTotal();
	$( '.tooltip_class_accion' ).tooltip(
	{
			position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
			}
	});
}

function calcularPrecio(producto)
{	
	if(producto!='')
	{
		switch(producto.promocion.nombre_tabla_promocion)
		{
			case 'ci_promocion_fija':
										$('#producto_precio_' + producto.id_inventario).text(producto.promocion.precio_oferta);
										break;
		}
	}
}

function abrir_dialogo(id_producto)
{	
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{		
				dialogo.html(html);
				dialogo.dialog( "open" );
		}           
	});	
}

function updateTotal()
{
	num_elementos='<?php echo $i;?>';
	total=0;
	for(i=1;i<num_elementos;i++)
	{	
		precio =	Number($('#subtotal'+i).text() );
		if(isNumber(precio))
		{
			total = total + precio;
		}
	}
	total = Math.round(total*100)/100;
	var res = total.toString();
	total=res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
	$('#total').text(total);
}

function updateSubtotal(cantidad,producto, elemento)
{
	var res;
	if(isPositiveInteger(cantidad))
	{	
		$('#cantidad'+elemento).attr('value',cantidad);
		if(producto)
		{
			res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
			if(typeof producto.promocion!=='undefined')
			switch(producto.promocion.nombre_tabla_promocion)
			{
				case 'ci_promocion_fija':
											res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
											break;
				case 'ci_promocion_rango':	
											min=producto.promocion.cantidad_min;
											max=producto.promocion.cantidad_max;
											cantidad_precio_especial=0;
											cantidad_precio_normal=0;
											
											if(min && max)
											{
												if(cantidad >= min)
												{
													if( cantidad <= max )
													{
														cantidad_precio_especial 	= cantidad;
														cantidad_precio_normal 		= 0;
													}
													else
													{
														cantidad_precio_especial	= 	max;
														cantidad_precio_normal 		=	cantidad - max;	
													}
												}
												else
												{
													cantidad_precio_especial	= 	0;
													cantidad_precio_normal 		=	cantidad;	
												}
											}
											
											if(min && !max)
											{
												if( cantidad >= min )
												{
													cantidad_precio_especial 	= cantidad;
													cantidad_precio_normal 		= 0;
												}
												else
												{
													cantidad_precio_especial	= 	0;
													cantidad_precio_normal 		=	cantidad;	
												}
												
											}
											
											if(!min && max)
											{
												if( cantidad <= max )
												{
													cantidad_precio_especial 	= cantidad;
													cantidad_precio_normal 		= 0;
												}
												else
												{
													cantidad_precio_especial	= 	max;
													cantidad_precio_normal 		=	cantidad - max;	
												}
											}
											if(!min && !max)
											{
												cantidad_precio_especial	= 	cantidad;
												cantidad_precio_normal 		=	0;	
											}
											precio_normal = Math.round(producto.precio * 100)/100;
											precio_normal = precio_normal.toString();
											precio_normal = precio_normal.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
											
											res_precio_normal = Number(cantidad_precio_normal * precio_normal);
											
											
											precio_especial = Math.round(producto.promocion.precio_oferta * 100)/100;
											precio_especial = precio_especial.toString();
											precio_especial = precio_especial.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
											
											res_precio_especial = Number(cantidad_precio_especial * precio_especial);
											
											res = res_precio_normal + res_precio_especial;
											break;
				case 'ci_promocion_m_n':	Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
											break;
				default:res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
							break;
			}
			res = res.toString();
			res=res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
			$('#subtotal'+elemento).text(Number(res));
		}
	}
	else
		$('#subtotal'+elemento).text(0);
	updateTotal();
}

function isPositiveInteger(s)
{
	return /^[0-9]+$/.test(s);
}

function isNumber(s)
{
	return /^[-+]?([0-9]*\.[0-9]+|[0-9]+)$/.test(s);
}

$('#boton_enviar').click(function()
{
	$('.form-control').prop('disabled', false);
	$.ajax(
	{
		url : '<?php echo site_url();?>/formSender/sendPedido',
		type: 'POST',
		data: $('#formularioPedido').serialize(),
		success : function(html)
		{
				$('#form_container').html(html);
		}           
	});
});

$('#boton_limpiar').click(function()
{
	$.ajax({
				url : '<?php echo site_url();?>/formSender/loadForm',
				type: 'POST',
				success : function(html)
				{
					$('#form_container').html(html);
				}           
			});
});

$('#aniadir').click(function()
{
	temp=$('#numeroFilas').val();
	temp++;
	$('#numeroFilas').val(temp);
	newLine='<tr id="numeroFila'+ temp + '"><td><input class="form-control" id=npc'+ temp + ' name="NPC'+ temp + '" size="10" type="text"></td>';
	newLine+='<td><input class="form-control" id=descripcion'+ temp + ' name="Descripcion'+ temp + '" size="50" type="text"></td>';
	newLine+='<td><input class="form-control" id=cantidad' + temp + ' name="Cantidad'+ temp + '" size="6" type="text"></td></tr>';
	$('#formSeccion2').append(newLine);
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
});
$('#quitar').click(function()
{
	temp=$('#numeroFilas').val();
	limit=<?php echo $filasDefault;?>;
	if(temp > limit)
	{
		$('#numeroFila' + temp).remove();
		temp--;
		$('#numeroFilas').val(temp);
	}
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
});
	
function expandir(id_producto)
{	
	$('.celda_marco').addClass('expanded_celda_marco');
	$('.celda_marco').removeClass('hidden_class');
	$('.celda_marco').show('fast');
	$.ajax(
	{
		url : '<?php echo site_url();?>/carrito/informacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{		
				$('.celda_marco').html(html);
				$('html, body').animate(
				{
					scrollTop: $('.celda_marco').offset().top
				}, 1000);
		}           
	});	
}


function mostrarOriginal(npc)
{
	var rutaImg='<?php echo base_url().'images/inventario/original_size/' ?>';
	var complementImg='.jpg';
	var htmlDiv='<div class="contenedor_imagen_original"><div id="imagen_original_id" class="imagen_original">';
	htmlDiv+='<style>#imagen_original_id{background-image:url("' + rutaImg + npc + complementImg + '");}</style>';
	htmlDiv+='</div></div>';
	dialogo.dialog('option', 'title', 'Imagen Maximizada ');
	dialogo.html(htmlDiv);
	dialogo.dialog( "open" );
}

function reducir(id_producto)
{
	$('.celda_marco').html('');
	$('.celda_marco').addClass('hidden_class');
	$('.celda_marco').removeClass('expanded_celda_marco');
	$('.celda_marco').hide('fast');
}	
</script>