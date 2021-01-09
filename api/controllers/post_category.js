'use strict';
const postCategoryService = require('../services/post_category');
const logger = require('../commons/logger');
const {getCache, setCache} = require('../commons/redis');


const find = async (req, res) => {
    try {
        const categoriesCache = await getCache("tekno_cache:post:categories").catch((err) => {
            if (err) console.error(err);
        })

        if (categoriesCache) {
            logger.info("Get Category");

            return res.status(200).json({
                "code": 200,
                "message": "List of category",
                "data": JSON.parse(categoriesCache),
            });
        }

        const categories = await postCategoryService.findAll();

        if (categories.length < 1){
            logger.info("Get Category");

            return res.status(404).json({
                "code": 404,
                "message": "Category not found",
            });
        }

        logger.info("Get Category");

        await setCache("tekno_cache:post:categories", JSON.stringify(categories));

        return res.status(200).json({
            "code": 200,
            "message": "List of category",
            "data": categories,
        });
    } catch (err) {
        logger.error(err);

        return res.status(500).json({
            "code": 500,
            "message": err,
        });
    }
}

module.exports = {
    find
};