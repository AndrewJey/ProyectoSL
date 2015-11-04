var mongoose = require('mongoose');  
var songSchema = new mongoose.Schema({  
  name: String,
  path: String,
  genre: String,
  artist: String
});

mongoose.model('Song', songSchema);