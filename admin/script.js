var someInputHasFocus = false;
$('input, select, textarea').focus(function() {
	//this.className = this.className+' inputhover';
	if ((this.type != 'button') && (this.type != 'submit') && (this.parentNode.className != 'labellogin'))
		this.parentNode.className = this.parentNode.className+' labelfocus';
	someInputHasFocus = true;
}).blur(function() {
	//this.className = this.className.replace(' inputhover', '');
	if (this.parentNode.className != 'labellogin')
		this.parentNode.className = this.parentNode.className.replace(' labelfocus', '');
	someInputHasFocus = false;
});
$('body').mousedown(function() {
	someInputHasFocus = true;
});

$(document).keydown(function(e) {
	var teclaN = e.which;
	if ((((teclaN >= 65) && (teclaN <= 90)) || ((teclaN >= 48) && (teclaN <= 57))) && (teclaN != 17) && (!someInputHasFocus)) {
		$("input:text:visible:enabled:first").focus();
		$(".firstFocus").focus();
	}
});
$('.onlynumbers').numeric();
$('input').attr("autocomplete", "off");
$('.targetblank').attr("target", "_blank");

if (!(typeof grupoorden != 'undefined')) grupoorden = '';
function actualizaorden() {
	ar_items = $("#lista").sortable('toArray');
	valordenes = ar_items.toString().replace(/item_/g, '')
	//$("#ordenesup, #ordenesdown").val(valordenes);
	//$("#guardarOrdenes1, #guardarOrdenes2").css('display', 'inline');
	document.getElementById('lista').getElementsByTagName('a')[1].style.visibility = 'hidden';
	$(".botprev").css('visibility', 'visible');
	$(".botnext").css('visibility', 'visible');
	$(".botprev:first").css('visibility', 'hidden');
	$(".botnext:last").css('visibility', 'hidden');

	for (r = 0; r < ar_items.length; r++) {
		$('#'+ar_items[r]+' .numeroorden').html((r+1));
	}
	$.ajax({
		url: 'guardarorden?tabla='+tablaordenes+'&ordenes='+valordenes+'&grupo='+grupoorden+'&rand='+Math.random()
	});
	//document.getElementById('guardarOrdenes1').focus();
}

if (typeof esordenable != 'undefined') {
	$(function() {
		$("#lista").sortable({
			handle: ".handle",
			update : function () {
				actualizaorden();
			}
		});
		$("#lista").disableSelection();
	});
}
if (typeof esordenable != 'undefined') {
	$(".botprev").css('visibility', 'visible');
	$(".botnext").css('visibility', 'visible');
	$(".botprev:first").css('visibility', 'hidden');
	$(".botnext:last").css('visibility', 'hidden');
	$(function() {
		$("#lista").sortable({
			handle: ".handle",
			update : function () {
				actualizaorden();
			}
		});
		$("#lista").disableSelection();
	});
}

function subepos(obj){
	var c = $('#'+obj.parentNode.parentNode.parentNode.id);
	c.next().after(c);
	actualizaorden();
}
function bajapos(obj){
	var c = $('#'+obj.parentNode.parentNode.parentNode.id);
	c.prev().before(c);
	actualizaorden();
}

function borrar(nombreaborrar, tabla, id, obj) {
	input_box = confirm("Seguro desea borrar "+nombreaborrar);
	if (input_box == true){
		$.ajax({
			url: 'ajx.borrar.php?tabla='+tabla+'&id='+id+'&rand='+Math.random(),
			context: document.body
		});
		$("#"+obj.parentNode.parentNode.id).fadeOut(1000, function(){ $("#"+obj.parentNode.parentNode.id).remove(); });
	}
}

$('#lista tr').mouseover(function() {
	ultcolortr = this.style.backgroundColor;
	this.style.backgroundColor = '#FFFFCC';
});
$('#lista tr').mouseout(function() {
	this.style.backgroundColor = '';
});

hash = window.location.hash.toString().replace('#', '');
if (hash != '') {
	//timerID = setTimeout("$('input#"+hash+"').focus()", 100);
} else {
	//$(".focoinicial").focus();
}

function cmbcheck(acambiar, campo, id, tabla) {
	acambiar.innerHTML = '<img src="images/load1.gif" alt=""/>';
	//location.href = 'ajx.cambiacheck.php?tabla='+tabla+'&campo='+campo+'&id='+id+'&rand='+Math.random(),
	$.ajax({
		url: 'ajx.cambiacheck.php?tabla='+tabla+'&campo='+campo+'&id='+id+'&rand='+Math.random(),
		context: document.body,
		success: function(data){
			acambiar.innerHTML = data;
		}
	});
}