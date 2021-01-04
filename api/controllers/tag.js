const log4js = require('log4js');
const logger = log4js.getLogger();
const tagService = require('../services/tag');
logger.level = 'debug';

const find = async (req, res) => {
    try {
        // find all
        const tags = await tagService.findAll();

        if (tags.length < 1){
            logger.info("Get Tag");

            return res.status(404).json({
                "code": 404,
                "message": "Tag not found"
            });
        }

        logger.info("Get Tag")

        return res.status(200).json({
            "code": 200,
            "message": "List of Tag",
            "data": tags,
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