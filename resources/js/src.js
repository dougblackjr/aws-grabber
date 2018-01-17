const apiURL = 'script/viewdata.php'

var info = new Vue({

	el: '#info',

	data: {
		channel: null,
		pageTitle: 'All Channels',
		channelList: null,
		offset: 0,
		count: 0,
		results: null
	},

	created: function () {
		this.fetchData()
	},

	watch: {
		channel: 'fetchData'
	},

	mounted: {

	},

	methods: {
		fetchData: function () {
			
			var queryString = '';

			if(this.channel) {
				queryString += '?channel=' + this.channel
				this.pageTitle = this.channel
			} else {
				this.pageTitle = 'All Channels'
			}

			if(this.offset) {
				if(queryString !== '') {
					queryString += '&offset=' + this.offset
				} else {
					queryString += '?offset=' + this.offset
				}
			}

			var xhr = new XMLHttpRequest()
			var self = this
			xhr.open('GET', apiURL + queryString)
			xhr.onload = function () {
				let results = JSON.parse(xhr.responseText)
				self.count = results.count
				self.results = results.results

				if (self.channelList === null) {
					let cNames = [];
					results.results.forEach(function(r) {
						cNames.push(r.channel)
					});

					let cNamesUnique = Array.from(new Set(cNames))

					self.channelList = cNamesUnique
				}

				console.log(results.results)
			}
			xhr.send()
		}
	}
})