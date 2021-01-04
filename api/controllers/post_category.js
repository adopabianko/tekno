const log4js = require('log4js');
const logger = log4js.getLogger();
const postCategoryService = require('../services/post_category');
logger.level = 'debug';

const find = async (req, res) => {
    try {
        // find all
        const categories = await postCategoryService.findAll();

        if (categories.length < 1){
            logger.info("Get Category");

            return res.status(404).json({
                "code": 404,
                "message": "Category not found"
            });
        }

        logger.info("Get Category")

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