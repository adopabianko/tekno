const log4js = require('log4js');
const logger = log4js.getLogger();
const postService = require('../services/post');
logger.level = 'debug';

const find = async (req, res) => {
    try {
        let category = req.query.category;

        // find by category
        if (category) {
            const post = await postService.findByCategory(category);

            if (post.length < 1){
                logger.info("Post data not found");

                return res.status(404).json({
                    "code": 404,
                    "message": "Post data nof found"
                });
            }

            logger.info("Get data Post")

            return res.status(200).json({
                "code": 200,
                "message": "List of data post",
                "data": post,
            });
        }

        // find all
        const posts = await postService.findAll();

        if (posts.length < 1){
            logger.info("Post data not found");

            return res.status(404).json({
                "code": 404,
                "message": "Post data nof found"
            });
        }

        logger.info("Get data Post")

        return res.status(200).json({
            "code": 200,
            "message": "List of data post",
            "data": posts,
        });
    } catch (err) {
        logger.error(err);

        return res.status(500).json({
            "code": 500,
            "message": err,
        })
    }
};

module.exports = {
    find,
};
