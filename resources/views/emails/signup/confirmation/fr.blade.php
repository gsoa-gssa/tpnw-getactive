<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body id="ik7m2j">
  <div class="gjs-grid-row" id="irl6tc">
    <div class="gjs-grid-column" id="i8pizv"><img src="{{url('images/emails/MC_Head_fr.png')}}" alt="Logo" id="idk18q"/>
      <div id="ihut6t"><b id="iybtqg">Bonjour {{$contact->firstname}} {{$contact->lastname}} !</b></div>
      <div id="irp3ot">Vous venez de vous inscrire à l'événement « {{$event->getTranslatable("name", $language)}} ».
        <b>Je vous en remercie !</b><br/><br/>L'événement aura lieu le {{$event->date->format("d.m.Y")}}@if ($event->getTranslatable("time", $language)), {{$event->getTranslatable("time", $language)}}@endif, je m'adresserai à vous peu avant avec les informations les plus importantes. Si vous avez des questions, n'hésitez pas à me contacter. Un grand merci pour votre soutien !
        <br/>
        <br/>
        <b>Salutations engagé et à bientôt,</b>
        <br/>
        {{$user->name}}<br>
        {{$user->email}}<br>
      </div>
    </div>
  </div>
</body>

<style>
* {
	box-sizing:border-box;
}
body {
	margin:0;
}
.gjs-grid-column {
	flex:1 1 0%;
	padding:5px 0;
}
.gjs-grid-row {
	display:flex;
	justify-content:flex-start;
	align-items:stretch;
	flex-direction:row;
	min-height:auto;
	padding:10px 0;
}
.gjs-grid-column {
	flex:1 1 0%;
	padding:5px 0;
}
.gjs-grid-row {
	display:flex;
	justify-content:flex-start;
	align-items:stretch;
	flex-direction:row;
	min-height:auto;
	padding:10px 0;
}
.gjs-grid-column.feature-item {
	padding-top:15px;
	padding-right:15px;
	padding-bottom:15px;
	padding-left:15px;
	display:flex;
	flex-direction:column;
	gap:15px;
	min-width:30%;
}
.gjs-grid-column.testimonial-item {
	padding-top:15px;
	padding-right:15px;
	padding-bottom:15px;
	padding-left:15px;
	display:flex;
	flex-direction:column;
	gap:15px;
	min-width:45%;
	background-color:rgba(247,247,247,0.23);
	border-top-left-radius:5px;
	border-top-right-radius:5px;
	border-bottom-right-radius:5px;
	border-bottom-left-radius:5px;
	align-items:flex-start;
	border-top-width:1px;
	border-right-width:1px;
	border-bottom-width:1px;
	border-left-width:1px;
	border-top-style:solid;
	border-right-style:solid;
	border-bottom-style:solid;
	border-left-style:solid;
	border-top-color:rgba(0,0,0,0.06);
	border-right-color:rgba(0,0,0,0.06);
	border-bottom-color:rgba(0,0,0,0.06);
	border-left-color:rgba(0,0,0,0.06);
}
#idk18q {
	color:black;
	width:100%;
}
#ihut6t {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
	font-size:22px;
}
#irp3ot {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
}
#i8pizv {
	max-width:650px;
	margin-top:auto;
	margin-right:auto;
	margin-bottom:auto;
	margin-left:auto;
	background-color:rgba(255,255,255,1);
	padding-top:0px;
	padding-bottom:0px;
}
#irl6tc {
	padding-left:10px;
	padding-right:10px;
	padding-top:30px;
	padding-bottom:30px;
}
#ik7m2j {
	padding-top:0px;
	padding-right:0px;
	padding-bottom:0px;
	padding-left:0px;
	background-color:rgba(235,235,235,1);
	line-height:140%;
}
@media (max-width:992px) {
	.gjs-grid-row {
	flex-direction:column;
}
.gjs-grid-row {
	flex-direction:column;
}
}
</style>
</html>
