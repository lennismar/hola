<?php   
include("includes/config.php");
include ABS_BASE.'includes/functions_bookings.php';
$restid=$_GET['restid'];
$resid=$_GET['resid'];
$email=$_GET['email'];
$response=($_GET['response']);
if($restid == '5') cancelReservation($resid, $email, true, $restid);
else updateReservation($restid, $resid, $email, $response);

// Si la actualización es para marcar como pagado manual, creo el pago
if($restid == '4') {
    include ABS_BASE.'includes/functions_payments.php';
    $db->where ("resid", $resid);
    $reserva = $db->getOne ("reservations");
    $rescode = $reserva['rescode'];
    $payment = createPayment($rescode, 1, null, null, 9);
}

if(!empty($email) && $email == 'no') exit('ok');
//mysqli_query($query);
//mysqli_close();

header("location: reservations_view.php?id=".$resid."&email=".$email);
?>
