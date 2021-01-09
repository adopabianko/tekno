'use strict';
const models = require('../models');

const findAll = () => {
    return models.PostCategory.findAll({
        attributes: [
            'name',
            'slug',
            'description',
            'parent',
            ['created_at', 'created_at'],
        ],
        where: {
            status: 1
        },
        order: [['id', 'desc']]
    })
    .catch(err => {
        return Promise.reject(err)
    });
}

module.exports = {
    findAll
}
