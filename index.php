<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="This page looks so good you should hire Doug Black!">
		<meta name="author" content="Doug Black">

		<!-- CSS -->
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css"> -->
		<link rel="stylesheet" href="resources/css/styles.css">
		<!-- script -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
	</head>
	<body class="theme-page">
		<div id="info">
			<section class="hero is-primary">
				<div class="hero-head">
					<nav class="main-nav nav has-shadow">
						<div class="container">
							<div class="nav-left">
								<h1 class="title is-5">AWS Watch</h1>
								<div class="nav-item">
									<span class="theme-switcher select">
										<select :value="channel" name="channel" v-model="channel">
											<option value="" disabled="" selected="">All!</option>
											<template v-for="cname in channelList">
												<option :for="cname">{{ cname }}</option>
											</template>
										</select>
									</span>
								</div>
								<a class="nav-item " href="https://jenil.github.io/bulmaswatch/help/">Help</a>
							</div>
							<span class="nav-toggle">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</div>
					</nav>
				</div>
				<!-- Hero content: will be in the middle -->
				<div class="hero-body">
					<div class="container">
						<h1 class="title">Information on {{ channel }}</h1>
					</div>
				</div>
			</section>
			<div class="columns">
				<section class="section">
					<h1></h1>
					<ul>
						<li v-for="result in results">
							{{ result.created_at}}
							<br />
							{{ result.status_message }}
						</li>
					</ul>
				</section>
			</div>
		</div>
	</body>
	<script src="resources/js/src.js"></script>

</html>