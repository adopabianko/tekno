const tagRepository = require('../repository/tag');

const findAll = () => {
    return tagRepository.findAll()
        .catch(err => {
            return Promise.reject(err)
        });
}

module.exports = {
    findAll
}
