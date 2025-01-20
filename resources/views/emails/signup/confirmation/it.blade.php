<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body id="iawfck">
  <div class="gjs-grid-row" id="ijfv9i">
    <div class="gjs-grid-column" id="i7as8h"><img src="{{url('images/emails/MC_Head_it.png')}}" alt="Logo" id="iz04el"/>
      <div id="ir2uut"><b id="i0os3o">Ciao {{$contact->firstname}}!</b></div>
      <div id="ifz1ka">Hai appena effettuato l'iscrizione per l'evento «{{$event->getTranslatable("name", $language)}}».
        <b>Grazie!</b><br/><br/>L'evento si svolgerà il giorno {{$event->date->format("d.m.Y")}}@if ($event->getTranslatable("time", $language)), {{$event->getTranslatable("time", $language)}}@endif, vi contatterò poco prima con le informazioni più importanti. Se avete domande, potete contattarmi in qualsiasi momento. Grazie mille per il vostro sostegno!
        <br/>
        <br/>
        <b>Saluti dedicati e a presto,</b>
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
#iz04el {
	color:black;
	width:100%;
}
#ir2uut {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
	font-size:22px;
}
#ifz1ka {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
}
#i7as8h {
	max-width:650px;
	margin-top:auto;
	margin-right:auto;
	margin-bottom:auto;
	margin-left:auto;
	background-color:rgba(255,255,255,1);
	padding-top:0px;
	padding-bottom:0px;
}
#ijfv9i {
	padding-left:10px;
	padding-right:10px;
	padding-top:30px;
	padding-bottom:30px;
}
#iawfck {
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
