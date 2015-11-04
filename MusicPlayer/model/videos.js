var mongoose = require('mongoose');
var videoSchema = new mongoose.Schema({
	name: String,
  	path: String,
  	genre: String,
});

mongoose.model('Video', videoSchema);