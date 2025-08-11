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
				Du hast dich soeben für den Anlass «{{$event->getTranslatable("name", $language)}}» angemeldet.
        <b>Vielen Dank!</b>
				<br>
				<br>
				@if ($event->definitive)
					@if ($event->contact->email == $user->email)
						Wir sehen uns spätestens vor Ort, aber am besten meldest Du dich bei mir, damit wir noch alle Details besprechen können und sicher sind, dass wir uns erreichen können.
					@else
						Ich kann leider nicht selbst vor Ort sein, die Details zur Kontaktperson vor Ort findest du unten. Melde dich am besten bei ihr (falls noch nicht geschehen), damit ihr noch alle Details besprechen könnt und euch sicher erreichen könnt. Falls irgendwas nicht klappt oder du sonst ein Anliegen hast, kannst du dich auch gerne an mich wenden.
					@endif
					Meine Handynummer ist {{$user->phone}} und meine E-Mail-Adresse {{$user->email}}.
				@else
				  Leider haben wir noch keine Person gefunden, die den Anlass definitv betreuen kann. Es wäre dann aber eine gute Gelegenheit. Jetzt wo wir mit dir eine Person gefunden haben, die dann könnte, werden wir uns noch einmal stärker bemühen, auch eine weitere Person zu finden, damit du nicht alleine bleibst.
					@if ($event->contact->email == $user->email)
						Ich melde mich bei dir, sobald ich mehr weiss. Du kannst dich auch gerne direkt bei mir melden, falls du Fragen hast oder etwas unklar ist. Meine Handynummer ist {{$user->phone}} und meine E-Mail-Adresse {{$user->email}}.
					@else
						{{$event->contact->firstname}} ist für den Anlass verantwortlich und wird sich so bald wie möglich bei dir melden. Wenn du nicht innerhalb von einigen Tagen etwas hörst, melde dich doch am besten selbst bei {{$event->contact->firstname}}.
					@endif
				@endif
				<br>
				<br>
				<p>Hier noch die Details zu deiner Anmeldung:</p>
				<p>
					<ul>
						<li>
							<b>
								@if ($event->definitive)
									Kontaktperson vor Ort:
								@else
								  Verantwortlich für Organisation:
								@endif
							</b> {{$event->contact->firstname}} {{$event->contact->lastname}}
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
