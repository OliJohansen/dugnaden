<?php

$ess::$b->page = $ess::$b->page;

echo '
<div class="left_column">

	<h1>Dugnadsordningen p&aring; nett</h1>

	<div class="notebox">
		<b>Merk:</b> V&aring;re norske bokstaver &AElig;, &Oslash; og &Aring; sorteres under A.
	</div>

	<p>
		Her kan du endre dine dugnadsdatoer. I l&oslash;pet av semesteret skal alle
		beboere ha (minst) to dugnader, selvom det finnes unntak. For eksempel har elefanter
		selvsagt dugnadsfri (beboertid over 5 &aring;r).
	</p>

	<p>
		Klikker du <i>Bytte dugnad</i> under kan du velge mellom alle ledige dugnadsdatoer. Bytte av dugnadsdato
		m&aring; gj&oslash;res <u>senest 7 dager f&oslash;r</u> gjeldende dugnad.
	</p>

	<p>
		<b>Merk!</b> Det er lagt inn visse begrensninger i systemet. Dette kan føre til at du ikke får byttet dugnadsdato
		til en dugnad som er full, eller fra en dugnad som har få deltakere. Så hvis du har problemer med å få
		byttet dugnad her, ta kontakt med en av dugnadslederne så ordner vi det for deg.
	</p>

	<p>
		Ved &aring; klikke <i>Bytte passord</i> kan du endre passordet til noe som er lettere &aring; huske. Skulle
		du miste passordet eller glemme det, kan du ta kontakt med en av dugnadslederne.
	</p>


	<p>
		Det er mulig &aring; se den komplette dugnadslisten med alle beboere og deres
		dugnader uten bruk av passord. Knappen er tydelig merket nederst p&aring; siden.
	</p>

	<p>
		Legg alle kommentarer til dette systemet skriftlig i dugnadshyllen.
	</p>

	<h2>Internt bytte av dugnadsdato</h2>

	<p>
		Du kan alltid bytte dugnadsdato internt med en annen beboer. Dette betyr at dugnadsbyttet ikke blir gjort offisielt p&aring; nettsiden,
		og at dere selv er ansvarlig for at den andre (vikaren) faktisk m&oslash;ter opp. En eventuell dugnadsbot vil alltid bli gitt til den
		beboeren som st&aring;r oppf&oslash;rt p&aring; nettsiden.
	</p>

	<h2>Hyttedugnad</h2>

	<p>
		Hvis du planlegger &aring; delta p&aring; hyttedugnaden, s&aring; m&aring; samtlige dugnadsdatoer settes til <i>Hyttedugnad</i>.
		Et bytte av denne typen gjennomf&oslash;res som et vanlig dugnadsbytte ved &aring; logge inn og velge <i>hyttedugnad</i> fra nedtrekksmenyen.
	</p>

	<p>
		<b>Merk:</b> Du kan ikke velge bort en hyttedugnad! Hvis du med andre ord bytter til hyttedugnad, men unnlater &aring; m&oslash;te opp, s&aring; vil
		du etter all sannsynlighet f&aring; dugnadsbot og en ny straffedugnad.
	</p>

	<h2>Dugnad p&aring; en hverdag</h2>

	<p>
		Hvis det ikke passer med vanlig l&oslash;rdagsdugnad, kan du bytte til dagdugnad. Dagdugnad avholdes p&aring; en vanlig ukedag
		etter n&aelig;rmere avtale med Vedlikeholdsavdelingen. Kontakt vedlikeholdsavdelingen p&aring; <i>telefon 557</i> for &aring; avtale tidspunkt
		for dagdugnaden <u>minst ett d&oslash;gn</u> f&oslash;r &oslash;nsket dato. Det er kun vedlikeholdsavdelingen som kan foreta et dugnadsbytte av
		denne typen.
	</p>

	<p>
		Vennlig hilsen,<br />[gutta]
	</p>

</div>

	[db_error]

	<div class="bl_beboer">
		<div class="br_beboer">
			<div class="tl_beboer">
				<div class="tr_beboer">
					<img src="./images/password_small.gif" class="password_small" width="24px" height="24px" align="top">
					<form action="index.php" method="post" class="no_block">
					[beboer]
					Passord: <input type="password" name="pw" value="" size="15" maxlength="15">
					<input type="submit" name="do" value="Bytte dugnad">
					<input type="submit" name="do" value="Bytte passord">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="bl_green">
		<div class="br_green">
			<div class="tl_green">
				<div class="tr_green">
					<img src="./images/nopassword_small.gif" class="password_small" width="24px" height="24px" align="top">
					<form action="index.php" method="post" class="no_block">
					<input type="submit" name="do" value="Se dugnadslisten uten passord" class="right_space">
					</form>
				</div>
			</div>
		</div>
	</div>
<br><br>
	<h1>Dokumenter for nedlastning</h1>
	<p>
		Her finner du dokumenter som er gjort tilgjengelig for nedlastning.
	</p>
	<ul>
		<li><a href="../velkommen.pdf">Velkomsthefte for Blinderen Studenterhjem</a></li>
		<li><a href="../dokumenter/Statutter_BS_20.05.10.pdf">Statutter for Stiftelsen Blinderen Studenterhjem (oppdatert 20.05.2010)</a></li>
	</ul>
</div>';

return $ess::$b->page->load_template("main_html5");