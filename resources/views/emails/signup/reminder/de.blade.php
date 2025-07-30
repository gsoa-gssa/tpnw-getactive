<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
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
#ipwl8z {
	padding-top:0px;
	padding-right:0px;
	padding-bottom:0px;
	padding-left:0px;
	background-color:rgba(235,235,235,1);
	line-height:140%;
}
#i7ia9o {
	max-width:650px;
	margin-top:auto;
	margin-right:auto;
	margin-bottom:auto;
	margin-left:auto;
	background-color:rgba(255,255,255,1);
	padding-top:0px;
	padding-bottom:0px;
}
#i26i05 {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
	font-size:22px;
}
#ipbwk7 {
	color:black;
	width:100%;
}
#iuxpfg {
	padding-left:10px;
	padding-right:10px;
	padding-top:30px;
	padding-bottom:30px;
}
#iwp6he {
	padding:10px;
	font-family:Arial,Helvetica,sans-serif;
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
</head>
<body id="ipwl8z">
  <div id="iuxpfg" class="gjs-grid-row">
    <div id="i7ia9o" class="gjs-grid-column"><img id="ipbwk7" src="{{url('images/emails/MC_Head_de.png')}}" alt="Logo"/>
      <div id="i26i05">
				<b id="ijn4gj">Hallo {{$contact->firstname}}!</b>
			</div>
      <div id="iwp6he">
				Du hast dich für den Anlass «{{$event->getTranslatable("name", $language)}}» angemeldet.
        <b>Vielen Dank!</b>
				<br>
				<br>
				Das ist nun schon bald.
				@if ($event->contact->email == $user->email)
					Wenn noch etwas unklar ist, melde dich bitte bei mir. Meine Handynummer ist {{$user->phone}} und meine E-Mail-Adresse {{$user->email}}. Sonst sehen wir uns dann vor Ort!
				@else
           Konntest du dich schon mit {{$event->contact->firstname}} in Verbindung setzen? Ich selbst kann leider nicht vor Ort sein. Wenn noch etwas unklar ist, melde dich bitte bei {{$event->contact->firstname}} (Kontaktdaten unten) oder bei mir. Meine Handynummer ist {{$user->phone}} und meine E-Mail-Adresse {{$user->email}}.
				@endif
				<br>
				<br>
				<p>Hier noch die Details zu deiner Anmeldung:</p>
				<p>
					<ul>
						<li>
							<b>Kontaktperson vor Ort:</b> {{$event->contact->firstname}} {{$event->contact->lastname}}
						</li>
						<ul>
							@if ($event->contact->phone)
								<li>
									<b>Telefonnummer:</b> {{$event->contact->phone}}
								</li>
							@endif
							<li>
								<b>E-Mail Adresse:</b> {{$event->contact->email}}
							</li>
						</ul>
						<li>
							<b>Datum:</b> {{$event->date->format("d.m.Y")}}@if ($event->getTranslatable("time", $language)), {{$event->getTranslatable("time", $language)}}@endif
						</li>
						<li>
							<b>Ort:</b> {{$event->getTranslatable("location", $language)}}
						</li>
					</ul>
				</p>
				@if ($event->getTranslatable("description", $language))
          <p><br></p>
          <p><b>Weitere Infos zum Event</b></p>
          {!!$event->getTranslatable("description", $language)!!}
				@endif
				@if ($signup->additional_information)
          <p><br></p>
          <p><b>Zusätzliche Informationen zu deiner Anmeldung:</b></p>
          {!!$signup->additional_information!!}
				@endif
        <br/>
        <br/>
        <b>
          @if ($event->contact->email == $user->email)
            Atomwaffenfreie Grüsse und bis bald,
          @else
            Vielen Dank und herzliche Grüsse,
          @endif	
        </b>
        <br>
        {{$user->name}}
        <br>
        {{$user->email}}
        <br>
        {{$user->phone}}
        <br>
      </div>
    </div>
  </div>
</body>
</html>
