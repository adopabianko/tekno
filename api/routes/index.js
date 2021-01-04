const express = require('express');
const router = express.Router();
const {validateToken} = require('../middleware//token');
const postController = require('../controllers/post');

router.get('/', function(req, res) {
    res.json('Tekno Api');
});
router.get('/post', postController.find);

module.exports = router;
