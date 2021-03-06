﻿<style>
.ui-widget-header
{
	background:none;
	background-color:#3F47CC;
}
.bno-accions{
	display:inline-block;
}

 .input-transition {
	-webkit-transition : width 1s ease , opacity 1s ease ;
	transition         : width 1s ease , opacity 1s ease ;
 }

 .input-control-show {
	opacity : 1;
	width   : 120px;
 }
 .input-control-hide {
	opacity : 0;
	width   : 0;
 }
 .chip{
	margin-left: -20px;
	margin-top: 0px;
	z-index: 1000;
	position: absolute;
	background-color: #878CE5;
	font-size: 11px;
	padding: 1px 7px;
	border-radius: 10px;
	color: #FFFFFF;
 }
</style>
<div class="perimeter" style="padding:10px;">
	<h3 style="color:#FF4031; font-weight: bold;">
		Filtros
	</h3>
	<div style="padding:5px 20px;">
		<div class="row" style="color:#121895;">
			<div class="col-xs-12 col-sm-6 col-md-3">
				Armadora
				<select title="Armadora" id="marca" name="marca" class="basic-filter" filter="1">
					<?php
						echo "<option value=''></option>";
						foreach ($selects["selectMarca"] as $key => $value)
							echo "
								<option 
									value='".$value["marca"]."' 
									".(!empty($_GET["basic_filter_name1"]) && $_GET["basic_filter_name1"]==='marca' && $_GET["basic_filter_value1"]===$value["marca"]?'selected':'').">
										".$value["marca"]."
								</option>
							";
					?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				Linea
				<select title="Linea" id="componente" name="componente" class="basic-filter" filter="2">
					<?php
						echo "<option value=''></option>";
						foreach ($selects["selectComponente"] as $key => $value)
							echo "
								<option 
									value='".$value["componente"]."' 
									".(!empty($_GET["basic_filter_name2"]) && $_GET["basic_filter_name2"]==='componente' && $_GET["basic_filter_value2"]===$value["componente"]?'selected':'').">
										".$value["componente"]."
								</option>
							";
					?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				Marca
				<select title="Marca" id="marca_refaccion" name="marca_refaccion" class="basic-filter" filter="3">
					<?php
						echo "<option value=''></option>";
						foreach ($selects["selectMarcaRefaccion"] as $key => $value)
							echo "
								<option 
									value='".$value["marca_refaccion"]."' 
									".(!empty($_GET["basic_filter_name3"]) && $_GET["basic_filter_name3"]==='marca_refaccion' && $_GET["basic_filter_value3"]===$value["marca_refaccion"]?'selected':'').">
										".$value["marca_refaccion"]."
								</option>
							";
					?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-3">
				Tipo de componente
				<select title="Tipo de componente" id="marca_componente" name="marca_componente" class="basic-filter" filter="4">
					<?php
						echo "<option value=''></option>";
						foreach ($selects["selectMarcaComponente"] as $key => $value)
							echo "
								<option 
									value='".$value["marca_componente"]."'
									".( !empty($_GET["basic_filter_name4"]) && $_GET["basic_filter_name4"]==='marca_componente' && $_GET["basic_filter_value4"]===$value["marca_componente"]?'selected':'')."
								>
										".$value["marca_componente"]."
								</option>
							";
					?>
				</select>
			</div>
		</div>
	</div>
<div>total de resultados:<?php echo $numero_elementos;?></div>
<?php
	$j=1;
	for($i=0;$i<$numero_elementos;$i+=$limite)
	{
	?>
	<div class="numero_pagina <? if($j==$posicion_inicial+1) echo 'current_numero_pagina';?>" <?php if($j!=$posicion_inicial+1){?> onclick="paginar('<?php echo $j-1;?>');"<?php }?> ><label class="numero_pagina_texto"><?php echo $j++;?></label></div>
	<?php
	}
?>
<br>
<br>
<div id="catFinder" name="catFinder" style="padding:10px;">
<div class="row">
<script>
	var inventory = [];
</script>
<?php
		if(empty($inventantario_array))
			echo '0 resultados';
		else
		foreach($inventantario_array AS $row_array)
		{
			if(!empty($row_array))
			{
			?>
			<script>
				inventory.push(<? echo json_encode($row_array) ?>);
			</script>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" id="celda_marco_<?php echo $row_array['id_inventario'];?>" >
				<div 
					class="shadow_marco <?php if( !empty($row_array['promocion']) ) {?> promocion_container<?php }?>" 
					id="shadow_marco_<?php echo $row_array['id_inventario'];?>" 
					ondblclick="<?php if( $this->centinela->is_logged_in() ){?>showProductInput('<? echo $row_array['id_inventario'] ?>')<?php } ?>">

					<div class="tittle_marco tooltip_class" title="<?php echo $row_array['npc']; ?>" data-original-title="<?php echo $row_array['npc']; ?>"><?php echo $row_array['npc']; ?>
					</div>
					<div style="float:right; display:inline-table; padding:3px;" class="car_chip" id="car_chip_id_<?php echo $row_array['id_inventario']?>">
					</div>
						<?php
							if( !empty($row_array['promocion']) )
							{
						?>
						<div class="promocion_div tooltip_class" title="<?php echo title_promocion($row_array['promocion']);?>">
							<div class="promocion_button promocion_class">
							</div>
						</div>
						<?php
							}
						?>
						<?php

							if(file_exists('images/inventario/tiny_size/'.$row_array['npc'].'.jpg'))
								$backgoundImage=$row_array['npc'];
							else
								$backgoundImage=$this->config->item('no_image');
						?>
						<div id="contenedor_imagen_marco_<?php echo $row_array['id_inventario'];?>" class="contenedor_imagen_marco tooltip_class" title="Maximizar imagen" onclick="mostrarOriginal('<?php echo $backgoundImage;?>');">

							<div id="imagen_marco_<?php echo $row_array['id_inventario'];?>" class="imagen_marco">
							<?php
									$backgoundImageStyle= '<style>#imagen_marco_'.$row_array['id_inventario'].'{background-image: url("'.base_url().'images/inventario/tiny_size/';
									$backgoundImageStyle.=$backgoundImage;
									$backgoundImageStyle.='.jpg'.'");}</style>';
									echo $backgoundImageStyle;
							?>
							</div>
						</div>
					<div class="contenedor_info">
						<div class="table table-striped table-bordered table-hover" style="border:none; border-collapse:unset;">

							<div class="row" >
								<div class="col-xs-5 limita-texto tooltip_class" class="custom_td" data-original-title="VEHICULO" ><div style="display:inline;" class="concepto_field"><b>VEHICULO:</b></div>
								</div>
								<div class="col-xs-7 limita-texto tooltip_class" class="custom_td" data-original-title="<?php if(!empty($row_array['marca'])) echo $row_array['marca']; ?>" ><div style="display:inline;" class="concepto_value"><?php if(!empty($row_array['marca'])) echo $row_array['marca']; else echo 'N/A'; ?></div>
								</div>
							</div>
							<?php
							if(!empty($row_array['precio']))
							{
							?>
							<div class="row">
								<div
									class="col-xs-5 limita-texto tooltip_class"
									class="custom_td"
									data-original-title="Precio"
								>
									<div
										style="display:inline;"
										class="concepto_field"
									>
										<b>PRECIO:</b>
									</div>
								</div>
								<div
									class="col-xs-7 limita-texto tooltip_class"
									class="custom_td"
									data-original-title="<?php echo '$'.round(floatval(preg_replace("/[^-0-9\.]/","",$row_array['precio'])),2); ?>"
								>
									$
									<div
										style="display:inline;"
										class="concepto_value precio_producto"
										id="producto_precio_<?php $row_array['id_inventario'];?>"
									>
										<?php
											echo round(floatval(preg_replace("/[^-0-9\.]/","",$row_array['precio'])),2);
										?>
									</div>
								</div>
							</div>
							<?php
							}
							?>
							<div class="row" >
								<div class="col-xs-5 limita-texto tooltip_class" class="custom_td" data-original-title="descripcion" ><div style="display:inline;" class="concepto_field"><b>DESCRIPCIÓN:</b></div>
								</div>
								<br>
								<div class="col-xs-12 tooltip_class" class="custom_td" data-original-title="<?php if(!empty($row_array['descripcion'])) echo $row_array['descripcion']; ?>" ><div style="display:inline-block; height:65px;" class="concepto_value"><?php if(!empty($row_array['descripcion'])) echo $row_array['descripcion']; else echo 'N/A'; ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="bno-accions acciones">
						<!--<div class="icon- bno-button  tooltip_class" title="Expandir" onclick="expandir('<?php echo $row_array['id_inventario'];?>');">
						&#xe682
						</div>-->
						<div class="icon- bno-button  tooltip_class" id="abrir_dialog" title="Abrir en ventana emergente" onclick="abrir_dialogo('<?php echo $row_array['id_inventario'];?>');">
						&#xe75a
						</div>
						<?php
							if( $this->centinela->is_logged_in())
							{
						?>
							<div class="icon- bno-button  tooltip_class" title="Añadir al carrito" onclick="toggleProductInput('<? echo $row_array['id_inventario'] ?>')">
							&#xe702
							</div>
							<input  
								type       = "text"
								class      = "form-control numeric input-transition product-input input-control-hide"
								style      = "float:right; margin-left: 5px;" 
								name       = "product_quantity_id_<? echo $row_array['id_inventario'] ?>" 
								id         = "product_quantity_id_<? echo $row_array['id_inventario'] ?>"
								onkeyup    = "validateQuantity($('#product_quantity_id_<? echo $row_array['id_inventario'] ?>'))"
								onchange   = "validateQuantity($('#product_quantity_id_<? echo $row_array['id_inventario'] ?>'))"
								ondblclick = "persistProduct($('#product_quantity_id_<? echo $row_array['id_inventario'] ?>'))"
								value      = "<?php echo !empty($carrito->{$row_array['id_inventario']}) ? $carrito->{$row_array['id_inventario']} : '' ?>"
								/>
						<?php
							}
						?>
					</div>
				</div>
				<div class="expanded hidden_class" id="expanded_<?php echo $row_array['id_inventario'];?>">

				</div>
			</div>

			<?php
			}
		}
?>
</div>
</div>

<div>total de resultados:<?php echo $numero_elementos;?></div>
<?php
	$j=1;
	for($i=0;$i<$numero_elementos;$i+=$limite)
	{
	?>
	<div class="numero_pagina <? if($j==$posicion_inicial+1) echo 'current_numero_pagina';?>" <?php if($j!=$posicion_inicial+1){?> onclick="paginar('<?php echo $j-1;?>');"<?php }?> ><label class="numero_pagina_texto"><?php echo $j++;?></label></div>
	<?php
	}
?>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalData" id="modal_laucher_data" style="visibility:hidden;">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:#3F47CC;">Vista completa</h4>
      </div>
      <div class="modal-body" id="modal-info-data">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#FF4031;">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalImg" id="modal_laucher_img" style="visibility:hidden;">

</button>

<!-- Modal -->
<div class="modal fade" id="myModalImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:#3F47CC;">Imagen Maximizada</h4>
      </div>
      <div class="modal-body" id="modal-info-img">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#FF4031;">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<?php //debugg($numero_elementos);?>
<script>

var addToCar = (idProduct,quantity=1) => {
	return new Promise((resolve,reject) => {
		$.ajax({
			url     : '<?php echo site_url();?>/carrito/add_carrito/' + idProduct + '/' + quantity,
			type    : 'POST',
			success : (html)=>{resolve(html)},
			error   : (error)=>{reject(error)}
		});
	});
}
var currentProduct       = null;
var currentProducId      = 0;
var currentQuantity      = '';
var newValidatedQuantity = '';
var carrito              = <?php echo  !empty($carrito)? json_encode($carrito):'{}'?>

function isPositiveInt(s)
{
	if (s == null || s==='0' || s==='')
		return true
	if (typeof s ==='number' && s.toString()==='0')
		return true
	return /^[1-9]+[0-9]*$/.test(s);
}

var validateQuantity = (source) =>{
	if (source.val()==='' || source.val() === 0 || source.val() === null)
		newQuantity = 0
	else
		newQuantity = source.val()
	if (currentQuantity && !newValidatedQuantity)
		newValidatedQuantity = currentQuantity
	if (source.hasClass('input-control-show') && isPositiveInt(newQuantity))
		newValidatedQuantity = newQuantity
	else
		source.val(newValidatedQuantity)
}

var showChip = () => {
	$(".car_chip").html('')
	let carritoKeys = Object.keys(carrito)
	for (let i=0; i<carritoKeys.length; i++){
		if (carrito[carritoKeys[i]]>0)
			$('#car_chip_id_' + carritoKeys[i]).html(
				`<div class="icon- bno-button tooltip_panel" title="" data-original-title="Carrito de compras" style="cursor:default;">
					
				</div>
				<span class="chip">` + carrito[carritoKeys[i]] + `</span>
				`
			)
	}
}

$(document).ready(function()
{
	showChip(carrito)
	$(".basic-filter").change(function(event){
		let filter = $(this).attr('filter')
		basicFilter['name' + filter] =$(this).attr("name");
		basicFilter['value' + filter]=$(this).val();
		//$(".basic-filter").val('');
		paginar(0);
	});

	$( '.tooltip_class' ).tooltip(
	 {
		tooltipClass: "custom-tooltip-styling",
		position:
		{
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback )
			{
				$( this ).css( position );
				$( "<div>" )
				.addClass( "arrow" )
				.addClass( feedback.vertical )
				.addClass( feedback.horizontal )
				.appendTo( this );
			}
		}
	});

	<?php
		if(!empty($inventantario_array))
		{
			foreach($inventantario_array AS $producto)
			{
				if(!empty($producto['promocion']))
				{
	?>
				calcularPrecio(JSON.parse('<?php echo json_encode($producto);?>'));
	<?php
				}
			}
		}
	?>

});

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

function expandir(id_producto)
{
	$('#shadow_marco_'+id_producto).addClass('hidden_class');
	$('#celda_marco_'+id_producto).addClass('expanded_celda_marco');
	$('#expanded_'+id_producto).html('<img style="width:120px; height:120px;" src="<?php echo base_url();?>images/loading.gif" >');
	$('#expanded_'+id_producto).removeClass('hidden_class');
	marcar_ultimo($('#expanded_'+id_producto));
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/informacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{
				$('#expanded_'+id_producto).html(html);
				 $('html, body').animate(
				 {
					scrollTop: $('#expanded_'+id_producto).offset().top
				  }, 1000);
		}
	});
}


function reducir(id_producto)
{
	$('#shadow_marco_'+id_producto).removeClass('hidden_class');
	marcar_ultimo($('#shadow_marco_'+id_producto));
	$('#celda_marco_'+id_producto).removeClass('expanded_celda_marco');
	$('#expanded_'+id_producto).addClass('hidden_class');
	$('#expanded_'+id_producto).html('');
	$('html, body').animate(
	{
		scrollTop: $('#shadow_marco_'+id_producto).offset().top
	}, 1000);
}

function mostrarOriginal(npc)
{
	var rutaImg='<?php echo base_url().'images/inventario/original_size/' ?>';
	var complementImg='.jpg';
	var htmlDiv='<div class="contenedor_imagen_original"><div id="imagen_original_id" class="imagen_original">';
	htmlDiv+='<style>#imagen_original_id{background-image:url("' + rutaImg + npc + complementImg + '");}</style>';
	htmlDiv+='</div></div>';
	$('#modal-info-img').html(htmlDiv);
	$('#modal_laucher_img').trigger('click');
}
function abrir_dialogo(id_producto)
{
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto + '/TRUE',
		type: 'POST',
		success : function(html)
		{

			$('#modal-info-data').html(html);
			$('#modal_laucher_data').trigger('click');
		}
	});
}

function paginar(numero_pagina)
{
	let queryFilter = '?'
	for (let i = 1; i < 5; i++)
		if (
			basicFilter['name' + i] != null && 
			basicFilter['name' + i] !== '' && 
			basicFilter['value' + i] != null && 
			basicFilter['value' + i] !== ''
		){
			if (queryFilter !== '?')
				queryFilter = queryFilter + '&'
			queryFilter = queryFilter + 'basic_filter_name' + i + '=' + basicFilter['name' + i] + '&basic_filter_value' + i + '=' + basicFilter['value' + i]
		}

	$('#form_container').html('<div style="width:100%; text-align:center;"><label > Cargando...</label><br><br><br><img src="<?php echo base_url();?>images/loading.gif"></div>');
	$.ajax({
			url : '<?php echo site_url().'/inventario/buscar/';?>' + numero_pagina + queryFilter,
			type: 'POST',
			success : function(html)
			{
				$('#form_container').html(html);
			}
		});
}

function marcar_ultimo(elemento)
{
	$('.last_selected').removeClass('last_selected');
	$(elemento).addClass('last_selected');
}

	<?php
		if( $this->centinela->is_logged_in() )
		{
	?>

	persistProduct = (source) => {
		if (!$("#product_quantity_id_"+currentProducId).hasClass('input-control-show'))
			return false
    	currentQuantity = newValidatedQuantity
    	addToCar(currentProducId,source.val()).then(()=>{
    		carrito[currentProducId] = currentQuantity
    		showChip()
			hideProductInput()
    	}).catch(()=>{
			hideProductInput()
    	})
	}

	toggleProductInput = (productId) => {
		if ($('#product_quantity_id_' + productId).hasClass('input-control-hide'))
			showProductInput(productId)
		else
			hideProductInput(productId)
	}

	showProductInput = (productId=0) => {
		if ($("#product_quantity_id_"+productId).hasClass("input-control-show"))
			return false
		var e     = $.Event("keyup");
		e.keyCode = 27;
		$('.input-control-show').trigger(e)
		if($("#product_quantity_id_"+productId).val()==0)
			$("#product_quantity_id_"+productId).val('')
		newValidatedQuantity = currentQuantity = $("#product_quantity_id_"+productId).val()
		currentProducId      = productId
		currentProduct       = inventory[productId]
		$("#product_quantity_id_"+productId).focus()
		$("#product_quantity_id_"+productId).removeClass("input-control-hide")
		$("#product_quantity_id_"+productId).addClass("input-control-show")
	}

	hideProductInput = ()=> {
		if ( $("#product_quantity_id_"+currentProducId).hasClass('input-control-show')){
			newValidatedQuantity = currentQuantity
			if(currentQuantity==0)
				currentQuantity=''
	    	$("#product_quantity_id_"+currentProducId).val(currentQuantity)
		}
		$("#product_quantity_id_"+currentProducId).removeClass("input-control-show")
		$("#product_quantity_id_"+currentProducId).addClass("input-control-hide")
	}

	$('.product-input').keyup(function(e){
	    if(e.keyCode == 13)
	    	persistProduct($(e.currentTarget))
	    if (e.keyCode == 27)
			hideProductInput()
	});
	<?php
		}
	?>
</script>