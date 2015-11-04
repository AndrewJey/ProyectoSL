var express = require('express'),
router = express.Router(),
multer = require('multer'),
fs = require('fs'),
mongoose = require('mongoose'), //mongo connection
bodyParser = require('body-parser'), //parses information from POST
methodOverride = require('method-override'); //used to manipulate POST

var mwMulter = multer({ dest: './uploads/songs',
  limits: {
  fileSize: 10194304,
  files: 1
  },
  onFileSizeLimit: function (file) {
  console.log(file.originalname + ' is too big, upload aborted')
  fs.unlink('./' + file.path) 
  },
  rename: function (fieldname, filename) {
    return filename;
  },
  onFileUploadStart: function (file) {
  console.log(file.originalname + ' is starting ...')
  },
  onFileUploadComplete: function (file) {
  console.log(file.fieldname + ' uploaded to  ' + file.path)
  done=true;
  }
});


    router.use(bodyParser.urlencoded({ extended: true }))
    router.use(methodOverride(function(req, res){
      if (req.body && typeof req.body === 'object' && '_method' in req.body) {
        // look in urlencoded POST bodies and delete it
        var method = req.body._method
        delete req.body._method
        return method
      }
    }))

  router.route('/')
    //GET all songs
    .get(function(req, res, next) {
        //retrieve all songs from Mongo
        mongoose.model('Song').find({}, function (err, songs) {
          if (err) {
            return console.error(err);
          } else {

                  res.render('songs/index', {
                  title: 'All Songs',
                  "songs" : songs,
                  layout : false
                  });
                }     
              });
      })

    //POST a new song
      .post(mwMulter, function(req, res) {
        
        if (req.files.path.truncated) {
          req.flash('error', 'Error the file is too large');
          res.render('songs/new', { title: 'Add New Song' });
        }
        else{
          // Get values from POST request.
          var name = req.body.name;
          var path = req.files.path.path;
          var genre = req.body.genre;
          var artist = req.body.artist;
          var newpath = path.split('/');
          delete newpath[0];
          newpath[1] = newpath[1] + '/';
          var finalpath = newpath.join('');
          //call the create function for our database
          mongoose.model('Song').create({
            name : name,
            path : finalpath,
            genre : genre,
            artist : artist
          }, function (err, song) {
              if (err) {
                  res.send("There was a problem adding the information to the database.");
              } else {
                  //Song has been created
                  console.log('POST creating new song: ' + song);

                  res.redirect("/songs");
              }
          })
        }
      });


/* GET New Song page. */
router.get('/new', function(req, res) {
  res.render('songs/new', { title: 'Add New Song' });
});

// route middleware to validate :id
router.param('id', function(req, res, next, id) {

    //find the ID in the Database
    mongoose.model('Song').findById(id, function (err, song) {
        //if it isn't found, we are going to repond with 404
        if (err) {
          console.log(id + ' was not found');
          res.status(404)
          var err = new Error('Not Found');
          err.status = 404;
          res.format({
            html: function(){
              next(err);
            }
          });
        //if it is found we continue on
      } else {

            // once validation is done save the new item in the req
            req.id = id;
            // go to the next thing
            next(); 
          } 
        });
  });

router.route('/:id')
.get(function(req, res) {
  mongoose.model('Song').findById(req.id, function (err, song) {
    if (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
    } else {
      console.log('GET Retrieving ID: ' + song._id);

      res.render('songs/show', { "song" : song });

    }
  });
});

//GET the individual song
router.get('/:id/edit', function(req, res) {

  mongoose.model('Song').findById(req.id, function (err, song) {
    if (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
    } else {
            //Return the song
            console.log('GET Retrieving ID: ' + song._id);
            
            res.render('songs/edit', {
              title: 'Song' + song._id,
              "song" : song
            });
          }
        });
});


//PUT to update a song by ID
router.put('/:id/edit', function(req, res) {
    // Get our form values.
    var name = req.body.name;
    var genre = req.body.genre;
    var artist = req.body.artist;

   //find the document by ID
   mongoose.model('Song').findById(req.id, function (err, song) {
            //update it
            song.update({
              name : name,
              path : song.path,
              genre : genre,
              artist : artist
            }, function (err, songID) {
              if (err) {
               res.send("There was a problem updating the information to the database: " + err);
             } 
             else {
               res.redirect("/songs/" + song._id);
             }
           })
          });
 });


//DELETE a Song by ID
router.delete('/:id/delete', function (req, res){
    //find song by ID
    mongoose.model('Song').findById(req.id, function (err, song) {
      if (err) {
        return console.error(err);
      } else {
            //remove it from Mongo
            song.remove(function (err, song) {
              if (err) {
                return console.error(err);
              } else {
                var path = 'uploads/' + song.path;
                    fs.unlink(path, function(err){
                      //comprobamos si ha ocurrido algun error
                      if(err){
                          console.error(err);
                      }
                      
                      else{
                          console.log("fichero eliminado");
                      }
                    });
                    //Returning success messages saying it was deleted
                    console.log('DELETE removing ID: ' + song._id);
                    res.redirect("/songs");

                  }
                });
          }
        });
  });


module.exports = router;