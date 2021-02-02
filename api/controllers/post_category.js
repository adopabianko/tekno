'use strict';
const PostCategoryService = require('../services/post_category');

const find = async (req, res) => {
    const postCategoryService = await PostCategoryService.findAll();

    if (postCategoryService.code != 200) {
        return res.status(postCategoryService.code).json(postCategoryService);
    }

    return res.status(postCategoryService.code).json(postCategoryService);
}

module.exports = {
    find
};