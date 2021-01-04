const models = require('../models');

const findAll = () => {
    return models.Tag.findAll({
        attributes: [
            'name',
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
