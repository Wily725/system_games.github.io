<?php
require 'config.php';

$grand_total = 0;
$allItems = '';
$items = array();

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty,
   total_price FROM cart";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $result = $stmt->get_result();
   while($row = $result->fetch_assoc()){
   	$grand_total +=$row['total_price'];
   	$items[] =$row['ItemQty'];
   }

   $allItems = implode(",", $items);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Wilfredo Lizme">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
	<title>Pedido</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

 <link rel="stylesheet" href="fontawesome/css/all.css" >


</head>
<body>
 <nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php"><i class="fas fa-gamepad"></i>&nbsp;<IMG src="logo/sysgame.png" width="200" height="50">  &nbsp; &nbsp; &nbsp; &nbsp;<small>Pedidos Por Mayor y Menor&nbsp; &nbsp; &nbsp;<i class="fas fa-phone"></i> 72532098 - 2844468</small> </a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Categorias</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="checkout.php">Revisar</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
      </li>
    </ul>
  </div>
</nav> 
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-6 px-4 pb-4" id="order">
			<h4 class="text-center text-info p-2">Terminar el Pedido</h4>
			<div class="jumbotron p-3 mb-2 text-center">
				<h6 class="lead"><b>Producto(s) : </b><?= $allItems; ?></h6>
				<h5><b>Cantidad Total a Pagar : </b><?= number_format($grand_total,2) ?> $</h5>
			</div>
			<form action="" method="post" id="placeOrder">
				<input type="hidden" name="products" value="<?= $allItems; ?>">
				<input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
				<div class="form-group">
					<input type="text" name="name" class="form-control" placeholder="Ingresar Nombre Completo" required="">
				</div>
				<div class="form-group">
					<input type="email" name="email" class="form-control" placeholder="Ingresar E-mail" required="">
				</div>
				<div class="form-group">
					<input type="tel" name="phone" class="form-control" placeholder="Ingresar Telefono" required="">
				</div>
				<div class="form-group">
					<textarea name="address" class="form-control"  rows="3" cols="10" placeholder="Comenario........."></textarea>
				</div>
				<h6 class="text-center lead">Seleccione el Modo de Pago</h6>
				<div class="form-group">
					<select name="pmode" class="form-control">
						<option value="" selected disabled>Seleccione el Modo de Pago</option>
						<option value="cod">Efectivo Sobre la entrega</option>
						<option value="netbanking">Red de Banco</option>
						<option value="cards">Debit/Credit Card</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Realizar Pedido" class="btn btn-danger btn-block">
					
				</div>
			</form>
		</div>
	</div>
	
</div>
		<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	
<script type="text/javascript">
	$(document).ready(function(){
      
     $("#placeOrder").submit(function(){
        e.preventDefault();
        $.ajax({
           url: 'action.php',
           method: 'post',
           data: $('form').serialize()+"&action=order",
           success: function(response){
           	$("#order").html(response);
           }
        });
     });

      load_cart_item_number();
        function load_cart_item_number(){
        	$.ajax({
        	   url: 'action.php',
        	   method: 'get',
        	   data: {cartItem:"cart_item"},
        	   success:function(response){
        	   	$("cart-item#").html(response);
        	   }	
        	});
        }
	});
</script>
</body>
</html>