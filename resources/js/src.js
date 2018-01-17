const apiURL = '../script/viewdata.php'

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
			
			var queryString = '';

			if(this.channel) {
				queryString += '?channel=' + this.channel
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
				self.results = JSON.parse(xhr.responseText)
				console.log(self.results)
			}
			xhr.send()
		}
	}
})