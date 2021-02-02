'use strict';
const TagRepository = require('../repository/tag');
const {getCache, setCache} = require('../commons/redis');
const logger = require('../commons/logger');

const findAll = async () => {
    try {
        const tagsCache = await getCache("tekno_cache:tags").catch((err) => {
            if (err) console.error(err);
        });

        if (tagsCache) {
            logger.info("Get tag data from cache");

            return ({
                "code": 200,
                "message": "List of Tag",
                "data": JSON.parse(tagsCache),
            });
        }

        const tags = await TagRepository.findAll();
        
        if (tags.length < 1) {
            logger.info("Tag not found");

            return ({
                "code": 404,
                "message": "Tag not found",
            });    
        }

        logger.info("Caching tag into redis");

        await setCache("tekno_cache:tags", JSON.stringify(tags));

        logger.info("Get category data from db");

        return ({
            "code": 200,
            "message": "List of Tag",
            "data": result,
        });
    } catch(err) {
        logger.error(err);

        return ({
            "code": 500,
            "message": err
        });
    }
}

module.exports = {
    findAll
}
