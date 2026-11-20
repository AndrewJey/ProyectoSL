var mongoose = require('mongoose');
var mongoUri = process.env.MONGODB_URI || 'mongodb://localhost/music-player';

module.exports = {
  mongoUri: mongoUri,
  connect: function () {
    return mongoose.connect(mongoUri);
  }
};

if (require.main !== module && !process.env.SKIP_DB_CONNECT) {
  mongoose.connect(mongoUri);
}
