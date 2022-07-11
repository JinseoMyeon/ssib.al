var shortUrl = require("node-url-shortener");

var inputUrl = ''

shortUrl.short("https://www.google.com/", function (err, url) {
    console.log(url);
});