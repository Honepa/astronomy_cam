<?php $menu = 'relay'; ?>
<?php include 'include/head.php'; ?>
<?php

if (!isset($_SESSION['user'])) {
	die('Страница недоступна');
}

$relays = [];

foreach ($config['relay'] as $relay) {
	$relays[ $relay['gpio'] ] = intval(trim(file_get_contents('/sys/class/gpio/gpio'. $relay['gpio'] .'/value')));
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

	<h1 class="h2">Реле</h1>
</div>

<p> Настоящее значение уровней </p>

<?php
system('ls')
?>

<p> Задать новые значения уровнейБ</p>

<form action="action_relay.php" method='post'>
    <p> T1H - <input type="number" name='T1H' /> </p>
    <p> T1L - <input type="number" name="T1L" /> </p>
    <p> T2H - <input type="number" name="T2H" /> </p>
    <p> T2L - <input type="number" name="T2L" /> </p>
    <imput type = "submit" />
</form>

<form method="post">
    <input type="submit" name="rele1_on" value="Relay 1 ON" /> <br/>
    <imput type="submit" name="rele1_off" value="Relay 1 OFF" /> <br />
    <input type="submit" name="rele2_on" value="Relay 2 ON" /> <br />
    <input type="submit" name="rele2_off" value="Relay 2 OFF" /> <br />
</form>

<?php
function rele1_on()
{
    echo "rele 1 on"
}
function rele1_off()
{
    echo "rele 1 off"
}
function rele2_on()
{
    echo "rele 2 on"
}
function rele2_off()
{
    echo "rele 2 off"
}
if (array_key_exists('rele1_on', $_POST))
{
    rele1_on()
}

if (array_key_exists('rele1_off', $_POST))
{
    rele1_off()
}
if (array_key_exists('rele2_on', $_POST))
{
    rele2_on()
}
if (array_key_exists('rele2_off', $_POST))
{
    rele2_off()
}
?>

<script>
	$(document).ready(function(){
		$('a.relay').click(function(e){
			e.preventDefault();
			
			if (confirm(
				'Вы уверены, что хотите '+
				($(this).hasClass('btn-success') ? 'ВЫКЛЮЧИТЬ' : 'ВКЛЮЧИТЬ' ) +
				' реле "'+ $(this).text().trim() +'"?'
			)) {

				$.post('', {
					'action': 'relay',
					'gpio':   $(this).attr('rel'),
					'state':  $(this).hasClass('btn-success') ? 0 : 1
				}, function(data){
					
					document.location.reload();
					
				}, 'json');
			}
		});
	})
</script>

<?php include 'include/tail.php'; ?>
