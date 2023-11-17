const express = require("express");
const router = express.Router();
const dotenv = require("dotenv");

dotenv.config();

// Authorization
const credentials = {
    apiKey: process.env.apiKey,
    username: process.env.username
};

const AfricasTalking = require("africastalking")(credentials);

const sms = AfricasTalking.SMS;

// send SMS route
router.post("/", (req, res) => {
    const { to, message } = req.body || res.status(400).json({error: "Both 'to' and 'message' are required"});
    sms
      .send({ to, message, enque: true })
      .then(response => {
        console.log(response);
        res.json(response);
      })
      .catch(error => {
        console.log(error);
        res.json(error.toString());
      });
  });
  

  // deliverly callback route
  router.post("/deliverly", async(req, res) => {
    console.log(req.body);

    res.status(200).json({
      status: "Success",
      message: "SMS recieved successfully"
    })
  });
  
  module.exports = router;
  