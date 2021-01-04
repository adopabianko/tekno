const express = require('express');
const router = express.Router();
const {validateToken} = require('../middleware//token');
const postController = require('../controllers/post');
const postCategoryController = require('../controllers/post_category');
const tagController = require('../controllers/tag');

router.get('/', function(req, res) {
    res.json('Tekno Api');
});
router.get('/post', postController.find);
router.get('/post/category', postCategoryController.find);
router.get('/post/tag', tagController.find);

module.exports = router;
