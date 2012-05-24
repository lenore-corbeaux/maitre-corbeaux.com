document.getElementById('form-search').onsubmit = function() {
	var url = this.action;
	var query = document.getElementById('query');
	url += '/' + encodeURIComponent(query.value);
	self.location = url;
    return false;
};