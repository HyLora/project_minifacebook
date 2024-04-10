<?php
session_start();
if (!isset($_SESSION["tipo"])) {
	$risultato = array("status" => "ko", "msg" => "");
	$risultato["status"] = "ko";
	$risultato["msg"] = "Devi prima eseguire l'accesso!";
	header("location:../index.php?status=ko&msg=" . urlencode($risultato["msg"]));
	return $risultato;
} else {
	$nome = "statistiche";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Statistiche Utenti</title>
	<!-- Includi la libreria Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php require "../common/header.php";
require "../backend/statistiche-exe.php"; ?>
<link href="../css/styles.css" rel="stylesheet" />

<body class="d-flex flex-column h-100">
	<main class="flex-shrink-0">
		<!-- Navigation-->

		<?php require "../common/navbar.php";

		if (isset($_GET["status"])) {
			if ($_GET["status"] == "ko") {
				echo "<div class='alert alert-warning'>\n";
				echo $_GET["msg"];
				echo "</div>";
			} else {
				echo "<div class='alert alert-success'>\n";
				echo $_GET["msg"];
				echo "</div>";
			}
		}

		include_once "../common/connection.php";
		include_once "../common/funzioni.php";
		?>
	</main>


	<h1>Statistiche Utenti</h1>

	<div class="chart-grid">
		<div class="chart-container">
			<canvas id="myChart" width="400" height="400"></canvas>
		</div>
		<div class="chart-container">
			<canvas id="messagesPerUserChart" width="400" height="400"></canvas>
		</div>
		<div class="chart-container">
			<canvas id="friendsPerUserChart" width="400" height="400"></canvas>
		</div>
		<div class="chart-container">
			<canvas id="messagesPerUserChart2" width="400" height="400"></canvas>
		</div>
	</div>

	<script>
		// Codice per ottenere i dati del grafico "Messaggi per Utente"
		var userData = <?php echo json_encode($messagesStatistics); ?>;
		var userLabels = Object.keys(userData);
		var minMessages = userLabels.map(function (label) {
			return userData[label].min_messages;
		});
		var maxMessages = userLabels.map(function (label) {
			return userData[label].max_messages;
		});
		var avgMessages = userLabels.map(function (label) {
			return userData[label].avg_messages;
		});

		// Configurazione del grafico "Messaggi per Utente"
		var ctxMessagesPerUser = document.getElementById('messagesPerUserChart2').getContext('2d');
		var messagesPerUserChart = new Chart(ctxMessagesPerUser, {
			type: 'bar',
			data: {
				labels: userLabels,
				datasets: [{
					label: 'Min Messages',
					data: minMessages,
					backgroundColor: 'rgba(255, 99, 132, 0.5)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
				},
				{
					label: 'Max Messages',
					data: maxMessages,
					backgroundColor: 'rgba(54, 162, 235, 0.5)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				},
				{
					label: 'Avg Messages',
					data: avgMessages,
					backgroundColor: 'rgba(75, 192, 192, 0.5)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				}
				]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});

		// Codice per ottenere i dati del grafico
		var totalComments = <?php echo ($total_comments) ?>;
		var totalMessages = <?php echo ($total_messages) ?>;
		var totalFriends = <?php echo isset($total_friends) ? $total_friends : 0; ?>;

		// Configurazione del grafico 1
		var ctx1 = document.getElementById('myChart').getContext('2d');
		var myChart1 = new Chart(ctx1, {
			type: 'pie',
			data: {
				labels: ['Commenti', 'Messaggi'],
				datasets: [{
					label: 'Statistiche',
					data: [totalComments, totalMessages],
					backgroundColor: [
						'rgba(255, 99, 132, 0.5)',
						'rgba(54, 162, 235, 0.5)',
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: false,
				maintainAspectRatio: false,
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
		
		// Codice per ottenere i dati del grafico 2
		<?php
		$user_labels_json = json_encode($user_labels);
		$message_counts_json = json_encode($message_counts);
		?>

		var user_labels = <?php echo $user_labels_json; ?>;
		var message_counts = <?php echo $message_counts_json; ?>;


		// Configurazione del grafico 2
		var ctx2 = document.getElementById('messagesPerUserChart').getContext('2d');
		var myChart2 = new Chart(ctx2, {
			type: 'bar',
			data: {
				labels: user_labels, 
				datasets: [{
					label: 'Numero di Messaggi per Utente',
					data: message_counts,
					backgroundColor: 'rgba(255, 99, 132, 0.5)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
				}]
			},
			options: {
				responsive: false,
				maintainAspectRatio: false,
				scales: {
					y: {
						beginAtZero: false
					}
				}
			}
		});

		// Codice per ottenere i dati del grafico 3
		var friends_labels = <?php echo json_encode($friends_labels); ?>;
		var friend_counts = <?php echo json_encode($friend_counts); ?>;

		// Configurazione del grafico 3
		var ctx3 = document.getElementById('friendsPerUserChart').getContext('2d');
		var myChart3 = new Chart(ctx3, {
			type: 'bar',
			data: {
				labels: friends_labels,
				datasets: [{
					label: 'Numero di Amici per Utente',
					data: friend_counts, 
					backgroundColor: 'rgba(75, 192, 192, 0.5)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				}]
			},
			options: {
				responsive: false,
				maintainAspectRatio: false,
				scales: {
					y: {
						beginAtZero: false
					}
				}
			}
		});


	</script>
	<!-- Visualizzazione delle statistiche aggiuntive in una tabella -->
	<h2>Statistiche aggiuntive</h2>
	<table border="1">
		<tr>
			<th>Tipologia</th>
			<th>ID Utente</th>
			<th>Quantità</th>
		</tr>
		<tr>
			<td>Utente con più voti</td>
			<td>
				<?php echo $most_voted_user_id; ?>
			</td>
			<td>
				<?php echo $most_voted_user_votes; ?>
			</td>
		</tr>
		<tr>
			<td>Utente con più commenti</td>
			<td>
				<?php echo $most_commented_user_id; ?>
			</td>
			<td>
				<?php echo $most_commented_user_comments; ?>
			</td>
		</tr>
		<tr>
			<td>Utente con più messaggi</td>
			<td>
				<?php echo $most_messaged_user_id; ?>
			</td>
			<td>
				<?php echo $most_messaged_user_messages; ?>
			</td>
		</tr>
		<tr>
			<td>Utente con più amici</td>
			<td>
				<?php echo $most_friends_user_id; ?>
			</td>
			<td>
				<?php echo $most_friends_user_count; ?>
			</td>
		</tr>
	</table>
	<!-- 5 miglior utenti -->
	<h3>Utenti più rispettabili</h3>
	<table border="1">
		<?php
		// Verifica se la query ha restituito dei risultati
		if ($res_best_users && $res_best_users->num_rows > 0) {
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Email</th>";
			echo "<th>LivelloDiRispettabilita</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";

			// Itera attraverso i risultati della query e stampa ciascun utente nella tabella
			while ($row_best_users = $res_best_users->fetch_assoc()) {
				echo "<tr>";
				echo "<td>" . $row_best_users['email'] . "</td>";
				echo "<td>" . $row_best_users['LivelloDiRispettabilita'] . "</td>";
				echo "</tr>";
			}

			echo "</tbody>";
			echo "</table>";
		} else {
			// Messaggio di avviso se la query non ha restituito risultati
			$risultato["status"] = "ko";
			$risultato["msg"] = "La query per gli utenti più rispettabili non ha restituito risultati.";
			echo "<div class='alert alert-warning'>\n";
			echo $risultato["msg"];
			echo "</div>";
		}

		?>
	</table>
</body>
<!-- Footer-->
<?php require "../common/footer.php"; ?>

</html>