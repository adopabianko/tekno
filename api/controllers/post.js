const postService = require('../services/post');
const logger = require('../commons/logger');
const {getCache, setCache} = require('../commons/redis');

const find = async (req, res) => {
    try {
        let category = req.query.category;

        // find by category
        if (category) {
            const postsCache = await getCache("posts:"+category).catch((err) => {
                if (err) console.error(err);
            });

            if (postsCache) {
                return res.status(200).json({
                    "code": 200,
                    "message": "List post",
                    "data": JSON.parse(postsCache),
                });
            }

            const posts = await postService.findByCategory(category);

            if (posts.length < 1){
                logger.info("Get Post");

                return res.status(404).json({
                    "code": 404,
                    "message": "Post not found"
                });
            }

            logger.info("Get Post");

            await setCache("posts:"+category, JSON.stringify(posts));

            return res.status(200).json({
                "code": 200,
                "message": "List post",
                "data": posts,
            });
        }

        // find all
        const postsCache = await getCache("posts").catch((err) => {
            if (err) console.error(err);
        });

        if (postsCache) {
            logger.info("Get Post");

            return res.status(200).json({
                "code": 200,
                "message": "List post",
                "data": JSON.parse(postsCache),
            });
        }

        const posts = await postService.findAll();

        if (posts.length < 1){
            logger.info("Get Post");

            return res.status(404).json({
                "code": 404,
                "message": "Post not found"
            });
        }

        logger.info("Get Post");

        await setCache("posts", JSON.stringify(posts));

        return res.status(200).json({
            "code": 200,
            "message": "List post",
            "data": posts,
        });
    } catch (err) {
        logger.error(err);

        return res.status(500).json({
            "code": 500,
            "message": err,
        });
    }
};

module.exports = {
    find,
};
