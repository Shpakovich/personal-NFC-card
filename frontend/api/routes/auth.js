const express = require('express');
const router = express.Router();
const cookieParser = require("cookie-parser");
const expressJwt = require("express-jwt");
const jsonwebtoken = require("jsonwebtoken");
var bodyParser = require('body-parser');
var jsonParser = bodyParser.json();

const app = express();
app.use(cookieParser());

app.use(
  expressJwt({
    secret: "secret",
    algorithms: ['RS256']
  }).unless ({
    path: "/api/auth/login"
  })
);


router.post("/auth/login", jsonParser, async (req, res) => {
  jsonwebtoken.sign(
    { user: req.body.user },
    "secret",
    { expiresIn: "55m" },
    function(err, token) {
      res.json({
        token: token, user: req.body.user
      });
    });
});

router.get("/auth/user", async (req, res) => {
  const token = jsonwebtoken.decode(req.headers.authorization.split(" ")[1]);
  res.json({
    user: token.user
  });
});

module.exports = router;
