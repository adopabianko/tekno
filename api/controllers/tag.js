'use strict';
const TagService = require('../services/tag');

const find = async (req, res) => {
    const tagService = await TagService.findAll();

    if (tagService.code != 200) {
        return res.status(tagService.code).json(tagService);
    }

    return res.status(tagService.code).json(tagService);
}

module.exports = {
    find
};