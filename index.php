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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- script -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
	</head>
	<body class="theme-page">
		<div id="info">
			<section class="hero is-primary">
				<div class="hero-head">
					<nav class="main-nav nav has-shadow">
						<div class="container">
							<div class="nav-item">
								<h1 class="title">AWS Watch</h1>
							</div>
						</div>
					</nav>
				</div>
				<!-- Hero content: will be in the middle -->
				<div class="hero-body">
					<div class="container">
						<div class="columns">
							<div class="column">
								<span class="theme-switcher select">
									<label for="channel">Choose a channel</label>
									<select :value="channel" name="channel" v-model="channel">
										<option value="" selected="">Choose a channel</option>
										<template v-for="cname in channelList">
											<option :for="cname">{{ cname }}</option>
										</template>
									</select>
								</span>	
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="section">
				<div class="columns">
					<div class="column">
						<div class="notification">
							<p>{{count}} results for {{ pageTitle }}</p>
						</div>
						<div v-for="result in results">
							<div v-bind:class="'notification ' + result.status_style">
								<div v-if="count > 0">
									<h2 class="title"><span v-if="result.title !== null" class="icon has-text-warning"><i class="fa fa-exclamation-triangle"></i>&nbsp;</span>{{ result.status_message }}</h2>
									<p>Channel: {{ result.channel }}</p>
									<h4 v-if="result.title !== null">{{ result.title}}: {{ result.description }}</h4>
									<p>Date: {{ result.date }}</p>
								</div>
								<div v-else>
									<h2>No results for this query. ({{count}})</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</body>
	<script src="resources/js/src.js"></script>

</html>