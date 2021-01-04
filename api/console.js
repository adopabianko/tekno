
const jwt = require('jsonwebtoken');
require('dotenv').config();

const generatetoken = () => {
    const token = jwt.sign({'id': 'tekno'}, process.env.TOKEN_SECRET);

    console.log(token);
}

module.exports = generatetoken();