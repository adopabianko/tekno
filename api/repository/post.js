const models = require('../models');

const findAll = () => {
    return models.Post.findAll({
        attributes: [
            'title',
            'slug',
            'content',
            'cover',
            ['created_at', 'created_at'],
        ],
        where: {
            status: 2
        },
        include: [
            {
                model: models.PostCategory,
                attributes: ['name'],
                as: 'category',
            },
            {
                model:models.Tag,
                attributes: ['name'],
                as: 'tags',
                through: {
                    attributes: [],
                }
            }
        ],
        order: [['id', 'desc']]
    })
    .catch(err => {
        return Promise.reject(err)
    });
}

const findByCategory = (category) => {
    return models.Post.findAll({
        attributes: [
            'title',
            'slug',
            'content',
            'cover',
            ['created_at', 'created_at'],
        ],
        where: {
            status: 2
        },
        include: [
            {
                model: models.PostCategory,
                attributes: ['name'],
                as: 'category',
                where: {
                    slug: category
                }
            },
            {
                model:models.Tag,
                attributes: ['name'],
                as: 'tags',
                through: {
                    attributes: [],
                }
            }
        ],
        order: [['id', 'desc']]
    })
    .catch(err => {
        return Promise.reject(err)
    });
}

module.exports = {
    findAll,
    findByCategory
}
