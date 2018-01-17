var info = new Vue({

	el: '#info',

	data: {
		channel: null,
		offset: 0,
		count: 0,
		results: null
	},

	created: function () {
		this.fetchData()
	},

	watch: {
		currentChannel: 'fetchData'
	},

	mounted: {

	},

	methods: {
		fetchData: function () {
			var xhr = new XMLHttpRequest()
			var self = this
			xhr.open('GET', apiURL + self.currentBranch)
			xhr.onload = function () {
				self.commits = JSON.parse(xhr.responseText)
				console.log(self.commits[0].html_url)
			}
			xhr.send()
		}
	}
})