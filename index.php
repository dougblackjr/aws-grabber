<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="This page looks so good you should hire Doug Black!">
		<meta name="author" content="Doug Black">

		<!-- script -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
	</head>

	<body>
		<h1>AWS Info</h1>
		<div id="info">
			<input type="select"
				:id="branch"
				:value="branch"
				name="branch"
				v-model="currentChannel">
			<option value="all"></option>
			<template v-for="branch in branches">
				<option :for="branch">{{ branch }}</label>
			</template>
			<p>{{ currentBranch }}</p>
			<ul>
				<li v-for="record in commits">
					<a :href="record.html_url" target="_blank" class="commit">{{ record.sha.slice(0, 7) }}</a>
					- <span class="message">{{ record.commit.message | truncate }}</span><br>
					by <span class="author"><a :href="record.author.html_url" target="_blank">{{ record.commit.author.name }}</a></span>
					at <span class="date">{{ record.commit.author.date | formatDate }}</span>
				</li>
			</ul>
		</div>
	</body>
	<script src="resources/js/src.js"></script>

</html>