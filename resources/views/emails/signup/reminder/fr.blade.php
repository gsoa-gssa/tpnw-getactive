<!DOCTYPE html>
<html lang="fr">
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
    <div id="i7ia9o" class="gjs-grid-column"><img id="ipbwk7" src="{{url('images/emails/MC_Head_fr.png')}}" alt="Logo"/>
      <div id="i26i05">
				<b id="ijn4gj">Bonjour {{$contact->firstname}}!</b>
			</div>
      <div id="iwp6he">
				Vous vous êtes inscrit à l'événement «{{$event->getTranslatable("name", $language)}}».
        <b>Merci pour cela !</b>
				<br>
				<br>
        C'est déjà bientôt. 
				@if ($event->definitive)
					@if ($event->contact->email == $user->email)
						Si vous avez encore des questions, n'hésitez pas à me contacter. Ma numéro de portable est {{$user->phone}} et mon adresse e-mail est {{$user->email}}. Sinon, on se voit sur place !
					@else
						Avez-vous déjà pu contacter {{$event->contact->firstname}} ? Je ne pourrai malheureusement pas être présent.
						Si quelque chose n'est pas clair, veuillez contacter {{$event->contact->firstname}} (coordonnées ci-dessous) ou moi.
						Mon numéro de portable est le {{$user->phone}} et mon adresse e-mail est {{$user->email}}.
					@endif
				@else
				  Et malheureusement, l'événement est toujours provisoire, du moins selon notre système.
					@if ($event->contact->email == $user->email)
						Si nous avons déjà clarifié la manière dont nous allons procéder, vous pouvez ignorer cet e-mail automatique. Sinon, cela m'a peut-être échappé et je vous serais reconnaissant de bien vouloir me contacter. Mon numéro de portable est {{$user->phone}} et mon adresse e-mail est {{$user->email}}.
					@else
            {{$event->contact->firstname}} et vous avez-vous déjà décidé comment vous allez procéder ? Si ce n'est pas le cas, veuillez contacter {{$event->contact->firstname}} (coordonnées ci-dessous) ou moi-même.
						Mon numéro de portable est {{$user->phone}} et mon adresse e-mail est {{$user->email}}.
					@endif
				@endif
				<br>
				<br>
				<p>Voici les détails de votre inscription :</p>
				<p>
					<ul>
						<li>
							<b>
								@if ($event->definitive)
									Personne responsable sur place :
								@else
									Responsable de l'organisation :
								@endif
							</b> {{$event->contact->firstname}} {{$event->contact->lastname}}
						</li>
						<ul>
							@if ($event->contact->phone)
								<li>
									<b>Numéro de téléphone :</b> {{$event->contact->phone}}
								</li>
							@endif
							<li>
								<b>Adresse e-mail :</b> {{$event->contact->email}}
							</li>
						</ul>
						<li>
							<b>Date :</b> {{$event->date->format("d.m.Y")}}@if ($event->getTranslatable("time", $language)), {{$event->getTranslatable("time", $language)}}@endif
						</li>
						<li>
							<b>Lieu :</b> {{$event->getTranslatable("location", $language)}}
						</li>
					</ul>
				</p>
				@if ($event->getTranslatable("description", $language))
          <p><br></p>
          <p><b>Plus d'informations sur l'événement</b></p>
          {!!$event->getTranslatable("description", $language)!!}
				@endif
				@if ($signup->additional_information)
          <p><br></p>
          <p><b>Informations supplémentaires sur votre inscription :</b></p>
          {!!$signup->additional_information!!}
				@endif
        <br/>
        <br/>
				<b>
					Cordialement
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
