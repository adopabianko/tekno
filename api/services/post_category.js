const postCategoryRepository = require('../repository/post_category');

const findAll = () => {
    return postCategoryRepository.findAll()
        .catch(err => {
            return Promise.reject(err)
        });
}

module.exports = {
    findAll
}
