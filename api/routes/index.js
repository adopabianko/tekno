const express = require('express');
const router = express.Router();
const {validateToken} = require('../middleware//token');
const postController = require('../controllers/post');
const postCategoryController = require('../controllers/post_category');
const tagController = require('../controllers/tag');

router.get('/', function(req, res) {
    res.json('Tekno Api');
});
router.get('/post', validateToken, postController.find);
router.get('/post/category', validateToken, postCategoryController.find);
router.get('/post/tag', validateToken, tagController.find);

module.exports = router;
