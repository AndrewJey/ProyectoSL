var express = require('express'),
	router = express.Router(),
	mongoose = require('mongoose'),
  multer = require('multer'),
  fs = require('fs'),
	bodyParser = require('body-parser'),
	methodOverride = require('method-override');


  var mwMulter = multer({ dest: './uploads/videos',
    limits: {
    fileSize: 20485760,
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

  router.use(bodyParser.urlencoded({ extended: true}))
  router.use(methodOverride(function(req,res){
	if (req.body &&  typeof req.body === 'object' && '_method' in req.body) {
		var method = req.body._method
		delete req.body._method
		return method
	}
}))


router.route('/')
    //GET all blobs
    .get(function(req, res, next) {
        //retrieve all blobs from Monogo
        mongoose.model('Video').find({}, function (err, videos) {
              if (err) {
                  return console.error(err);
              } else {
                  //respond to both HTML and JSON. JSON responses require 'Accept: application/json;' in the Request Header
                  res.format({
                      //HTML response will render the index.jade file in the views/blobs folder. We are also setting "blobs" to be an accessible variable in our jade view
                    html: function(){
                        res.render('videos/index', {
                              title: 'All Videos',
                              "videos" : videos
                          });
                    },
                });
              }     
        });
    })
    //POST a new blob
    .post(mwMulter, function(req, res) {
        if (req.files.path.truncated) {
          req.flash('error', 'Error the file is too large');
          res.render('videos/new', { title: 'Add New Video' });
        }
        else{
          // Get values from POST request. These can be done through forms or REST calls. These rely on the "name" attributes for forms
          var name = req.body.name;
          var path = req.files.path.path;
          var genre = req.body.genre;
          var newpath = path.split('/');
          delete newpath[0];
          newpath[1] = newpath[1] + '/';
          var finalpath = newpath.join('');
          //call the create function for our database
          mongoose.model('Video').create({
            name : name,
            path : finalpath,
            genre : genre,
          }, function (err, video) {
              if (err) {
                  res.send("There was a problem adding the information to the database.");
              } else {
                  //Blob has been created
                  console.log('POST creating new video: ' + video);
                  res.format({
                      //HTML response will set the location and redirect back to the home page. You could also create a 'success' page if that's your thing
                    html: function(){
                        // If it worked, set the header so the address bar doesn't still say /adduser
                        res.location("videos");
                        // And forward to success page
                        res.redirect("/videos");
                    }
                });
              }
          })
        }
    });

router.get('/new', function(req, res) {
  res.render('videos/new', { title: 'Add New Video' });
});

// route middleware to validate :id
router.param('id', function(req, res, next, id) {

    //find the ID in the Database
    mongoose.model('Video').findById(id, function (err, video) {
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
  mongoose.model('Video').findById(req.id, function (err, video) {
    if (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
    } else {
      console.log('GET Retrieving ID: ' + video._id);

      res.render('videos/show', { "video" : video });
    }
  });
});

router.get('/:id/edit', function(req, res) {

  mongoose.model('Video').findById(req.id, function (err, video) {
    if (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
    } else {
            //Return the video
            console.log('GET Retrieving ID: ' + video._id);
            
            res.render('videos/edit', {
              title: 'Video' + video._id,
              "video" : video
            });
          }
        });
});

router.put('/:id/edit', function(req, res) {
    // Get our form values.
    var name = req.body.name;
    var genre = req.body.genre;

   //find the document by ID
   mongoose.model('Video').findById(req.id, function (err, video) {
            //update it
            video.update({
              name : name,
              path : video.path,
              genre : genre,
            }, function (err, videoID) {
              if (err) {
               res.send("There was a problem updating the information to the database: " + err);
             } 
             else {
               res.redirect("/videos/" + video._id);
             }
           })
          });
 });

router.delete('/:id/delete', function (req, res){
    //find song by ID
  mongoose.model('Video').findById(req.id, function (err, video) {
    if (err) {
      return console.error(err);
    } else {
          //remove it from Mongo
          video.remove(function (err, video) {
            if (err) {
              return console.error(err);
            } else {
              var path = 'uploads/' + video.path;
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
                  console.log('DELETE removing ID: ' + video._id);
                  res.redirect("/videos");
                }
              });
        }
      });
});


module.exports = router;