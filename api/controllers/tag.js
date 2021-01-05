const tagService = require('../services/tag');
const logger = require('../commons/logger');
const {getCache, setCache} = require('../commons/redis');

const find = async (req, res) => {
    try {
        const tagsCache = await getCache("tags").catch((err) => {
            if (err) console.error(err);
        });

        if (tagsCache) {
            logger.info("Get Tag");

            return res.status(200).json({
                "code": 200,
                "message": "List of Tag",
                "data": JSON.parse(tagsCache),
            });
        }

        const tags = await tagService.findAll();

        if (tags.length < 1){
            logger.info("Get Tag");

            return res.status(404).json({
                "code": 404,
                "message": "Tag not found",
            });
        }

        logger.info("Get Tag");

        await setCache("tags", JSON.stringify(tags));

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