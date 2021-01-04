const postRepository = require('../repository/post');

const findAll = () => {
    return postRepository.findAll()
        .catch(err => {
            return Promise.reject(err)
        });
}

const findByCategory = (category) => {
    return postRepository.findByCategory(category)
        .catch(err => {
            return Promise.reject(err)
        });
}

module.exports = {
    findAll,
    findByCategory
}
