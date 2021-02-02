'use strict';
const PostService = require('../services/post');


const find = async (req, res) => {
    const postService = await PostService.find(req);

    if (postService.code != 200) {
        return res.status(postService.code).json(postService);
    }

    return res.status(postService.code).json(postService);
};

module.exports = {
    find,
};
