'use strict';
const PostCategoryRepository = require('../repository/post_category');
const logger = require('../commons/logger');
const {getCache, setCache} = require('../commons/redis');

const findAll = async () => {
    try {
        const categoriesCache = await getCache("tekno_cache:post:categories").catch((err) => {
            if (err) console.error(err);
        })

        if (categoriesCache) {
            logger.info("Get post categories data from cache");

            return ({
                "code": 200,
                "message": "List of category",
                "data": JSON.parse(categoriesCache),
            });
        }

        const categories = await PostCategoryRepository.findAll();

        if (categories.length < 1){
            logger.info("Get post categories data not found");

            return ({
                "code": 404,
                "message": "Category not found",
            });
        }

        logger.info("Caching post categories into redis");

        await setCache("tekno_cache:post:categories", JSON.stringify(categories));

        logger.info("Get post categories data from db");

        return ({
            "code": 200,
            "message": "List of category",
            "data": categories,
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
    findAll
}
