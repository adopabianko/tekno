'use strict';

const redis = require('redis');
const { promisify } = require("util");
const client = redis.createClient({
  host: process.env.REDIS_HOST,
  port: process.env.REDIS_PORT
});

client.on('connect', () => {
    console.log('Redis client connected');
});

client.on("error", function(error) {
    console.error(error);
});

const getCache = promisify(client.get).bind(client);
const setCache = promisify(client.set).bind(client);

module.exports = {
    getCache,
    setCache,
};