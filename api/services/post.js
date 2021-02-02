'use strict';
const PostRepository = require('../repository/post');
const logger = require('../commons/logger');
const {getCache, setCache} = require('../commons/redis');

const find = async (req) => {
    try {
        let category = req.query.category;

        // find by category
        if (category) {
            const postsCache = await getCache("tekno_cache:posts:"+category).catch((err) => {
                if (err) console.error(err);
            });

            if (postsCache) {
                return ({
                    "code": 200,
                    "message": "List post",
                    "data": JSON.parse(postsCache),
                });
            }

            const posts = await PostRepository.findByCategory(category);

            if (posts.length < 1){
                logger.info("Get Post");

                return ({
                    "code": 404,
                    "message": "Post not found"
                });
            }

            logger.info("Get Post");

            await setCache("tekno_cache:posts:"+category, JSON.stringify(posts));

            return ({
                "code": 200,
                "message": "List post",
                "data": posts,
            });
        }

        // find all
        const postsCache = await getCache("tekno_cache:posts").catch((err) => {
            if (err) console.error(err);
        });

        if (postsCache) {
            logger.info("Get Post");

            return ({
                "code": 200,
                "message": "List post",
                "data": JSON.parse(postsCache),
            });
        }

        const posts = await PostRepository.findAll();

        if (posts.length < 1){
            logger.info("Get Post");

            return ({
                "code": 404,
                "message": "Post not found"
            });
        }

        logger.info("Get Post");

        await setCache("tekno_cache:posts", JSON.stringify(posts));

        return ({
            "code": 200,
            "message": "List post",
            "data": posts,
        });
    } catch (err) {
        logger.error(err);

        return ({
            "code": 500,
            "message": err,
        });
    }
}

module.exports = {
    find
}
