<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Your registration for the race was created successfully</title>
</head>
<body>
	<header>
		<h1>Ahoj {{$registration->firstname}},</h1><br />
		<h2>nyní jsi přihlášen na závod Malá cena Velké Verandy.</h2>
	</header>
	<section>
		<p>Startovní číslo: {{$registration->bib_nr}}</p>
		<p>Přejeme hodně zdaru.</p>
	</section>

	<aside>
	</aside>

	<footer>
		<p>&copy; Copyright {{date('Y', time())}} Chytrý Oddíl</p>
	</footer>

</body>
</html>